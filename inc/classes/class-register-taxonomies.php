<?php
/**
 * Register Custom Taxonomies
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;

/**
 * Class Register_Taxonomies
 *
 * @package Jove
 */
class Register_Taxonomies {

	use Singleton;

	/**
	 * Class constructor.
	 *
	 * The class constructor is responsible for setting up all the hooks related
	 * to the taxonomies. It is meant to be overridden in the classes which
	 * implement this trait. This is ideal for doing stuff that you only want to
	 * do once, such as hooking into actions and filters, etc.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Set up hooks.
	 *
	 * This method sets up all the hooks related to the taxonomies,
	 * such as registering the type and year taxonomies.
	 *
	 * @since 1.0.0
	 */
	protected function setup_hooks() {
		/**
		 * Register the type taxonomy.
		 *
		 * This action registers the type taxonomy using the `create_type_taxonomy`
		 * method.
		 *
		 * @since 1.0.0
		 */
		add_action( 'init', [ $this, 'create_type_taxonomy' ] );
		/**
		 * Register the institution taxonomy.
		 *
		 * This action registers the institution taxonomy using the `create_institution_taxonomy`
		 * method.
		 *
		 * @since 1.0.0
		 */
		add_action( 'init', [ $this, 'create_institution_taxonomy' ] );
		/**
		 * Register the year taxonomy.
		 *
		 * This action registers the year taxonomy using the `create_year_taxonomy`
		 * method.
		 *
		 * @since 1.0.0
		 */
		add_action( 'init', [ $this, 'create_year_taxonomy' ] );
	}

	/**
	 * Register the genre taxonomy.
	 *
	 * The genre taxonomy is used for organizing videos by genre.
	 *
	 * @since 1.0.0
	 */
	public function create_type_taxonomy() {
		$labels = [
			'name'              => _x( 'Types', 'taxonomy general name', 'jove' ),
			'singular_name'     => _x( 'Type', 'taxonomy singular name', 'jove' ),
			'search_items'      => __( 'Search Types', 'jove' ),
			'all_items'         => __( 'All Types', 'jove' ),
			'parent_item'       => __( 'Parent Type', 'jove' ),
			'parent_item_colon' => __( 'Parent Type:', 'jove' ),
			'edit_item'         => __( 'Edit Type', 'jove' ),
			'update_item'       => __( 'Update Type', 'jove' ),
			'add_new_item'      => __( 'Add New Type', 'jove' ),
			'new_item_name'     => __( 'New Type Name', 'jove' ),
			'menu_name'         => __( 'Type', 'jove' ),
		];
		$args = [
			'labels'             => $labels,
			'description'        => __( 'video Type', 'jove' ),
			'hierarchical'       => true,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_tagcloud'      => true,
			'show_in_quick_edit' => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
		];
		register_taxonomy( 'jove_type', [ 'jove_videos' ], $args );
	}

	/**
	 * Register the institution taxonomy.
	 *
	 * The institution taxonomy is used for organizing videos by institution.
	 *
	 * @since 1.0.0
	 */
	public function create_institution_taxonomy() {
		$labels = [
			'name'              => _x( 'Institutions', 'taxonomy general name', 'jove' ),
			'singular_name'     => _x( 'Institution', 'taxonomy singular name', 'jove' ),
			'search_items'      => __( 'Search Institutions', 'jove' ),
			'all_items'         => __( 'All Institutions', 'jove' ),
			'parent_item'       => __( 'Parent Institution', 'jove' ),
			'parent_item_colon' => __( 'Parent Institution:', 'jove' ),
			'edit_item'         => __( 'Edit Institution', 'jove' ),
			'update_item'       => __( 'Update Institution', 'jove' ),
			'add_new_item'      => __( 'Add New Institution', 'jove' ),
			'new_item_name'     => __( 'New Institution Name', 'jove' ),
			'menu_name'         => __( 'Institution', 'jove' ),
		];
		$args = [
			'labels'             => $labels,
			'description'        => __( 'Video Institution', 'jove' ),
			'hierarchical'       => true,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_tagcloud'      => true,
			'show_in_quick_edit' => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
		];
		register_taxonomy( 'jove_institution', [ 'jove_videos' ], $args );
	}

	/**
	 * Register the year taxonomy.
	 *
	 * The year taxonomy is used for organizing videos by their release year.
	 *
	 * @since 1.0.0
	 */
	public function create_year_taxonomy() {
		$labels = [
			'name'              => _x( 'Years', 'taxonomy general name', 'jove' ),
			'singular_name'     => _x( 'Year', 'taxonomy singular name', 'jove' ),
			'search_items'      => __( 'Search Years', 'jove' ),
			'all_items'         => __( 'All Years', 'jove' ),
			'parent_item'       => __( 'Parent Year', 'jove' ),
			'parent_item_colon' => __( 'Parent Year:', 'jove' ),
			'edit_item'         => __( 'Edit Year', 'jove' ),
			'update_item'       => __( 'Update Year', 'jove' ),
			'add_new_item'      => __( 'Add New Year', 'jove' ),
			'new_item_name'     => __( 'New Year Name', 'jove' ),
			'menu_name'         => __( 'Year', 'jove' ),
		];
		$args = [
			'labels'             => $labels,
			'description'        => __( 'video Release Year', 'jove' ),
			'hierarchical'       => false,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_tagcloud'      => true,
			'show_in_quick_edit' => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
		];
		register_taxonomy( 'jove_year', [ 'jove_videos' ], $args );
	}
}