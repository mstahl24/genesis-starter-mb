<?php
/**
 * Blog Intro
 *
 */
add_action('genesis_before_loop', 'add_blog_intro');

function add_blog_intro() {
    $posts_page = get_option('page_for_posts');
    if (is_null($posts_page)) {
        return;
    }
    $title = get_post($posts_page)->post_title;
    $content = get_post($posts_page)->post_content;
    $title_output = $content_output = '';
    if ($title) {
        $title_output = sprintf('<h1 class="archive-title">%s</h1>', $title);
    }
    if ($content) {
        $content_output = wpautop($content);
    }
    if ($title || $content) {
        printf('<div class="archive-description">%s</div>', $title_output . $content_output);
    }
}

genesis();
