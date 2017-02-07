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


//* Initialize our theme framework
include_once( __DIR__ . '/lib/init.php' );

//* Load our Genesis Setup
include_once( __DIR__ . '/lib/setup.php' );

//* Start the Genesis framework
include_once( get_template_directory() . '/lib/init.php' );

//* Load our assets
include_once( __DIR__ . '/lib/load-assets.php' );

//* Change Genesis theme settings
include_once( __DIR__ . '/lib/genesis-edits.php' );

//* Add ACF theme content
if( class_exists('acf') ) { 
    include_once( __DIR__ . '/lib/theme-extras.php' );
}


