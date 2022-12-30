<?php
/*
 * Template Name: About Template
 * description: >-
  This is the about page template
 */


$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-about.twig', 'page.twig' ), $context );
