<?php

/*
 * Description
 * 
 * @package Mockingbird\Developers
 * @since 1.0.0
 * @author Mockingbird
 * @link http://mockingbird.marketing/
 * @license The MIT License (MIT)
 */


add_action('genesis_setup', 'mbird_setup_child_theme');
/**
 * Setup child theme.
 * 
 * @since 1.0.0
 * 
 * @reutrn void
 */
function mbird_setup_child_theme() {

	mbird_add_theme_supports();
	
	mbird_custom_clean_head();
	
	// mbird_adds_new_image_sizes();

}

/**
 * Removes unnecessary links/scripts from wp head
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function mbird_custom_clean_head() {
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_shortlink_wp_head');

	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
}

/**
 * Adds theme supports to the site.
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function mbird_add_theme_supports() {

	$config = array(
		'html5' => array(
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form',
		),
		'genesis-accessibility' => array(
			'404-page',
			'drop-down-menu',
			'headings',
			'rems',
			'search-form',
			'skip-links'
		),
		'genesis-responsive-viewport' => null,
		'genesis-footer-widgets' => 3,
	);

	foreach ($config as $feature => $args) {
		add_theme_support($feature, $args);
	}
}

/**
 * Adds new image sizes.
 * 
 * @since 1.0.0
 * 
 * @return void
 */
// function mbird_adds_new_image_sizes() {

//     $config = array(
//        'featured-image' => array(
//            'width'  => 720,
//            'height' => 400,
//            'crop'   => true,
//       ),
//    );
//   
//    foreach( $config as $name => $args ) {
//        $crop = array_key_exists( 'crop', $args ) ? $args['crop'] : false;
//        
//        add_image_size( $name, $args['width'], $args['height'], true);
//    }
// }


add_filter( 'genesis_theme_settings_defaults', 'mbird_set_theme_settings_defaults' );
/**
 * Set theme settings defaults
 * 
 * @since 1.0.0
 * 
 * @param array $defaults
 * 
 * @return array
 */
function mbird_set_theme_settings_defaults( array $defaults ) {
	
	$config = mbird_get_theme_settings_defaults();
	
	$defaults = wp_parse_args( $config, $defaults );
	
	return $defaults;
}


add_action( 'after_switch_theme', 'mbird_update_theme_settings_defaults' );
/**
 * Updates the theme setting defaults.
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function mbird_update_theme_settings_defaults() {
	
	$config = mbird_get_theme_settings_defaults();
	
	if (function_exists('genesis_update_settings')) {

		genesis_update_settings( $config );
		
	}

	update_option('posts_per_page', $config['blog_cat_num']);
}

/**
 * Get the theme setting defaults
 * 
 * @since 1.0.0
 * 
 * @return array
 */
function mbird_get_theme_settings_defaults() {
	
	return array(
		'blog_cat_num' => 10,
		'comments_pages' => 0,
		'comments_posts' => 0,
		'trackbacks_pages' => 0,
		'trackbacks_posts' => 0,
		'content_archive' => 'excerpts',
		'content_archive_limit' => 0,
		'content_archive_thumbnail' => 1,
		'posts_nav' => 'numeric',
		'site_layout' => 'content-sidebar',
		'superfish' => 0,
	);
	
}