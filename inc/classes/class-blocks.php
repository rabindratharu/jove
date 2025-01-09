<?php
/**
 * Blocks
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;

/**
 * Class Blocks
 *
 * @package Jove
 */
class Blocks {

	use Singleton;

	/**
	 * Protected class constructor to prevent direct object creation
	 *
	 * This is meant to be overridden in the classes which implement
	 * this trait. This is ideal for doing stuff that you only want to
	 * do once, such as hooking into actions and filters, etc.
	 */
	protected function __construct() {

		/**
		 * Set up hooks.
		 *
		 * This method sets up all the hooks related to the blocks,
		 * such as registering block styles and block pattern categories.
		 */
		$this->setup_hooks();
	}

	/**
	 * Sets up hooks.
	 *
	 * This method sets up all the hooks related to the blocks,
	 * such as registering block styles and block pattern categories.
	 *
	 * @since 1.0.0
	 */
	protected function setup_hooks() {

		/**
		 * Actions.
		 *
		 * @since 1.0.0
		 */
		add_action( 'init', [ $this, 'register_blocks' ] );
		add_action( 'init', [ $this, 'register_block_styles' ] );
		add_action( 'init', [ $this, 'register_block_pattern_categories' ], 9 );
	}

	public function register_blocks() {
		register_block_type( JOVE_BUILD_PATH . '/blocks/hero/block.json' );
		register_block_type( JOVE_BUILD_PATH . '/blocks/cta/block.json' );
		register_block_type( JOVE_BUILD_PATH . '/blocks/divider/block.json' );
		register_block_type( JOVE_BUILD_PATH . '/blocks/search/block.json' );
		register_block_type( JOVE_BUILD_PATH . '/blocks/abstract/block.json' );
		register_block_type( JOVE_BUILD_PATH . '/blocks/experiment/block.json' );
		register_block_type( JOVE_BUILD_PATH . '/blocks/concept/block.json' );

	}

