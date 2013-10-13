<?php
/**
 * Plugin Name: Inline Ajax Comments Reloaded
 * Plugin URI: http://www.studiograsshopper.ch/projects/inline-ajax-comments-reloaded/
 * Description: Creates and displays Facebook-style single line comment form and comments, using Ajax.
 * Tags: comments, ajax, ajax comments, comment, inline, comment form
 * Version: 0.8.0
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
define( 'IACR_URL',				plugins_url( 'inline-ajax-comments-reloaded' ) );
define( 'IACR_DIR', 			plugin_dir_path( __FILE__ ) );
define( 'IACR_LIB_DIR', 		IACR_DIR . '/lib' );
define( 'IACR_LIB_URL',			IACR_URL . '/lib' );
define( 'IACR_CSS_URL',			IACR_URL . '/css' );
define( 'IACR_JS_URL',			IACR_URL . '/js' );
define( 'IACR_TEMPLATE_DIR',	IACR_DIR . '/templates' );
define( 'IACR_LANG_DIR_REL', 	'/inline-ajax-comments-reloaded/languages' );

define( 'IACR_VER', 		'0.8.0' );
define( 'IACR_WP_VER_REQ', 	'3.6' );

define( 'IACR_NAME', 		'Inline Ajax Comments Reloaded' );
define( 'IACR_FILE_NAME', 	'inline-ajax-comments-reloaded/inline-ajax-comments-reloaded.php' );
define( 'IACR_FILE_HOOK', 	'inline_ajax_comments_reloaded' );
define( 'IACR_PAGEHOOK', 	'settings_page_' . IACR_FILE_HOOK );


/**
 * From the WordPress plugin headers above we derive the version number, and plugin name
 */
$iacr_plugin_headers = get_file_data( __FILE__, array( 'Version' => 'Version', 'Name' => 'Plugin Name' ) );


/**
 * We store our plugin data in the following global array.
 * $my_unique_name with your unique name
 */
global $iacr_unique_name;
$iacr_unique_name = array();
$iacr_unique_name['version_key'] = strtolower( str_replace( ' ', '_', $iacr_plugin_headers['Name'] ) ) . '_version';
$iacr_unique_name['version_value'] = $iacr_plugin_headers['Version'];


/**
 * When the user activates the plugin we add the version number to the
 * options table as "my_plugin_name_version" only if this is a newer version.
 *
 * @TODO This doesn't do anything useful - needs to be replaced
 */
function inline_comments_activation(){

    global $iacr_unique_name;

    if ( get_option( $iacr_unique_name['version_key'] ) && get_option( $iacr_unique_name['version_key'] ) > $iacr_unique_name['version_value'] )
        return;

    update_option( $iacr_unique_name['version_key'], $iacr_unique_name['version_value'] );

}
register_activation_hook( __FILE__, 'inline_comments_activation' );


/**
 * Delete our version number from the database when the plugin is activated.
 */
function inline_comments_deactivate(){
    global $iacr_unique_name;
    delete_option( $iacr_unique_name['version_key'] );
}
register_deactivation_hook( __FILE__, 'inline_comments_deactivate' );


if ( is_admin() )
    require_once plugin_dir_path( __FILE__ ) . 'admin/admin-tags.php';

/**
 * Theme only functions
 */
require_once IACR_LIB_DIR . '/template-tags.php';


function inline_comments_enqueue_styles() {
	wp_register_style( 'inline-ajax-comments-style', IACR_CSS_URL . '/style.css' );
	wp_enqueue_style( 'inline-ajax-comments-style' );

}
// Priority of 4 to ensure that this loads before the Genesis stylesheet (priority 5)
add_action('wp_enqueue_scripts', 'inline_comments_enqueue_styles', 4 );


function inline_comments_enqueue_scripts(){
    
    wp_register_script( 'inline-ajax-comments-script', IACR_JS_URL . '/script.js', array('jquery'), IACR_VER, false );
    wp_register_script( 'autogrow-script', IACR_JS_URL . '/autogrow.min.js', array('jquery'), IACR_VER, false );
    wp_register_script( 'mcustom-scrollbar', IACR_JS_URL . '/jquery.mCustomScrollbar.min.js', array('jquery'), IACR_VER, false );
    wp_register_script( 'mousewheel', IACR_JS_URL . '/jquery.mousewheel.min.js', array('jquery'), IACR_VER, false );
    
    wp_enqueue_script( 'inline-ajax-comments-script' );
    wp_enqueue_script( 'autogrow-script' );
    wp_enqueue_script( 'mcustom-scrollbar' );
    wp_enqueue_script( 'mousewheel' );
    
    $args = array(
    	'ajaxurl' => admin_url("admin-ajax.php"),
    	);
    	
    wp_localize_script( 'inline-ajax-comments-script', 'inlinecomments', $args );
}
add_action( 'wp_enqueue_scripts', 'inline_comments_enqueue_scripts', 11 );