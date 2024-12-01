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
	 * Class constructor.
	 *
	 * The class constructor is responsible for instantiating any necessary
	 * classes and setting up the WordPress hooks.
	 *
	 * @since 1.0.0
	 */
	protected function __construct() {
		// Instantiate necessary classes.
		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$assets = Assets::get_instance();
		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$blocks = Blocks::get_instance();
		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$post_types = Register_Post_Types::get_instance();

		// Set up WordPress hooks.
		$this->setup_hooks();
	}

	/**
	 * Set up hooks.
	 *
	 * This method sets up all the hooks related to the theme,
	 * such as adding support for core block styles, adding custom
	 * styles for paginated pages, and enabling SVG uploads.
	 *
	 * @since 1.0.0
	 */
	protected function setup_hooks() {
		// Theme setup.
		// The `after_setup_theme` action hook is used to add support for
		// core block styles and remove core block patterns.
		add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );

		// Add custom styles for paginated pages.
		// The `wp_head` action hook is used to add custom styles for paginated
		// pages. The styles are added to the `<head>` of the page.
		add_action( 'wp_head', [ $this, 'add_paginated_styles' ] );

		// Filter for template part areas.
		// The `default_wp_template_part_areas` filter is used to add areas to
		// the page that can be used for template parts.
		add_filter( 'default_wp_template_part_areas', [ $this, 'template_part_areas' ] );

		// Enable SVG uploads.
		// The `upload_mimes` filter is used to enable SVG uploads.
		add_filter( 'upload_mimes', [ $this, 'allow_svg_uploads' ] );
		// The `wp_check_filetype_and_ext` filter is used to sanitize SVG uploads.
		add_filter( 'wp_check_filetype_and_ext', [ $this, 'sanitize_svg' ], 10, 4 );

		// Adjust SVG display in media library.
		// The `wp_prepare_attachment_for_js` filter is used to add SVGs to the
		// media library.
		add_filter( 'wp_prepare_attachment_for_js', [ $this, 'add_svg_to_media_library' ], 10, 3 );
	}

	/**
	 * Set up the theme.
	 *
	 * This method is responsible for setting up the theme. It adds support
	 * for core block styles and removes core block patterns.
	 *
	 * @since 1.0.0
	 */
	public function setup_theme() {
		// Add support for core block styles.
		// The `wp-block-styles` feature adds support for block styles.
		// Block styles are used to customize the look and feel of blocks.
		// They are defined in the theme.json file.
		add_theme_support( 'wp-block-styles' );

		// Remove core block patterns.
		// The `core-block-patterns` feature adds support for block patterns.
		// Block patterns are pre-designed blocks that can be used to create
		// content. They are defined in the theme.json file.
		// We are removing this feature because we are not using block patterns
		// in this theme.
		remove_theme_support( 'core-block-patterns' );
	}

	/**
	 * Add custom styles to the head for paginated pages.
	 *
	 * This method adds custom styles to the head for paginated pages.
	 * The styles are used to hide the separator between posts on the last
	 * page of a paginated page.
	 *
	 * @since 1.0.0
	 */
	public function add_paginated_styles() {
		// Get the current query.
		global $wp_query;

		// Check if we are on a paginated page.
		if ( $wp_query->max_num_pages < 2 ) {
			// If we are not on a paginated page, add the custom styles.
			echo '<style>
				/*
				 * Hide the separator between posts on the last page of a
				 * paginated page.
				 */
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
	 * This method adds a sidebar template part area to the areas.
	 * The sidebar template part area is used to add content to the sidebar
	 * of the page with sidebar template.
	 *
	 * @since 1.0.0
	 *
	 * @param array $areas Default template part areas.
	 * @return array Modified areas with sidebar added.
	 */
	public function template_part_areas( array $areas ) {
		// Add sidebar template part area.
		$areas[] = [
			'area'        => 'sidebar',
			'area_tag'    => 'section',
			'label'       => __( 'Sidebar', 'jove' ),
			'description' => __( 'Sidebar for the Page (With Sidebar) template.', 'jove' ),
			'icon'        => 'sidebar',
		];

		// Return the modified areas.
		return $areas;
	}

	/**
	 * Allow SVG uploads.
	 *
	 * This method adds SVG mime type to the allowed mime types,
	 * so users can upload SVG files.
	 *
	 * @since 1.0.0
	 *
	 * @param array $mimes Allowed mime types.
	 * @return array Modified mime types with SVG support.
	 */
	public function allow_svg_uploads( $mimes ) {
		// Add SVG mime type to the allowed mime types.
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Sanitize SVG uploads.
	 *
	 * SVG files uploaded to WordPress are not natively supported. This method
	 * works around this limitation by modifying the file type data so that
	 * it is treated as an image.
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
		// If the file extension is SVG, set the type to SVG.
		if ( 'svg' === strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) ) {
			$data['type'] = 'image/svg+xml';
		}

		// Return the sanitized data.
		return $data;
	}

	/**
	 * Add SVG support to the media library.
	 *
	 * This method adds SVG support to the media library by modifying the attachment
	 * response data. It checks if the attachment is an image and if it is an SVG file.
	 * If the file is an SVG file, it sets the file path as the image source.
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
			// Get the file path of the attachment.
			$svg_path = get_attached_file( $attachment->ID );

			// Check if the file exists.
			if ( file_exists( $svg_path ) ) {
				// Load the SVG file.
				$svg = simplexml_load_file( $svg_path );

				// Check if the file was loaded successfully.
				if ( $svg ) {
					// Set the image source to the file path.
					$response['image']['src'] = wp_get_attachment_url( $attachment->ID );
				}
			}
		}

		// Return the modified response data.
		return $response;
	}
}