	/**
	 * Registers block styles.
	 *
	 * This function registers all the block styles for the blocks in the theme.
	 * It loops through the array of block styles and registers each style using
	 * the `register_block_style` function.
	 *
	 * @since 1.0.0
	 */
	public function register_block_styles() {

		/**
		 * Loop through each block and its styles.
		 */
		foreach ( $this->get_block_styles() as $block => $styles ) {

			/**
			 * Loop through each style and register it.
			 */
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

	/**
	 * Gets the block styles to register.
	 *
	 * This method returns an array of block styles to be registered with the theme.
	 * Each block type has associated styles that can be applied, enabling
	 * customization and consistent design throughout the theme.
	 *
	 * @since 1.0.0
	 *
	 * @return array The block styles to register.
	 */
	protected function get_block_styles() {
		return array(
			// Core button block styles
			'core/button' => array(
				'secondary-button' => __( 'Secondary', 'jove' ),
			),
			// Core list block styles
			'core/list' => array(
				'list-check'        => __( 'Check', 'jove' ),
				'list-check-circle' => __( 'Check Circle', 'jove' ),
				'list-boxed'        => __( 'Boxed', 'jove' ),
				'list-none'        	=> __( 'Jove: None Style', 'jove' ),
				'list-inline-sept' 	=> __( 'Jove: Inline Sept', 'jove' ),
			),
			// Core social link block styles
			'core/social-links' => array(
				'outline-border' => __( 'Jove: Outline', 'jove' ),
			),
			// Core code block styles
			'core/code' => array(
				'dark-code' => __( 'Dark', 'jove' ),
			),
			// Core cover block styles
			'core/cover' => array(
				'blur-image-less' => __( 'Blur Image Less', 'jove' ),
				'blur-image-more' => __( 'Blur Image More', 'jove' ),
				'rounded-cover'   => __( 'Rounded', 'jove' ),
			),
			// Core column block styles
			'core/column' => array(
				'column-box-shadow' => __( 'Box Shadow', 'jove' ),
			),
			// Core post excerpt block styles
			'core/post-excerpt' => array(
				'excerpt-truncate-2' => __( 'Truncate 2 Lines', 'jove' ),
				'excerpt-truncate-3' => __( 'Truncate 3 Lines', 'jove' ),
				'excerpt-truncate-4' => __( 'Truncate 4 Lines', 'jove' ),
			),
			// Core group block styles
			'core/group' => array(
				'column-box-shadow' => __( 'Box Shadow', 'jove' ),
				'background-blur'   => __( 'Background Blur', 'jove' ),
			),
			// Core separator block styles
			'core/separator' => array(
				'separator-dotted' => __( 'Dotted', 'jove' ),
				'separator-thin'   => __( 'Thin', 'jove' ),
			),
			// Core image block styles
			'core/image' => array(
				'rounded-full' => __( 'Rounded Full', 'jove' ),
				'media-boxed'  => __( 'Boxed', 'jove' ),
			),
			// Core preformatted block styles
			'core/preformatted' => array(
				'preformatted-dark' => __( 'Dark Style', 'jove' ),
			),
			// Core post terms block styles
			'core/post-terms' => array(
				'term-button' => __( 'Button Style', 'jove' ),
			),
			// Core video block styles
			'core/video' => array(
				'media-boxed' => __( 'Boxed', 'jove' ),
			),
		);
	}

	/**
	 * Registers the block pattern categories.
	 *
	 * The block pattern categories are for the user to easily find the patterns
	 * that are most relevant to them. The categories are registered with the
	 * `register_block_pattern_category` function, which takes the name of the
	 * category and an array of properties to register.
	 *
	 * @since 1.0.0
	 */
	public function register_block_pattern_categories() {
		/**
		 * Get the block pattern categories to register.
		 *
		 * @since 1.0.0
		 *
		 * @return array The block pattern categories to register.
		 */
		$categories = $this->get_block_pattern_categories();

		foreach ( $categories as $name => $properties ) {
			/**
			 * Register a block pattern category.
			 *
			 * @since 1.0.0
			 *
			 * @param string $name The name of the pattern category.
			 * @param array  $properties The properties of the pattern category.
			 */
			register_block_pattern_category( $name, $properties );
		}
	}

	/**
	 * Gets the block pattern categories to register.
	 *
	 * The block pattern categories are used to group block patterns together
	 * for the user to easily find the patterns that are most relevant to them.
	 * The categories are registered with the `register_block_pattern_category`
	 * function, which takes the name of the category and an array of properties
	 * to register.
	 *
	 * @since 1.0.0
	 *
	 * @return array The block pattern categories to register.
	 */
	protected function get_block_pattern_categories() {
		return array(
			'jove/card'           => array(
				/**
				 * The label for the 'jove/card' category.
				 *
				 * The label is the human-readable name for the category that
				 * is displayed to the user in the block editor.
				 *
				 * @var string
				 */
				'label' => __( 'Cards', 'jove' ),
			),
			'jove/call-to-action' => array(
				/**
				 * The label for the 'jove/call-to-action' category.
				 *
				 * The label is the human-readable name for the category that
				 * is displayed to the user in the block editor.
				 *
				 * @var string
				 */
				'label' => __( 'Call To Action', 'jove' ),
			),
			'jove/features'       => array(
				/**
				 * The label for the 'jove/features' category.
				 *
				 * The label is the human-readable name for the category that
				 * is displayed to the user in the block editor.
				 *
				 * @var string
				 */
				'label' => __( 'Features', 'jove' ),
			),
			'jove/hero'           => array(
				/**
				 * The label for the 'jove/hero' category.
				 *
				 * The label is the human-readable name for the category that
				 * is displayed to the user in the block editor.
				 *
				 * @var string
				 */
				'label' => __( 'Hero', 'jove' ),
			),
			'jove/pages'          => array(
				/**
				 * The label for the 'jove/pages' category.
				 *
				 * The label is the human-readable name for the category that
				 * is displayed to the user in the block editor.
				 *
				 * @var string
				 */
				'label' => __( 'Pages', 'jove' ),
			),
			'jove/posts'          => array(
				/**
				 * The label for the 'jove/posts' category.
				 *
				 * The label is the human-readable name for the category that
				 * is displayed to the user in the block editor.
				 *
				 * @var string
				 */
				'label' => __( 'Posts', 'jove' ),
			),
			'jove/pricing'        => array(
				/**
				 * The label for the 'jove/pricing' category.
				 *
				 * The label is the human-readable name for the category that
				 * is displayed to the user in the block editor.
				 *
				 * @var string
				 */
				'label' => __( 'Pricing', 'jove' ),
			),
			'jove/testimonial'    => array(
				/**
				 * The label for the 'jove/testimonial' category.
				 *
				 * The label is the human-readable name for the category that
				 * is displayed to the user in the block editor.
				 *
				 * @var string
				 */
				'label' => __( 'Testimonials', 'jove' ),
			),
		);
	}

}