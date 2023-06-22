<?php
/**
 * The Template for displaying all single posts
 *
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
	'post_type' => 'cars',
	// Get all posts
	'posts_per_page' => -1,
	// Gest post by "featured" category
	'category_name' => 'latest',
	// Order by post date
	'orderby' => array(
			'date' => 'DESC',
));

$context['gallery'] = get_field('main_gallery');
$context['latest'] = Timber::get_posts( $args );

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}
