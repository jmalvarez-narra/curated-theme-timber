<?php
/**
 * The Template for displaying all car posts
 * Post Type: cars
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

$gallery = get_field('main_gallery');
$context['gallery'] = json_encode($gallery ? $gallery : []);
$context['latest'] = Timber::get_posts( $args );

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-car.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}
