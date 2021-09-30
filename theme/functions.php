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

/**
 * Filter to make sure `get_template_directory()` and `get_template_directory_uri()` resolve to the root theme folder
 * instead of the actual root/theme/ file where the style.css resides.
 */
function wps_filter_theme_directory(string $path): string
{
    return substr($path, 0, -6);
}

add_filter('template_directory', 'wps_filter_theme_directory', 10, 1);
add_filter('template_directory_uri', 'wps_filter_theme_directory', 10, 1);
