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
			JOVE_BUILD_URI . '/public/index.css',
			// Dependencies.
			[],
			// Version.
			filemtime( JOVE_BUILD_PATH . '/public/index.css' ),
			// Media.
			'all'
		);

		// Enqueue the stylesheet.
		wp_enqueue_style( 'public-css' );
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
			JOVE_BUILD_URI . '/public/index.js',
			// Dependencies.
			[],
			// Version.
			filemtime( JOVE_BUILD_PATH . '/public/index.js' ),
			// Enqueue in footer.
			true
		);

		// Enqueue the script.
		wp_enqueue_script( 'public-js' );
	}
}