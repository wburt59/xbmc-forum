<?php
/**
 * Don't reveal any of the credentials or other
 * sensible configurations in GIT!!!!
 * Thus include 'em from an external file but
 * keep the dummy config.php for myBB
 */

/**
 * This sets the context the application is running in.
 * It allows to change certain behavior depending on context.
 * The currently supported contexts are:
 *
 * development		Used in the development environment
 * production		Used on the live website
 */
$context = @is_file(dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'developmentConfiguration.php') ? 'development' : 'production';
define('CONTEXT', $context);


// include the context depending configuration at the bottom
// which allows to override any default configuration if needed
if (CONTEXT == 'development') {
	require_once('developmentConfiguration.php');
} else {
	$private_path = '/etc/xbmc/php-include';
	set_include_path(get_include_path() . PATH_SEPARATOR . $private_path);
	require_once('forum/private/configuration.php');
}
?>