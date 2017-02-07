<?php
/*
  Template Name: Home Page
 */

//* Add home body class
add_filter('body_class', 'mbird_home_body_class');
function mbird_home_body_class($classes) {

    $classes[] = 'homepage';
    return $classes;
}

//* Force full-width-content layout setting
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

//* Remove the entry header markup, entry title, and post info
//* Will place later
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Add Custom Content Areas
add_action( 'genesis_entry_content', 'mbird_home_content_insert', 1 );
function mbird_home_content_insert() {



	$page_content = get_the_content();

	if( $page_content ) {
		echo '<div class="row home-standard-content"><div class="wrap">'.$page_content.'</div></div>';
	}

}

genesis();
