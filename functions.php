<?php
/**
 * This file adds functions to the Jove WordPress theme.
 *
 * @package jove
 * @author  The JoVE Team
 * @license GNU General Public License v2 or later
 * @link    https://www.jove.com
 */

namespace Jove;

/**
 * Set up theme defaults and register various WordPress features.
 */
function setup() {

	// Enqueue editor styles and fonts.
	add_editor_style( 'style.css' );

	// Remove core block patterns.
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\setup' );


/**
 * Enqueue styles.
 */
function enqueue_style_sheet() {
	wp_enqueue_style( sanitize_title( __NAMESPACE__ ), get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_style_sheet' );


/**
 * Add block style variations.
 */
function register_block_styles() {

	$block_styles = array(
		'core/button'                    => array(
			'secondary-button' => __( 'Secondary', 'jove' ),
		),
		'core/list'                      => array(
			'list-check'        => __( 'Check', 'jove' ),
			'list-check-circle' => __( 'Check Circle', 'jove' ),
			'list-boxed'        => __( 'Boxed', 'jove' ),
		),
		'core/code'                      => array(
			'dark-code' => __( 'Dark', 'jove' ),
		),
		'core/cover'                     => array(
			'blur-image-less' => __( 'Blur Image Less', 'jove' ),
			'blur-image-more' => __( 'Blur Image More', 'jove' ),
			'rounded-cover'   => __( 'Rounded', 'jove' ),
		),
		'core/column'                    => array(
			'column-box-shadow' => __( 'Box Shadow', 'jove' ),
		),
		'core/post-excerpt'              => array(
			'excerpt-truncate-2' => __( 'Truncate 2 Lines', 'jove' ),
			'excerpt-truncate-3' => __( 'Truncate 3 Lines', 'jove' ),
			'excerpt-truncate-4' => __( 'Truncate 4 Lines', 'jove' ),
		),
		'core/group'                     => array(
			'column-box-shadow' => __( 'Box Shadow', 'jove' ),
			'background-blur' => __( 'Background Blur', 'jove' ),
		),
		'core/separator'                 => array(
			'separator-dotted' => __( 'Dotted', 'jove' ),
			'separator-thin'   => __( 'Thin', 'jove' ),
		),
		'core/image'                     => array(
			'rounded-full' => __( 'Rounded Full', 'jove' ),
			'media-boxed'  => __( 'Boxed', 'jove' ),
		),
		'core/preformatted'              => array(
			'preformatted-dark' => __( 'Dark Style', 'jove' ),
		),
		'core/post-terms'                => array(
			'term-button' => __( 'Button Style', 'jove' ),
		),
		'core/video'                     => array(
			'media-boxed' => __( 'Boxed', 'jove' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\register_block_styles' );


/**
 * Load custom block styles only when the block is used.
 */
function enqueue_custom_block_styles() {

	// Scan our styles folder to locate block styles.
	$files = glob( get_template_directory() . '/assets/styles/*.css' );

	foreach ( $files as $file ) {

		// Get the filename and core block name.
		$filename   = basename( $file, '.css' );
		$block_name = str_replace( 'core-', 'core/', $filename );

		wp_enqueue_block_style(
			$block_name,
			array(
				'handle' => "jove-block-{$filename}",
				'src'    => get_theme_file_uri( "assets/styles/{$filename}.css" ),
				'path'   => get_theme_file_path( "assets/styles/{$filename}.css" ),
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\enqueue_custom_block_styles' );


/**
 * Register pattern categories.
 */
function pattern_categories() {

	$block_pattern_categories = array(
		'jove/card'           => array(
			'label' => __( 'Cards', 'jove' ),
		),
		'jove/call-to-action' => array(
			'label' => __( 'Call To Action', 'jove' ),
		),
		'jove/features'       => array(
			'label' => __( 'Features', 'jove' ),
		),
		'jove/hero'           => array(
			'label' => __( 'Hero', 'jove' ),
		),
		'jove/pages'          => array(
			'label' => __( 'Pages', 'jove' ),
		),
		'jove/posts'          => array(
			'label' => __( 'Posts', 'jove' ),
		),
		'jove/pricing'        => array(
			'label' => __( 'Pricing', 'jove' ),
		),
		'jove/testimonial'    => array(
			'label' => __( 'Testimonials', 'jove' ),
		),
	);

	foreach ( $block_pattern_categories as $name => $properties ) {
		register_block_pattern_category( $name, $properties );
	}
}
add_action( 'init', __NAMESPACE__ . '\pattern_categories', 9 );


/**
 * Remove last separator on blog/archive if no pagination exists.
 */
function is_paginated() {
	global $wp_query;
	if ( $wp_query->max_num_pages < 2 ) {
		echo '<style>.blog .wp-block-post-template .wp-block-post:last-child .entry-content + .wp-block-separator, .archive .wp-block-post-template .wp-block-post:last-child .entry-content + .wp-block-separator, .blog .wp-block-post-template .wp-block-post:last-child .entry-content + .wp-block-separator, .search .wp-block-post-template .wp-block-post:last-child .wp-block-post-excerpt + .wp-block-separator { display: none; }</style>';
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\is_paginated' );


/**
 * Add a Sidebar template part area
 */
function template_part_areas( array $areas ) {
	$areas[] = array(
		'area'        => 'sidebar',
		'area_tag'    => 'section',
		'label'       => __( 'Sidebar', 'jove' ),
		'description' => __( 'The Sidebar template defines a page area that can be found on the Page (With Sidebar) template.', 'jove' ),
		'icon'        => 'sidebar',
	);

	return $areas;
}
add_filter( 'default_wp_template_part_areas', __NAMESPACE__ . '\template_part_areas' );