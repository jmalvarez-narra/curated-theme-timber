<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

$templates = array( 'archive.twig', 'index.twig' );

global $post;
$page_slug = $post->post_name;
$context = Timber::context();

$category = get_queried_object();
$cat_id = $category->term_id;

$context['title'] = 'Archive';
if ( is_day() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'D M Y' );
} elseif ( is_month() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'M Y' );
} elseif ( is_year() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'Y' );
} elseif ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} elseif ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} elseif ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}

array_unshift( $templates, 'archive-cars.twig' );

$args = array(
	// Get post type car
	'post_type' => 'cars',
	// Get all posts
	'posts_per_page' => -1,
	// Gest post by "featured" category
	'category' => $cat_id,
	// Order by post date
	'orderby' => array(
			'date' => 'DESC',
));

$context['posts'] = Timber::get_posts( $args );

Timber::render( $templates, $context );
