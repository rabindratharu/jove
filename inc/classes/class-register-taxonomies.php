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
		 * Register the institution taxonomy.
		 *
		 * This action registers the institution taxonomy using the `create_author_taxonomy`
		 * method.
		 *
		 * @since 1.0.0
		 */
		add_action( 'init', [ $this, 'create_author_taxonomy' ] );
		/**
		 * Register the year taxonomy.
		 *
		 * This action registers the year taxonomy using the `create_journal_taxonomy`
		 * method.
		 *
		 * @since 1.0.0
		 */
		add_action( 'init', [ $this, 'create_journal_taxonomy' ] );
	}

	/**
	 * Register the institution taxonomy.
	 *
	 * The institution taxonomy is used for organizing videos by institution.
	 *
	 * @since 1.0.0
	 */
	public function create_author_taxonomy() {
		$labels = [
			'name'              => _x( 'Authors', 'taxonomy general name', 'jove' ),
			'singular_name'     => _x( 'Author', 'taxonomy singular name', 'jove' ),
			'search_items'      => __( 'Search Authors', 'jove' ),
			'all_items'         => __( 'All Authors', 'jove' ),
			'parent_item'       => __( 'Parent Author', 'jove' ),
			'parent_item_colon' => __( 'Parent Author:', 'jove' ),
			'edit_item'         => __( 'Edit Author', 'jove' ),
			'update_item'       => __( 'Update Author', 'jove' ),
			'add_new_item'      => __( 'Add New Author', 'jove' ),
			'new_item_name'     => __( 'New Author Name', 'jove' ),
			'menu_name'         => __( 'Authors', 'jove' ),
		];
		$args = [
			'labels'             => $labels,
			'description'        => __( 'Author', 'jove' ),
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
		register_taxonomy( 'authors', [ 'post' ], $args );
	}

	/**
	 * Register the year taxonomy.
	 *
	 * The year taxonomy is used for organizing videos by their release year.
	 *
	 * @since 1.0.0
	 */
	public function create_journal_taxonomy() {
		$labels = [
			'name'              => _x( 'Journals', 'taxonomy general name', 'jove' ),
			'singular_name'     => _x( 'Journal', 'taxonomy singular name', 'jove' ),
			'search_items'      => __( 'Search Journals', 'jove' ),
			'all_items'         => __( 'All Journals', 'jove' ),
			'parent_item'       => __( 'Parent Journal', 'jove' ),
			'parent_item_colon' => __( 'Parent Journal:', 'jove' ),
			'edit_item'         => __( 'Edit Journal', 'jove' ),
			'update_item'       => __( 'Update Journal', 'jove' ),
			'add_new_item'      => __( 'Add New Journal', 'jove' ),
			'new_item_name'     => __( 'New Journal Name', 'jove' ),
			'menu_name'         => __( 'Journals', 'jove' ),
		];
		$args = [
			'labels'             => $labels,
			'description'        => __( 'Journal', 'jove' ),
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
		register_taxonomy( 'journals', [ 'post' ], $args );
	}
}