<?php
/*
Template Name: Default Template
*/

//* Remove the entry header markup, entry title, and content
//* Will place later
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

if( class_exists('acf') ) { 
    if ( get_field('flex_full_width') ) {
        // Add full width body class if selected
        add_filter( 'body_class', 'add_body_class' );
        // Force full-width-content layout setting
        add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
        // Place Header with hero options and wrap
        add_action( 'genesis_entry_content', 'replace_header_with_wrap', 1 );
        // Place Flexible content
        add_action( 'genesis_entry_content', 'add_flexible_content', 1 );
        // Place content with wrap
        add_action( 'genesis_entry_content', 'replace_content_with_wrap', 1 );
    } else {
        // Place Header with hero options
        add_action( 'genesis_entry_content', 'replace_header', 1 );
        // Place Flexible content
        add_action( 'genesis_entry_content', 'add_flexible_content', 1 );
        // Place content
        add_action( 'genesis_entry_content', 'replace_content', 1 );
    }
} else {
    // Place content
    add_action( 'genesis_entry_content', 'replace_content', 1 );
    add_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
    add_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
    add_action( 'genesis_entry_header', 'genesis_do_post_title' );
}

function add_body_class( $classes ) {
	$classes[] = 'full';
	return $classes;
}

function place_yoast_breadcrumbs() {
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
    }
}


function replace_header() {
    
    if( get_field('flex_hero_img_option') == 'under' ) {
	
        // Hero Header with Title
        echo '<div class="hero row centered" style="background-image: url(' . get_field("flex_hero_img") . ');"><div class="overlay"><div class="wrap">';

        place_yoast_breadcrumbs();

        echo '<header class="entry-header"><h1 class="entry-title" itemprop="headline">' . get_the_title() . '</h1></header>';

        echo '</div></div></div>';
        
    } elseif( get_field('flex_hero_img_option') == 'plain' ) {
        
        // Hero Header then Title
        echo '<div class="hero row" style="background-image: url(' . get_field("flex_hero_img") . ');"></div>';
        
        echo '<div class="head-margin centered">';
        
        place_yoast_breadcrumbs();
    
        echo '<header class="entry-header"><h1 class="entry-title" itemprop="headline">' . get_the_title() . '</h1></header>';
        
        echo '</div>';
        
    } else {
        
        place_yoast_breadcrumbs();
    
        echo '<header class="entry-header"><h1 class="entry-title" itemprop="headline">' . get_the_title() . '</h1></header>';
        
    }
}

function replace_header_with_wrap() {
    
    if( get_field('flex_hero_img_option') == 'under' ) {
	
        // Hero Header with Title
        echo '<div class="hero row centered" style="background-image: url(' . get_field("flex_hero_img") . ');"><div class="overlay"><div class="wrap">';

        place_yoast_breadcrumbs();

        echo '<header class="entry-header"><h1 class="entry-title" itemprop="headline">' . get_the_title() . '</h1></header>';

        echo '</div></div></div>';
        
    } elseif( get_field('flex_hero_img_option') == 'plain' ) {
        
        // Hero Header then Title
        echo '<div class="hero row" style="background-image: url(' . get_field("flex_hero_img") . ');"></div>';
        
        echo '<div class="wrap head-margin centered">';
        
        place_yoast_breadcrumbs();
    
        echo '<header class="entry-header"><h1 class="entry-title" itemprop="headline">' . get_the_title() . '</h1></header>';
        
        echo '</div>';
        
    } else {
        
        echo '<div class="wrap head-margin">';
        
        place_yoast_breadcrumbs();
    
        echo '<header class="entry-header"><h1 class="entry-title" itemprop="headline">' . get_the_title() . '</h1></header>';
        
        echo '</div>';
        
    }
}

function replace_content() {
   
   echo '<div class="head-margin">';
    the_content();
   echo '</div>';
}

function replace_content_with_wrap() {
    
    echo '<div class="wrap head-margin">';
        the_content();
    echo '</div>';
    
}

function add_flexible_content() {
   
    // check if the flexible content field has rows of data
    if (have_rows('flex_rows_columns')):

        // loop through the rows of data
        while (have_rows('flex_rows_columns')) : the_row();

            if (get_row_layout() == 'flex_text_row'):
                
                if (get_sub_field('flex_text_row_wrap')) {
                    $wrap1 = 'wrap';
                } else {
                    $wrap1 = 'no-wrap';
                }

                echo '<div class="flex-plain row stripe">';
                    echo '<div class="'.$wrap1.'">';
                        the_sub_field('flex_text_row_content');
                    echo '</div>';
                echo '</div>';

            elseif (get_row_layout() == 'flex_content_row'):

                if (get_sub_field('flex_content_row_wrap')) {
                    $wrap2 = 'wrap';
                } else {
                    $wrap2 = 'no-wrap';
                }
                
                
                $columns = get_sub_field('flex_content_row_column_count');
                
                echo '<div class="flex-content row stripe" style="background-color: '.get_sub_field("flex_content_row_bg").'">';
                    echo '<div class="'.$wrap2.'">';
                        if ($columns == '1') {
                            $column_class = '';
                            echo '<div class="first '.$column_class.'">'.get_sub_field("flex_content_row_col1").'</div>';
                        } elseif ($columns == '2') {
                            $column_class = 'one-half';
                            echo '<div class="first '.$column_class.'">'.get_sub_field("flex_content_row_col1").'</div>';
                            echo '<div class="'.$column_class.'">'.get_sub_field("flex_content_row_col2").'</div>';
                        } elseif ($columns == '3') {
                            $column_class = 'one-third';
                            echo '<div class="first '.$column_class.'">'.get_sub_field("flex_content_row_col1").'</div>';
                            echo '<div class="'.$column_class.'">'.get_sub_field("flex_content_row_col2").'</div>';
                            echo '<div class="'.$column_class.'">'.get_sub_field("flex_content_row_col3").'</div>';
                        } elseif ($columns == '4') {
                            $column_class = 'one-fourth';
                            echo '<div class="first '.$column_class.'">'.get_sub_field("flex_content_row_col1").'</div>';
                            echo '<div class="'.$column_class.'">'.get_sub_field("flex_content_row_col2").'</div>';
                            echo '<div class="'.$column_class.'">'.get_sub_field("flex_content_row_col3").'</div>';
                            echo '<div class="'.$column_class.'">'.get_sub_field("flex_content_row_col4").'</div>';
                        }
                    echo '</div>';
                echo '</div>';

            endif;

        endwhile;

    else :

    // no layouts found

    endif;

}

genesis();