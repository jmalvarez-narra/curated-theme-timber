<?php
/**
 * The Template for displaying all first look posts
 * Post Type: firstlook
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;

$args = array(
	// Get post type car
	'post_type' => 'firstlook',
	// Get all posts
	'posts_per_page' => 10,
	// Order by post date
	'orderby' => array(
			'date' => 'DESC',
));

$gallery = get_field('main_gallery');
$context['gallery_array'] = json_encode($gallery ? $gallery : []);
$context['gallery'] = $gallery;
$context['curated'] = Timber::get_posts( $args );

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-first-look.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}
