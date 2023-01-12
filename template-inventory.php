<?php
/*
 * Template Name: Inventory Template
 * description: >-
  This is the inventory template
 */

$context = Timber::context();

$args = array(
  // Get post type car
  'post_type' => 'cars',
  // Order by post date
  'orderby' => array('date' => 'DESC'),
  // Limit posts
  'posts_per_page' => 9,
  // current page
  'paged' => 1
);

$context['cars'] = Timber::get_posts( $args );

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-inventory.twig', 'page.twig' ), $context );
