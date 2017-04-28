<?php
//* 404 Page Template

//* Force full-width-content layout setting
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');


remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'mbird_404_content_insert' );
function mbird_404_content_insert() {
	?>
<h1 class="entry-title">Sorry! That page can’t be found.</h1>
<p>It looks like nothing was found at this location. Maybe try to use a search?</p>

<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
        <input type="search" class="search-field"
            placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>"
            value="<?php echo get_search_query() ?>" name="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
    </label>
    <input type="submit" class="search-submit"
        value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
</form>

	<?php	
}

genesis();