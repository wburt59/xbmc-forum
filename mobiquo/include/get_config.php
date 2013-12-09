<?php

defined('IN_MOBIQUO') or exit;

function get_config_func()
{
    global $mobiquo_config, $mybb, $cache;
    
    $config_list = array(
        'sys_version'   => new xmlrpcval($mybb->version, 'string'),
        'version'       => new xmlrpcval($mobiquo_config['version'], 'string'),
        'is_open'       => new xmlrpcval(isset($cache->cache['plugins']['active']['tapatalk']), 'boolean'),
        'guest_okay'    => new xmlrpcval($mybb->usergroup['canview'] && $mybb->settings['boardclosed'] == 0, 'boolean'),
    );
    if(!isset($cache->cache['plugins']['active']['tapatalk']))
    {
    	$config_list['is_open'] = new xmlrpcval(false,'boolean');
        $config_list['result_text'] = new xmlrpcval(basic_clean('Tapatalk is disabled'), 'base64');
    }
    if ($mybb->settings['boardclosed'])
    {
    	$config_list['is_open'] = new xmlrpcval(false,'boolean');
        $config_list['result_text'] = new xmlrpcval(basic_clean($mybb->settings['boardclosed_reason']), 'base64');
    }
    
    // First, load the stats cache.
	$stats = $cache->read("stats");
	$config_list['stats'] = new xmlrpcval(array(
        'topic'    => new xmlrpcval($stats['numthreads'], 'int'),
        'user'     => new xmlrpcval($stats['numusers'], 'int'),
    ), 'struct');
    
    if ($mybb->settings['tapatalk_reg_url'])
    {
        $config_list['reg_url'] = new xmlrpcval(basic_clean($mybb->settings['tapatalk_reg_url']), 'string');
    }
    if(version_compare($mybb->version, '1.6.9','>=') && !$mybb->settings['disableregs'])
    {
    	$config_list['inappreg'] = new xmlrpcval(1, 'string');
    }
    
	if (!function_exists('curl_init') && !@ini_get('allow_url_fopen'))
	{
	    $mobiquo_config['sign_in'] = 0;
	    $mobiquo_config['inappreg'] = 0;
	    $mobiquo_config['inappsignin'] = 0;
	}
	
    foreach($mobiquo_config as $key => $value){
        if(!array_key_exists($key, $config_list) && $key != 'thlprefix'){
            $config_list[$key] = new xmlrpcval($value, 'string');
        }
    }

    if (!$mybb->user['uid'])
    {
        if($mybb->usergroup['cansearch']) {
            $config_list['guest_search'] = new xmlrpcval('1', 'string');
        }
        
        if($mybb->usergroup['canviewonline']) {
            $config_list['guest_whosonline'] = new xmlrpcval('1', 'string');
        }
    }
    
    if($mybb->settings['minsearchword'] < 1)
    {
        $mybb->settings['minsearchword'] = 3;
    }
    
    $config_list['min_search_length'] = new xmlrpcval(intval($mybb->settings['minsearchword']), 'int');
    if(!empty($mybb->settings['tapatalk_push_key'])) {
    	$config_list['api_key'] = new xmlrpcval(md5($mybb->settings['tapatalk_push_key']), 'string');
    }
    
    $response = new xmlrpcval($config_list, 'struct');
    return new xmlrpcresp($response);
}

