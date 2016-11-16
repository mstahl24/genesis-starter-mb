<?php
/*
  Template Name: Home Page
 */

//* Add home body class
add_filter('body_class', 'home_body_class');

function home_body_class($classes) {

    $classes[] = 'homepage';
    return $classes;
}

//* Force full-width-content layout setting
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');


genesis();
