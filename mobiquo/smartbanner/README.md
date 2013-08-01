App Banner
===================

## Usage ##
    <html>
      <head>
            ...
            
            <!-- for twitter app card -->
            <!-- https://dev.twitter.com/docs/cards/types/app-card -->
            <!-- https://dev.twitter.com/docs/cards/app-installs-and-deep-linking -->
            <meta name="twitter:card" content="app">;
            <meta name="twitter:app:id:iphone" content="'+app_ios_id+'">
            <meta name="twitter:app:url:iphone" content="'+(byo_ios_enable ? "tapatalk-byo://" : "tapatalk://")+'">
            <meta name="twitter:app:id:ipad" content="'+app_ios_hd_id+'">
            <meta name="twitter:app:url:ipad" content="'+(byo_ios_enable ? "tapatalk-byo://" : "tapatalk://")+'">'
            <meta name="twitter:app:id:googleplay" content="'+app_android_id+'">
            <meta name="twitter:app:url:googleplay" content="'+(byo_android_enable ? app_location_url_byo : app_location_url)+'">'
            <!-- for twitter app card -->
            
            
            <!-- Tapatalk Banner head start -->
            <link href="'.$tapatalk_dir_url.'/smartbanner/appbanner.css" rel="stylesheet" type="text/css" media="screen" />
            <script type="text/javascript">
                var is_mobile_skin     = '.$is_mobile_skin.';
                var app_ios_id         = "'.intval($settings['app_ios_id']).'";
                var app_android_url    = "'.addslashes($settings['app_android_url']).'";
                var app_kindle_url     = "'.addslashes($settings['app_kindle_url']).'";
                var app_banner_message = "'.addslashes(str_replace("\n", '<br />', $settings['app_banner_message'])).'";
                var app_forum_name     = "'.addslashes($settings['board_name']).'";
                var app_location_url   = "'.addslashes($app_location_url).'";
            </script>
            <script src="'.$tapatalk_dir_url.'/smartbanner/appbanner.js" type="text/javascript"></script>
            <!-- Tapatalk Banner head end-->
            
            ...
      </head>
      <body>
        ...
        <!-- Tapatalk Banner body start -->
            <script type="text/javascript">tapatalkDetect()</script>
        <!-- Tapatalk Banner body end -->
        ...
      </body>
    </html>


## php code ##

    $app_forum_name = {forum name};
    $board_url = {forum url to root};
    $tapatalk_dir = {tapatalk directory name};  // default as 'mobiquo'
    $tapatalk_dir_url = $board_url.'/'.$tapatalk_dir;
    $is_mobile_skin = {this is on a mobile skin};
    $app_location_url = {page location url with tapatalk scheme rules};
    
    $app_banner_message = {ios app id from byo option};
    $app_ios_id = {ios app id from byo option};
    $app_android_id = {android app id from byo option};
    $app_kindle_url = {kindle app url from byo option};
    
    if (file_exists($tapatalk_dir . '/smartbanner/head.inc.php'))
        include($tapatalk_dir . '/smartbanner/head.inc.php');
    
    // you'll get $app_head_include set here and you need add it into html head