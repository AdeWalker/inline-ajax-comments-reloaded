<?php
/**
 * Plugin Name: Inline Ajax Comments Reloaded
 * Plugin URI: http://www.studiograsshopper.ch/projects/inline--ajax-comments-reloaded/
 * Description: Creates and displays Facebook-style single line comment form and comments, using Ajax.
 * Tags: comments, ajax, ajax comments, comment, inline, comment form
 * Version: 0.7.0
 * Author: Studiograsshopper
 * Author URI: http://www.studiograsshopper.ch/
 * License: GPL
 */
 
/**
 * This is a highly modified version of ZaneMatthew's Inline Ajax Comments plugin
 * http://zanematthew.com/blog/plugins/inline-comments/
 * http://zanematthew.com/
 */


// Define some constants
define( 'AIAC_URL',				plugins_url( 'inline-ajax-comments' ) );
define( 'AIAC_DIR', 			plugin_dir_path( __FILE__ ) );
define( 'AIAC_LIB_DIR', 		AIAC_DIR . '/lib' );
define( 'AIAC_LIB_URL',			AIAC_URL . '/lib' );
define( 'AIAC_CSS_URL',			AIAC_URL . '/css' );
define( 'AIAC_JS_URL',			AIAC_URL . '/js' );
define( 'AIAC_TEMPLATE_DIR',	AIAC_DIR . '/templates' );
define( 'AIAC_LANG_DIR_REL', 	'/ades-image-likes-plugin/languages' );

define( 'AIAC_VER', 		'0.7.0' );
define( 'AIAC_WP_VER_REQ', 	'3.6' );

define( 'AIAC_NAME', 		'Ade\'s Image Likes' );
define( 'AIAC_FILE_NAME', 	'ades-image-likes/ades-image-likes.php' );
define( 'AIAC_FILE_HOOK', 	'ades_image_likes' );
define( 'AIAC_PAGEHOOK', 	'settings_page_' . AIAC_FILE_HOOK );


/**
 * From the WordPress plugin headers above we derive the version number, and plugin name
 */
$plugin_headers = get_file_data( __FILE__, array( 'Version' => 'Version', 'Name' => 'Plugin Name' ) );


/**
 * We store our plugin data in the following global array.
 * $my_unique_name with your unique name
 */
global $my_unique_name;
$my_unique_name = array();
$my_unique_name['version_key'] = strtolower( str_replace( ' ', '_', $plugin_headers['Name'] ) ) . '_version';
$my_unique_name['version_value'] = $plugin_headers['Version'];


/**
 * When the user activates the plugin we add the version number to the
 * options table as "my_plugin_name_version" only if this is a newer version.
 */
function inline_comments_acitvation(){

    global $my_unique_name;

    if ( get_option( $my_unique_name['version_key'] ) && get_option( $my_unique_name['version_key'] ) > $my_unique_name['version_value'] )
        return;

    update_option( $my_unique_name['version_key'], $my_unique_name['version_value'] );

}
register_activation_hook( __FILE__, 'inline_comments_acitvation' );


/**
 * Delete our version number from the database when the plugin is activated.
 */
function inline_comments_deactivate(){
    global $my_unique_name;
    delete_option( $my_unique_name['version_key'] );
}
register_deactivation_hook( __FILE__, 'inline_comments_deactivate' );


if ( is_admin() )
    require_once plugin_dir_path( __FILE__ ) . 'admin/admin-tags.php';

/**
 * Theme only functions
 */
require_once AIAC_LIB_DIR . '/template-tags.php';


function inline_comments_enqueue_styles() {
	wp_register_style( 'inline-ajax-comments-style', AIAC_CSS_URL . '/style.css' );
	wp_enqueue_style( 'inline-ajax-comments-style' );

}
// Priority of 4 to ensure that this loads before the Genesis stylesheet (priority 5)
add_action('wp_enqueue_scripts', 'inline_comments_enqueue_styles', 4 );


function inline_comments_enqueue_scripts(){
    
    //wp_register_script( 'textarea_auto_expand-script', plugin_dir_url( __FILE__ ) . 'vendor/textarea-auto-expand/jquery.textarea_auto_expand.js' );
    wp_register_script( 'inline-ajax-comments-script', AIAC_JS_URL . '/script.js', array('jquery'), AIAC_VER, false );
    
    wp_enqueue_script( 'inline-ajax-comments-script' );
    
    $args = array(
    	'ajaxurl' => admin_url("admin-ajax.php"),
    	);
    	
    wp_localize_script( 'inline-ajax-comments-script', 'inlinecomments', $args );
}
add_action( 'wp_enqueue_scripts', 'inline_comments_enqueue_scripts', 11 );