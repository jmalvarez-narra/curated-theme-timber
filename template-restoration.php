<?php
/*
 * Template Name: Restoration Template
 * description: >-
  This is the restoration page template
 */


$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-restoration.twig', 'page.twig' ), $context );
