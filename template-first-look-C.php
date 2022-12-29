<?php
/*
 * Template Name: First Look Page Template C
 * description: >-
  This is the first look page template
 */


$context = Timber::context();

$args = array(
  // Get post type car
  'post_type' => 'cars',
  // Get all posts
  'posts_per_page' => -1,
  // Gest post by "featured" category
  'category_name' => 'curated',
  // Order by post date
  'orderby' => array(
      'date' => 'DESC',
));

$context['curated'] = Timber::get_posts( $args );

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-first-look-C.twig', 'page.twig' ), $context );
