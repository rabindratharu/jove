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
	 */
	protected function __construct() {
		// Instantiate necessary classes.
		Assets::get_instance();
		Blocks::get_instance();

		// Setup WordPress hooks.
		$this->setup_hooks();
	}

	/**
	 * Set up hooks.
	 *
	 * @since 1.0.0
	 */
	protected function setup_hooks() {
		// Theme setup.
		add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

		// Add custom styles for paginated pages.
		add_action( 'wp_head', [ $this, 'add_paginated_styles' ] );

		// Filter for template part areas.
		add_filter( 'default_wp_template_part_areas', [ $this, 'template_part_areas' ] );

		// Enable SVG uploads.
		add_filter( 'upload_mimes', [ $this, 'allow_svg_uploads' ] );
		add_filter( 'wp_check_filetype_and_ext', [ $this, 'sanitize_svg' ], 10, 4 );

		// Adjust SVG display in media library.
		add_filter( 'wp_prepare_attachment_for_js', [ $this, 'add_svg_to_media_library' ], 10, 3 );
	}

	/**
	 * Theme setup.
	 *
	 * @since 1.0.0
	 */
	public function setup_theme() {
		// Add support for core block styles.
		add_theme_support( 'wp-block-styles' );

		// Remove core block patterns.
		remove_theme_support( 'core-block-patterns' );
	}

	/**
	 * Add custom styles to the head for paginated pages.
	 *
	 * @since 1.0.0
	 */
	public function add_paginated_styles() {
		global $wp_query;

		if ( $wp_query->max_num_pages < 2 ) {
			echo '<style>
				.blog .wp-block-post-template .wp-block-post:last-child .entry-content + .wp-block-separator,
				.archive .wp-block-post-template .wp-block-post:last-child .entry-content + .wp-block-separator,
				.search .wp-block-post-template .wp-block-post:last-child .entry-content + .wp-block-separator {
					display: none;
				}
			</style>';
		}
	}

	/**
	 * Add a sidebar template part area.
	 *
	 * @since 1.0.0
	 *
	 * @param array $areas Default template part areas.
	 * @return array Modified areas with sidebar added.
	 */
	public function template_part_areas( array $areas ) {
		$areas[] = [
			'area'        => 'sidebar',
			'area_tag'    => 'section',
			'label'       => __( 'Sidebar', 'jove' ),
			'description' => __( 'Sidebar for the Page (With Sidebar) template.', 'jove' ),
			'icon'        => 'sidebar',
		];

		return $areas;
	}

	/**
	 * Allow SVG uploads.
	 *
	 * @since 1.0.0
	 *
	 * @param array $mimes Allowed mime types.
	 * @return array Modified mime types with SVG support.
	 */
	public function allow_svg_uploads( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Sanitize SVG uploads.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $data File type data.
	 * @param string $file Full path to the file.
	 * @param string $filename Name of the file.
	 * @param array  $mimes Allowed mime types.
	 * @return array Sanitized file data.
	 */
	public function sanitize_svg( $data, $file, $filename, $mimes ) {
		if ( 'svg' === strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) ) {
			$data['type'] = 'image/svg+xml';
		}

		return $data;
	}

	/**
	 * Add SVG support to the media library.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $response Attachment response data.
	 * @param object $attachment Attachment object.
	 * @param array  $meta Attachment metadata.
	 * @return array Modified response data.
	 */
	public function add_svg_to_media_library( $response, $attachment, $meta ) {
		if ( $response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists( 'SimpleXMLElement' ) ) {
			$svg_path = get_attached_file( $attachment->ID );

			if ( file_exists( $svg_path ) ) {
				$svg = simplexml_load_file( $svg_path );

				if ( $svg ) {
					$response['image']['src'] = wp_get_attachment_url( $attachment->ID );
				}
			}
		}

		return $response;
	}
}