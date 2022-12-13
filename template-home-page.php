<?php
/*
 * Template Name: Home Page Template
 * description: >-
  This is the homepage template
 */

$context = Timber::context();

$args = array(
// Get post type car
'post_type' => 'cars',
// Get all posts
'posts_per_page' => -1,
// Gest post by "featured" category
// Order by post date
'orderby' => array(
    'date' => 'DESC'
));

$context['cars'] = Timber::get_posts( $args );

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );
