<?php
/*
 * Template Name: Journals Template
 * description: >-
  This is the journal template
 */

$context = Timber::context();

$args = array(
    // Get all posts
    'posts_per_page' => -1,
    // Gest post by "featured" category
    // Order by post date
    'orderby' => array(
        'date' => 'DESC',
));

$context['posts'] = Timber::get_posts( $args );

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-journal.twig', 'page.twig' ), $context );
