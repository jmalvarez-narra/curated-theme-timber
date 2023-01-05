<?php
/*
 * Template Name: Contact Page Template
 * description: >-
  This is the contact page template
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-contact.twig', 'page.twig' ), $context );
