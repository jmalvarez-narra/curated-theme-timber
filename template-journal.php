<?php
/*
 * Template Name: Journals Template
 * description: >-
  This is the journal template
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( array( 'page-journal.twig', 'page.twig' ), $context );
