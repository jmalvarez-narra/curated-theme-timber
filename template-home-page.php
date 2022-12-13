<?php
/*
 * Template Name: Home Page Template
 * description: >-
  This is the homepage template
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );
