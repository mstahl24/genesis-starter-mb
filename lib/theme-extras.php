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

if ( get_field('theme_sticky_header', 'option') ) {
	//* Add sticky wrap before header
	add_action( 'genesis_before_header', 'mbird_add_header_sticky_wrap_open', 1 );
	function mbird_add_header_sticky_wrap_open() {
		echo '<div class="sticky-header">';
	}

	//* Add sticky wrap close after header
	add_action( 'genesis_after_header', 'mbird_add_header_sticky_wrap_close', 15 );
	function mbird_add_header_sticky_wrap_close() {
		echo '</div>';
	}
}


add_action('genesis_before_footer', 'mbird_add_footer_badges_skip_home', 1);
/*
 * Add Badges Before Footer
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function mbird_add_footer_badges_skip_home() {

	if (!is_front_page()) {

		mbird_add_footer_badges();
		
	}
}
function mbird_add_footer_badges() {


	if ( get_field('page_badge_bar_disable') ) {

		// do nothing

	} else {

		// check if the repeater field has rows of data
		if (have_rows('theme_badges', 'option')):

			echo '<div class="row badge-bar"><div class="badge-wrap">';

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
	
}

add_action('genesis_before_footer', 'mbird_add_extra_footer', 1);
/*
 * Add extra footer
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function mbird_add_extra_footer() {

	if ( get_field('page_extra_footer_disable') ) {

		// do nothing

	} else {

	
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

}




add_action('genesis_header_right', 'mbird_add_header_info');
/*
 * Add header contact info
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function mbird_add_header_info() {
	
	if ( get_field('theme_phone', 'option') ) {
		echo '<div class="header-info"><div class="header-phone">';          
			echo '<span class="phone-cta">'.get_field("theme_phone_cta", "option").'</span>';
			echo '<span class="phone-num"><a href="tel:'.get_field("theme_phone_link", "option").'">'.get_field("theme_phone", "option").'</a></span>';
		echo '</div></div>';
	}

}

add_action('wp_footer', 'mbird_add_extra_footer_scripts');
/*
 * Output extra footer scripts
 * 
 * @since 1.0.0
 * 
 * @return void
 */
function mbird_add_extra_footer_scripts() {

	if (get_field('theme_footer_scripts', 'option')) {
		the_field('theme_footer_scripts', 'option');
	}
}



add_shortcode( 'office-location', 'mbird_display_office_info_shortcode' );
/*
 * Add locations shortcode
 * 
 * @since 1.0.0
 * 
 * @return location
 */
