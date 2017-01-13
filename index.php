<?php
/**
 * Blog Intro
 *
 */
namespace Mockingbird\Developers;


add_action('genesis_before_loop', __NAMESPACE__. '\add_blog_intro');

function add_blog_intro() {
    $posts_page = get_option('page_for_posts');
    if (is_null($posts_page)) {
        return;
    }
    $title = get_post($posts_page)->post_title;
    $content = get_post($posts_page)->post_content;
    $title_output = $content_output = '';
    
    if ($content) {
        $content_output = wpautop($content);
    }
    if ( $title || $content ) {
        printf( '<div class="archive-description">%s</div>', $title_output . $content_output );
    }
    
}

genesis();
