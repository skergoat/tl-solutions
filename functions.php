<?php
/**
 * Divi Cake Child Theme
 * Functions.php
 *
 * ===== NOTES ==================================================================
 * 
 * Unlike style.css, the functions.php of a child theme does not override its 
 * counterpart from the parent. Instead, it is loaded in addition to the parent's 
 * functions.php. (Specifically, it is loaded right before the parent's file.)
 * 
 * In that way, the functions.php of a child theme provides a smart, trouble-free 
 * method of modifying the functionality of a parent theme. 
 * 
 * Discover Divi Child Themes: https://divicake.com/products/category/divi-child-themes/
 * Sell Your Divi Child Themes: https://divicake.com/open/
 * 
 * =============================================================================== */

function divichild_enqueue_scripts() {
	 // all styles
	 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'divichild_enqueue_scripts' );


// ajouter JQuery

wp_deregister_script('jquery');
wp_register_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', false, '');
wp_enqueue_script('jquery');

/*Update following in your WordPress theme's functions.php file */

// Remove Query String from Static Resources
function remove_cssjs_ver( $src ) {
if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

// Remove Emojis
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove Shortlink
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Disable Embed
function disable_embed(){
wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'disable_embed' );

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove RSD Link
remove_action( 'wp_head', 'rsd_link' ) ;

// Hide Version
remove_action( 'wp_head', 'wp_generator' ) ;

// Remove WLManifest Link
remove_action( 'wp_head', 'wlwmanifest_link' ) ;

// Disable Self Pingback
function disable_pingback( &$links ) {
  foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}

add_action( 'pre_ping', 'disable_pingback' );

// Disable Heartbeat
add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
wp_deregister_script('heartbeat');
}

// Disable Dashicons in Front-end
function wpdocs_dequeue_dashicon() {
	if (current_user_can( 'update_core' )) {
	    return;
	}
	wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );

// chiptunning
function wp_php_api($url) {



	$host = 'https://api.olsx.lu/car-configurator/v1/' . $url;
	$ch = curl_init($host);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);

	// get body 
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$body = substr($response, $header_size);
	$body = json_decode($body, true);

	curl_close($ch);

	return $body;
}
add_action('wp_enqueue_scripts', 'wp_php_api');

// error 404
function wp_error_404() {
	global $wp_query;
	$wp_query->set_404();
	status_header(404);
	get_template_part(404); exit();
}


