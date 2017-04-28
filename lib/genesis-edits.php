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


//* Allow shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

/** Remove Edit Link */
add_filter( 'edit_post_link', '__return_false' );

//* Remove the header right widget area
unregister_sidebar('header-right');

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister content/sidebar/sidebar layout setting
genesis_unregister_layout('content-sidebar-sidebar');

//* Unregister sidebar/sidebar/content layout setting
genesis_unregister_layout('sidebar-sidebar-content');

//* Unregister sidebar/content/sidebar layout setting
genesis_unregister_layout('sidebar-content-sidebar');

//* Disable the superfish script
add_action( 'wp_enqueue_scripts', 'mbird_disable_superfish' );
function mbird_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}

//* [Site-wide] Modify the Excerpt read more link
add_filter('excerpt_more', 'mbird_new_excerpt_more');
function mbird_new_excerpt_more($more) {
    return '... <a class="more-link" href="' . get_permalink() . '">Read More</a>';
}

//* Customize the post meta function
add_filter( 'genesis_post_meta', 'mbird_post_meta_filter' );
function mbird_post_meta_filter($post_meta) {
if ( !is_page() ) {
	$post_meta = '[post_categories before="Categories: "] [post_tags before="Tags: "]';
	return $post_meta;
}}


//* Add standard content editor back to posts page
add_action( 'edit_form_after_title', 'mbird_add_posts_page_edit_form' );
function mbird_add_posts_page_edit_form( $post ) {
	$posts_page = get_option( 'page_for_posts' );
	if ( $posts_page === $post->ID ) {
		add_post_type_support( 'page', 'editor' );
	}
}

/**
 * Remove Genesis Page Templates
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/remove-genesis-page-templates
 *
 * @param array $page_templates
 * @return array
 */
function be_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'be_remove_genesis_page_templates' );


/**
 * Default Titles for Term Archives
 *
 * @author Bill Erickson
 * @see http://www.billerickson.net/default-category-and-tag-titles
 *
 * @param string $headline
 * @param object $term
 * @return string $headline
 */
function ea_default_term_title( $value, $term_id, $meta_key, $single ) {
	if( ( is_category() || is_tag() || is_tax() ) && 'headline' == $meta_key && ! is_admin() ) {
	
		// Grab the current value, be sure to remove and re-add the hook to avoid infinite loops
		remove_action( 'get_term_metadata', 'ea_default_term_title', 10 );
		$value = get_term_meta( $term_id, 'headline', true );
		add_action( 'get_term_metadata', 'ea_default_term_title', 10, 4 );
		// Use term name if empty
		if( empty( $value ) ) {
			$term = get_term_by( 'term_taxonomy_id', $term_id );
			if( is_category() ) {
				$value = 'Posts Categorized In: '.$term->name.'';
			} else if( is_tag() ) {
				$value = 'Posts Tagged With: '.$term->name.'';
			} else {
				$value = $term->name;
			}
		}
	
	}
	return $value;		
}
add_filter( 'get_term_metadata', 'ea_default_term_title', 10, 4 );