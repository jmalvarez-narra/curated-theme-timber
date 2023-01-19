<?php
/*
 * Template Name: Inventory Template
 * description: >-
  This is the inventory template
 */

$context = Timber::context();

$categories = get_categories( array(
  'name' => ['Inventory'],
  'hide_empty' => false,
));
$inventory = $categories[0];
$context['categories'] = get_categories(
  array( 'parent' => $inventory->cat_ID )
);
$context['categories'] = array_filter($context['categories'], function ($item) {
  return !is_numeric($item->name[0]) && strtolower($item->name) !== 'available' && strtolower($item->name) !== 'sold';
});

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;

Timber::render( array( 'page-inventory.twig', 'page.twig' ), $context );
