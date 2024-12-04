<?php
/**
 * Register Post Types
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;

/**
 * Register Post Types
 *
 * @package Jove
 */
class Register_Post_Types {

	use Singleton;

	/**
	 * Private class constructor to prevent direct object creation.
	 *
	 * This method sets up all the hooks related to the post type.
	 * It is meant to be overridden in the classes which implement
	 * this trait. This is ideal for doing stuff that you only want to
	 * do once, such as hooking into actions and filters, etc.
	 */
	protected function __construct() {

		// load class.
		$this->setup_hooks();
	}

	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		add_action( 'init', [ $this, 'create_video_cpt' ], 0 );

	}

	/**
	 * Register Custom Post Type Video
	 *
	 * The video post type is used for storing videos.
	 *
	 * @since 1.0.0
	 */
	public function create_video_cpt() {

		$labels = [
			'name'                  => _x( 'Videos', 'Post Type General Name', 'jove' ),
			'singular_name'         => _x( 'Video', 'Post Type Singular Name', 'jove' ),
			'menu_name'             => _x( 'Videos', 'Admin Menu text', 'jove' ),
			'name_admin_bar'        => _x( 'Video', 'Add New on Toolbar', 'jove' ),
			'archives'              => __( 'Video Archives', 'jove' ),
			'attributes'            => __( 'Video Attributes', 'jove' ),
			'parent_item_colon'     => __( 'Parent Video:', 'jove' ),
			'all_items'             => __( 'All Videos', 'jove' ),
			'add_new_item'          => __( 'Add New Video', 'jove' ),
			'add_new'               => __( 'Add New', 'jove' ),
			'new_item'              => __( 'New Video', 'jove' ),
			'edit_item'             => __( 'Edit Video', 'jove' ),
			'update_item'           => __( 'Update Video', 'jove' ),
			'view_item'             => __( 'View Video', 'jove' ),
			'view_items'            => __( 'View Videos', 'jove' ),
			'search_items'          => __( 'Search Video', 'jove' ),
			'not_found'             => __( 'Not found', 'jove' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'jove' ),
			'featured_image'        => __( 'Featured Image', 'jove' ),
			'set_featured_image'    => __( 'Set featured image', 'jove' ),
			'remove_featured_image' => __( 'Remove featured image', 'jove' ),
			'use_featured_image'    => __( 'Use as featured image', 'jove' ),
			'insert_into_item'      => __( 'Insert into Video', 'jove' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Video', 'jove' ),
			'items_list'            => __( 'Videos list', 'jove' ),
			'items_list_navigation' => __( 'Videos list navigation', 'jove' ),
			'filter_items_list'     => __( 'Filter Videos list', 'jove' ),
		];
		$args   = [
			'label'               => __( 'Video', 'jove' ),
			'description'         => __( 'The videos', 'jove' ),
			'labels'              => $labels,
			'menu_icon'           => 'dashicons-video-alt',
			'supports'            => [
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'revisions',
				'author',
				'comments',
				'trackbacks',
				'page-attributes',
				'custom-fields',
			],
			'taxonomies'          => [],
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'hierarchical'        => false,
			'exclude_from_search' => false,
			'show_in_rest'        => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		];

		/**
		 * Register the post type.
		 *
		 * @since 1.0.0
		 */
		register_post_type( 'jove_videos', $args );

	}
}