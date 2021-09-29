<?php

/**
 * HTML Head logic called in header.php
 */
function theme_head(): void
{
    if (is_singular() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Call vanilla wp_head, loads HTML head-residing dependencies.
    wp_head();
}

add_action('wps_theme_head', 'theme_head', 10);
