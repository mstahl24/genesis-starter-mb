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
namespace Mockingbird\Developers;


//* Allow shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

/** Remove Edit Link */
add_filter( 'edit_post_link', '__return_false' );

//* Remove the header right widget area
unregister_sidebar('header-right');

//* Unregister content/sidebar/sidebar layout setting
genesis_unregister_layout('content-sidebar-sidebar');

//* Unregister sidebar/sidebar/content layout setting
genesis_unregister_layout('sidebar-sidebar-content');

//* Unregister sidebar/content/sidebar layout setting
genesis_unregister_layout('sidebar-content-sidebar');

//* Disable the superfish script
add_action( 'wp_enqueue_scripts', __NAMESPACE__. '\disable_superfish' );
function disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}

//* [Site-wide] Modify the Excerpt read more link
add_filter('excerpt_more', __NAMESPACE__. '\new_excerpt_more');
function new_excerpt_more($more) {
    return '... <a class="more-link" href="' . get_permalink() . '">Read More</a>';
}

//* Customize the post meta function
add_filter( 'genesis_post_meta', __NAMESPACE__. '\post_meta_filter' );
function post_meta_filter($post_meta) {
if ( !is_page() ) {
	$post_meta = '[post_categories before="Categories: "] [post_tags before="Tags: "]';
	return $post_meta;
}}
