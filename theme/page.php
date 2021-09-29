<?php
/**
 * The template for displaying all pages
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header();

while (have_posts()) {
    the_post();
    get_template_part('templates/content/content', 'page');
}

get_footer();