function mbird_display_office_info_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'num' => '1',
			'schema' => 'false'
		),
		$atts,
		'office-location'
	);

		$loc_num = --$atts['num'];
		$rows = get_field( 'theme_locations', 'option' ); // get all the rows
		$selected_row = $rows[$loc_num]; // get the selected row

		if ( $atts['schema'] = 'true' === $atts['schema'] ) {
			$schema = 1;


			if ( $selected_row[ 'theme_loc_name' ] ) {
				$loc_name = ''. $selected_row[ 'theme_loc_name' ] .'';
			}
			if ( $selected_row[ 'theme_loc_street' ] ) {
				$loc_street = ''. $selected_row[ 'theme_loc_street' ] .'';
			}
			if ( $selected_row[ 'theme_loc_city' ] ) {
				$loc_city = ''. $selected_row[ 'theme_loc_city' ] .'';
			}
			if ( $selected_row[ 'theme_loc_state' ] ) {
				$loc_state = ''. $selected_row[ 'theme_loc_state' ] .'';
			}
			if ( $selected_row[ 'theme_loc_zip' ] ) {
				$loc_zip = ''. $selected_row[ 'theme_loc_zip' ] .'';
			}
			if ( $selected_row[ 'theme_loc_phone' ] ) {
				$loc_phone = 'Tel: <span itemprop="telephone">'. $selected_row[ 'theme_loc_phone' ] .'</span><br />';
			}
			if ( $selected_row[ 'theme_loc_fax' ] ) {
				$loc_fax = 'Fax: <span itemprop="faxNumber">'. $selected_row[ 'theme_loc_fax' ] .'</span><br /><br />';
			}
			if ( $selected_row[ 'theme_loc_map' ] ) {
				$loc_map = '<span class="loc-map"><a href="'. $selected_row[ 'theme_loc_map' ] .'" target="_blank">Driving Directions</a></span>';
			}

		} else {

			if ( $selected_row[ 'theme_loc_name' ] ) {
				$loc_name = ''. $selected_row[ 'theme_loc_name' ] .'<br />';
			}
			if ( $selected_row[ 'theme_loc_street' ] ) {
				$loc_street = ''. $selected_row[ 'theme_loc_street' ] .'<br />';
			}
			if ( $selected_row[ 'theme_loc_city' ] ) {
				$loc_city = ''. $selected_row[ 'theme_loc_city' ] .',';
			}
			if ( $selected_row[ 'theme_loc_state' ] ) {
				$loc_state = ''. $selected_row[ 'theme_loc_state' ] .'';
			}
			if ( $selected_row[ 'theme_loc_zip' ] ) {
				$loc_zip = ''. $selected_row[ 'theme_loc_zip' ] .'<br />';
			}
			if ( $selected_row[ 'theme_loc_phone' ] ) {
				$loc_phone = 'Tel: '. $selected_row[ 'theme_loc_phone' ] .'<br />';
			}
			if ( $selected_row[ 'theme_loc_fax' ] ) {
				$loc_fax = 'Fax: '. $selected_row[ 'theme_loc_fax' ] .'<br />';
			}
			if ( $selected_row[ 'theme_loc_map' ] ) {
				$loc_map = '<span class="loc-map"><a href="'. $selected_row[ 'theme_loc_map' ] .'" target="_blank">Driving Directions</a></span>';
			}

		}
		
		

	if ( $schema == 1 ) {
		// Return custom embed code
		return '
		<div itemscope itemtype="http://schema.org/LegalService" class="loc-schema">
			<img src="/wp-content/themes/assets/images/logo.png" itemprop="image" alt="'.$loc_name.' logo" />
			<span itemprop="name">'.$loc_name.'</span>
			<div itemscope itemprop="address" itemtype="http://schema.org/PostalAddress">
				<p><span itemprop="streetAddress">'.$loc_street.'</span><br />
				<span itemprop="addressLocality">'.$loc_city.'</span>, <span itemprop="addressRegion">'.$loc_state.'</span> <span itemprop="postalCode">'.$loc_zip.'</span>
				</p>
			</div>
			'.$loc_phone.'
			'.$loc_fax.'
				'.$loc_map.'
		</div>';
	} else {
		// Return custom embed code
		return '
		<p class="loc-display">
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
}

add_shortcode( 'social-links', 'mbird_social_media_links_shortcode' );
/*
 * Add locations shortcode
 * 
 * @since 1.0.0
 * 
 * @return location
 */
function mbird_social_media_links_shortcode() {

		
		
		if ( get_field( 'theme_facebook', 'option' ) ) {
			$facebook_link = '<a href="'. get_field( 'theme_facebook', 'option' ) .'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
		}
		if ( get_field( 'theme_twitter', 'option' ) ) {
			$twitter_link = '<a href="'. get_field( 'theme_twitter', 'option' ) .'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
		}
		if ( get_field( 'theme_linkedin', 'option' ) ) {
			$linkedin_link = '<a href="'. get_field( 'theme_linkedin', 'option' ) .'" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
		}
		if ( get_field( 'theme_google', 'option' ) ) {
			$googleplus_link = '<a href="'. get_field( 'theme_google', 'option' ) .'" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
		}
		if ( get_field( 'theme_youtube', 'option' ) ) {
			$youtube_link = '<a href="'. get_field( 'theme_youtube', 'option' ) .'" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>';
		}

		return '<p class="social-links">
					'.$facebook_link.'
					'.$twitter_link.'
					'.$linkedin_link.'
					'.$googleplus_link.'
					'.$youtube_link.'
		</p>';

}
