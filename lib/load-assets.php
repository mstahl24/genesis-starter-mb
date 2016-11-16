<?php

/* 
 * Asset loader handler
 * 
 * @package Mockingbird\Developers
 * @since 1.0.0
 * @author Mockingbird
 * @link http://mockingbird.marketing/
 * @license The MIT License (MIT)
 */
namespace Mockingbird\Developers;


add_action('wp_enqueue_scripts', __NAMESPACE__. '\enqueue_assets');
/**
 * Enqueue Scripts and Styles.
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function enqueue_assets() {

    // Google Fonts
    wp_enqueue_style( CHILD_TEXT_DOMAIN . '-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION);
    
    // Font Awesome Icons
    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), CHILD_THEME_VERSION );

    // Responsive Menu
    wp_enqueue_script( CHILD_TEXT_DOMAIN . '-responsive-menu', CHILD_THEME_DIR . '/assets/js/responsive-menu.min.js', array('jquery'), CHILD_THEME_VERSION, true);
}


add_action( 'init', __NAMESPACE__. '\modify_jquery' );
/**
 * Remove WP jQuery and replace with Google
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function modify_jquery() {
    if ( !is_admin() ) {
        // comment out the next two lines to load the local copy of jQuery
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', false, '2.1.3' );
        wp_enqueue_script( 'jquery' );
    }
}


add_action( 'wp_print_styles', __NAMESPACE__. '\deregister_styles', 100 );
/**
 * Remove plugin styles that are within our stylesheet.
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function deregister_styles() {
	wp_deregister_style( 'contact-form-7' );
}


// add_filter( 'stylesheet_uri', __NAMESPACE__. '\load_minified_stylesheet', 10, 2 );
/**
 * Load minified stylesheet instead of regular
 * 
 * @since 1.0.0
 * 
 * @return style.min.css
 */
function load_minified_stylesheet( $stylesheet_uri, $stylesheet_dir_uri ) {
    // Make sure this URI path is correct for your file
    return trailingslashit( $stylesheet_dir_uri ) . 'style.min.css';
}


add_filter( 'script_loader_src', __NAMESPACE__. '\remove_script_version', 15, 1 );
add_filter( 'style_loader_src', __NAMESPACE__. '\remove_script_version', 15, 1 );
/**
 * Remove Script Version
 * 
 * @since 1.0.0
 * 
 * @return without versions
 */
function remove_script_version($src) {
    $parts = explode('?ver', $src);
    return $parts[0];
}
