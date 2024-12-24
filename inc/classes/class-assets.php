<?php
/**
 * Enqueue theme assets
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;

class Assets {

	use Singleton;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function __construct() {
		/**
		 * Set up hooks.
		 *
		 * This method sets up all the hooks related to the assets.
		 */
		$this->setup_hooks();
	}

	/**
	 * Set up hooks.
	 *
	 * This method sets up all the hooks related to the assets,
	 * such as styles and scripts.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function setup_hooks() {
		// Hook to register styles
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );

		// Hook to register scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
	}

	/**
	 * Register styles.
	 *
	 * This method registers the theme's styles.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_styles() {
		// Register the theme's public stylesheet.
		wp_register_style(
			'public-css',
			JOVE_BUILD_URI . '/css/public.css',
			// Dependencies.
			[],
			// Version.
			filemtime( JOVE_BUILD_PATH . '/css/public.css' ),
			// Media.
			'all'
		);

		// Register the theme's search stylesheet.
		wp_register_style(
			'search-css',
			JOVE_BUILD_URI . '/css/search.css',
			// Dependencies.
			[],
			// Version.
			filemtime( JOVE_BUILD_PATH . '/css/search.css' ),
			// Media.
			'all'
		);

		// Enqueue the stylesheet.
		wp_enqueue_style( 'public-css' );

		// If search page.
		if ( is_search() ) {
			wp_enqueue_style( 'search-css' );
		}
	}

	/**
	 * Register scripts.
	 *
	 * This method registers the theme's scripts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_scripts() {
		// Register the theme's public script.
		wp_register_script(
			// Handle.
			'public-js',
			// Source.
			JOVE_BUILD_URI . '/js/public.js',
			// Dependencies.
			[],
			// Version.
			filemtime( JOVE_BUILD_PATH . '/js/public.js' ),
			// Enqueue in footer.
			true
		);

		wp_register_script(
			// Handle.
			'search-js',
			// Source.
			JOVE_BUILD_URI . '/js/search.js',
			// Dependencies.
			['public-js'],
			// Version.
			filemtime( JOVE_BUILD_PATH . '/js/search.js' ),
			// Enqueue in footer.
			true
		);

		// Enqueue the script.
		wp_enqueue_script( 'public-js' );

		// If search page.
		if ( is_search() ) {
			$filters_data = get_filters_data();
			wp_enqueue_script( 'search-js' );
			wp_localize_script( 'search-js', 'search_settings',
				[
					'rest_api_url' => home_url( '/wp-json/jove/v1/search' ),
					'root_url'     => home_url('search'),
					'filter_ids'   => get_filter_ids( $filters_data ),
				]
			);
		}
	}
}