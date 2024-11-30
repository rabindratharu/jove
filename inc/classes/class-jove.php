<?php
/**
 * Bootstraps the Theme.
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;

class Jove {

	use Singleton;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function __construct() {

		/**
		 * Instantiate classes.
		 */
		Assets::get_instance();
		Blocks::get_instance();

		/**
		 * Setup hooks.
		 */
		$this->setup_hooks();
	}

	/**
	 * Set up hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );
		// Add content to the page head.
		add_action( 'wp_head', [ $this, 'is_paginated' ] );
		// Add our custom template part areas.
		add_filter( 'default_wp_template_part_areas', [ $this, 'template_part_areas' ] );

	}

	/**
	 * Set up theme.
	 *
	 * This function is hooked into the "after_setup_theme" action hook.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_theme() {

		// Add support for core block styles.
		// https://developer.wordpress.org/block-editor/developers/themes/theme-support/#supporting-block-styles
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles and fonts.
		//add_editor_style( 'style.css' );

		// Remove core block patterns.
		// https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-core-block-patterns
		remove_theme_support( 'core-block-patterns' );
	}

	/**
	 * Conditionally hide the last separator on the blog, archive, and search pages
	 * when pagination is not needed.
	 *
	 * This function is hooked into the "wp_head" action hook.
	 *
	 * @since 1.0.0
	 */
	public function is_paginated() {
		global $wp_query;

		// When there is only one page, hide the last separator.
		if ( $wp_query->max_num_pages < 2 ) {
			echo '<style>
				/*
				 * Hide the last separator on the blog page.
				 * This is a page containing a list of posts.
				 */
				.blog .wp-block-post-template .wp-block-post:last-child .entry-content + .wp-block-separator,

				/*
				 * Hide the last separator on the archive page.
				 * This is a page containing a list of posts from a specific category, tag, author, etc.
				 */
				.archive .wp-block-post-template .wp-block-post:last-child .entry-content + .wp-block-separator,

				/*
				 * Hide the last separator on the search page.
				 * This is a page containing the search results.
				 */
				.search .wp-block-post-template .wp-block-post:last-child .entry-content + .wp-block-separator {
					display: none;
				}
			</style>';
		}
	}

	/**
	 * Adds a Sidebar template part area to the given areas array.
	 *
	 * This function modifies the provided array of template part areas by
	 * adding a new configuration for a sidebar template part, which can be used
	 * in the "Page (With Sidebar)" template.
	 *
	 * @param array $areas The array of template part areas.
	 * 
	 * @return array The modified array of template part areas with the sidebar added.
	 */
	public function template_part_areas(array $areas) {
		// Define the sidebar template part area configuration.
		$sidebar_area = array(
			'area'        => 'sidebar',
			'area_tag'    => 'section',
			'label'       => __( 'Sidebar', 'jove' ),
			'description' => __( 'The Sidebar template defines a page area that can be found on the Page (With Sidebar) template.', 'jove' ),
			'icon'        => 'sidebar',
		);

		// Add the sidebar configuration to the areas array.
		$areas[] = $sidebar_area;

		// Return the modified areas array.
		return $areas;
	}

}