<?php

/* 
 * Load extra theme features
 * 
 * @package Mockingbird\Developers
 * @since 1.0.0
 * @author Mockingbird
 * @link http://mockingbird.marketing/
 * @license The MIT License (MIT)
 */
namespace Mockingbird\Developers;



// Add ACF Options Page for Theme Extra Content
if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Theme Extras',
        'menu_title'    => 'Theme Extras',
        'menu_slug'     => 'theme-extras',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
    
}


add_action('genesis_before_footer', __NAMESPACE__. '\add_footer_badges_skip_home', 1);
/*
 * Add Badges Before Footer
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function add_footer_badges_skip_home() {

    if (!is_front_page()) {

        add_footer_badges();
        
    }
}
function add_footer_badges() {

    // check if the repeater field has rows of data
    if (have_rows('theme_badges', 'option')):

        echo '<div class="row"><div class="badge-wrap">';

        // loop through the rows of data
        while (have_rows('theme_badges', 'option')) : the_row();

            echo '<div class="badge-img">';

            $badge = get_sub_field('theme_badge_img', 'option');
            $badgesize = 'medium'; // (thumbnail, medium, large, full or custom size)

            if (get_sub_field('theme_badge_link', 'option')) {
                echo '<a href="' . get_sub_field('theme_badge_link', 'option') . '" target="_blank">';
            }

            echo wp_get_attachment_image($badge, $badgesize);

            if (get_sub_field('theme_badge_link', 'option')) {
                echo '</a>';
            }

            echo '</div>';

        endwhile;

        echo '</div></div>';

    else :

    // no rows found

    endif;
}

add_action('genesis_before_footer', __NAMESPACE__. '\add_extra_footer', 1);
/*
 * Add extra footer
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function add_extra_footer() {
    
    if ( get_field('theme_footer_col1', 'option') ) {

        echo '<section class="row extra-footer"><div class = "wrap">';

        if ( get_field('theme_footer_columns', 'option') == '1' ) {
            
            echo '<div class="single-extra-footer centered">'.get_field('theme_footer_col1', 'option').'</div>';
        
        } elseif ( get_field('theme_footer_columns', 'option') == '2' ) {
            
            echo '<div class="one-half first">'.get_field('theme_footer_col1', 'option').'</div>';
            echo '<div class="one-half">'.get_field('theme_footer_col2', 'option').'</div>';
            
        }

        echo '</div></section>';
    
    }

}

add_action('genesis_header_right', __NAMESPACE__. '\add_header_info');
/*
 * Add header contact info
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function add_header_info() {
    
    if ( get_field('theme_phone', 'option') ) {
        echo '<div class="header-info"><div class="header-phone">';          
            echo '<span class="phone-cta">'.get_field("theme_phone_cta", "option").'</span>';
            echo '<span class="phone-num"><a href="tel:'.get_field("theme_phone_link", "option").'">'.get_field("theme_phone", "option").'</a></span>';
        echo '</div></div>';
    }

}

add_action('wp_footer', __NAMESPACE__. '\add_extra_footer_scripts');
/*
 * Output extra footer scripts
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function add_extra_footer_scripts() {

    if (get_field('theme_footer_scripts', 'option')) {
        the_field('theme_footer_scripts', 'option');
    }
}


add_shortcode( 'office-location', __NAMESPACE__. '\display_office_info_shortcode' );
/*
 * Add locations shortcode
 * 
 * @since 1.0.0
 * 
 * @return location
 */
function display_office_info_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'num' => '1',
		),
		$atts,
		'office-location'
	);
        
        $loc_num = --$atts['num'];
        $rows = get_field( 'theme_locations', 'option' ); // get all the rows
        $selected_row = $rows[$loc_num]; // get the selected row
        
        if ( $selected_row[ 'theme_loc_name' ] ) {
            $loc_name = '<span class="loc-name">'. $selected_row[ 'theme_loc_name' ] .'</span><br />';
        }
        if ( $selected_row[ 'theme_loc_street' ] ) {
            $loc_street = '<span class="loc-street">'. $selected_row[ 'theme_loc_street' ] .'</span><br />';
        }
        if ( $selected_row[ 'theme_loc_city' ] ) {
            $loc_city = '<span class="loc-city">'. $selected_row[ 'theme_loc_city' ] .'</span>, ';
        }
        if ( $selected_row[ 'theme_loc_state' ] ) {
            $loc_state = '<span class="loc-state">'. $selected_row[ 'theme_loc_state' ] .'</span>';
        }
        if ( $selected_row[ 'theme_loc_zip' ] ) {
            $loc_zip = '<span class="loc-zip">'. $selected_row[ 'theme_loc_zip' ] .'</span><br />';
        }
        if ( $selected_row[ 'theme_loc_phone' ] ) {
            $loc_phone = '<span class="loc-phone">Phone: '. $selected_row[ 'theme_loc_phone' ] .'</span><br />';
        }
        if ( $selected_row[ 'theme_loc_fax' ] ) {
            $loc_fax = '<span class="loc-fax">Fax: '. $selected_row[ 'theme_loc_fax' ] .'</span><br />';
        }
        if ( $selected_row[ 'theme_loc_map' ] ) {
            $loc_map = '<span class="loc-map"><a href="'. $selected_row[ 'theme_loc_map' ] .'" target="_blank">Driving Directions</a></span>';
        }

	// Return custom embed code
	return '<p class="loc-display">
                    '.$loc_name.'
                    '.$loc_street.'
                    '.$loc_city.'
                    '.$loc_state.'
                    '.$loc_zip.'
                    '.$loc_phone.'
                    '.$loc_fax.'
                    '.$loc_map.'
                </p>';

}
