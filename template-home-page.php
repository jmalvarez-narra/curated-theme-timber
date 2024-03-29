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
    'posts_per_page' => 10,
    // Gest post by "featured" category
    'category_name' => 'featured',
    // Order by post date
    'orderby' => array(
        'date' => 'DESC',
));

$context['highlights'] = Timber::get_posts( $args );

$args = array(
    // Get post type car
    'post_type' => 'firstlook',
    // Get all posts
    'posts_per_page' => 10,
    // Order by post date
    'orderby' => array(
        'date' => 'DESC',
));

$context['curated'] = Timber::get_posts( $args );

$args = array(
    // Get post type car
    'post_type' => 'cars',
    // Get all posts
    'posts_per_page' => 10,
    // Gest post by "featured" category
    'category_name' => 'latest',
    // Order by post date
    'orderby' => array(
        'date' => 'DESC',
));

$context['latest'] = Timber::get_posts( $args );

$args = array(
    // Get all posts
    'posts_per_page' => 10,
    // Order by post date
    'orderby' => array(
        'date' => 'DESC',
));

$context['journal'] = Timber::get_posts( $args );

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );
