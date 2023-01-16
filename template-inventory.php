<?php
/*
 * Template Name: Inventory Template
 * description: >-
  This is the inventory template
 */

$context = Timber::context();

$context['categories']= get_categories( array(
  'name' => ['Available', 'Sold', 'Latest'],
  'hide_empty' => false,
));

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-inventory.twig', 'page.twig' ), $context );
