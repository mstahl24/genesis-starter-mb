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

/**
 * Initialize the theme's constants.
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function mbird_init_constants() {
	
	$child_theme = wp_get_theme();
	
	define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );
	define( 'CHILD_THEME_URL', $child_theme->get( 'ThemeURI' ) );
	define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );
	define( 'CHILD_TEXT_DOMAIN', $child_theme->get( 'TextDomain' ) );
	
	define( 'CHILD_THEME_DIR', '/wp-content/themes/'. CHILD_TEXT_DOMAIN );
}

mbird_init_constants();