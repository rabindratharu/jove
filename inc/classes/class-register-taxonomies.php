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
		 * Register the taxonomy.
		 *
		 * This action registers the taxonomy using the `register_taxonomies`
		 * method.
		 *
		 * @since 1.0.0
		 */
		add_action( 'init', [ $this, 'register_taxonomies' ], 0 );
	}

	/**
     * Register a taxonomy, post_types_categories for the post types.
     *
     * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    public function register_taxonomies() {

        if ( ! is_blog_installed() ) {
            return;
        }

        // Add new taxonomy, make it hierarchical
        $custom_taxonomy_types = self::taxonomy_args();

        if ( $custom_taxonomy_types ) {

            foreach ( $custom_taxonomy_types as $key =>  $value ) {

                if ( 'category' == $value['hierarchical'] ) {

                    // Add new taxonomy, make it hierarchical (like categories)
                    $labels = array(
                        'name'              => esc_html_x( $value['general_name'], 'taxonomy general name', 'jove' ),
                        'singular_name'     => esc_html_x( $value['singular_name'], 'taxonomy singular name', 'jove' ),
                        'search_items'      => esc_html__( 'Search ' . $value['general_name'], 'jove' ),
                        'all_items'         => esc_html__( 'All ' . $value['general_name'], 'jove' ),
                        'parent_item'       => esc_html__( 'Parent ' . $value['general_name'], 'jove' ),
                        'parent_item_colon' => esc_html__( 'Parent ' . $value['general_name'] .':', 'jove' ),
                        'edit_item'         => esc_html__( 'Edit ' . $value['general_name'] , 'jove' ),
                        'update_item'       => esc_html__( 'Update '  . $value['general_name'] , 'jove' ),
                        'add_new_item'      => esc_html__( 'Add ' . $value['general_name'], 'jove' ),
                        'new_item_name'     => esc_html__( 'New ' . $value['general_name'] .' Name', 'jove' ),
                        'menu_name'         => esc_html__( $value['general_name'], 'jove' ),
                    );

                    $args = array(
                        'hierarchical'      => true,
                        'labels'            => $labels,
                        'show_ui'           => true,
                        'show_in_menu'      => 'jove',
                        'show_admin_column' => true,
                        'show_in_nav_menus' => true,
                        'show_in_rest'      => true,
                        'rewrite'           => array( 'slug' => $value['slug'], 'hierarchical' => true, 'with_front' => false ),
                    );
                    register_taxonomy( $key, $value['post_type'], $args );

                }

                if ( 'tag' == $value['hierarchical'] ) {

                    $labels = array(
                        'name'                       => esc_html_x( $value['general_name'], 'taxonomy general name', 'jove' ),
                        'singular_name'              => esc_html_x( $value['singular_name'], 'taxonomy singular name', 'jove' ),
                        'search_items'               => esc_html__( 'Search ' . $value['general_name'], 'jove' ),
                        'popular_items'              => esc_html__( 'Popular ' .$value['general_name'], 'jove' ),
                        'all_items'                  => esc_html__( 'All ' . $value['general_name'], 'jove' ),
                        'parent_item'                => null,
                        'parent_item_colon'          => null,
                        'edit_item'                  => esc_html__( 'Edit ' .$value['singular_name'], 'jove' ),
                        'update_item'                => esc_html__( 'Update '. $value['singular_name'], 'jove' ),
                        'add_new_item'               => esc_html__( 'Add ' .$value['singular_name'], 'jove' ),
                        'new_item_name'              => esc_html__( 'New ' . $value['singular_name'] . ' Name', 'jove' ),
                        'separate_items_with_commas' => esc_html__( 'Separate ' . strtolower($value['general_name'] ) . ' with commas', 'jove' ),
                        'add_or_remove_items'        => esc_html__( 'Add or remove ' . strtolower($value['general_name'] ), 'jove' ),
                        'choose_from_most_used'      => esc_html__( 'Choose from the most used '. strtolower($value['general_name'] ), 'jove' ),
                        'not_found'                  => esc_html__( 'No ' . strtolower($value['general_name'] ) . ' found.', 'jove' ),
                        'menu_name'                  => esc_html__( $value['general_name'], 'jove' ),
                    );

                    $args = array(
                        'hierarchical'      => false,
                        'labels'            => $labels,
                        'show_ui'           => true,
                        'show_admin_column' => true,
                        'show_in_nav_menus' => true,
                        'show_in_rest'      => true,
                        'rewrite'           => array( 'slug' => $value['slug'], 'hierarchical' => true, 'with_front' => false ),
                    );
                    register_taxonomy( $key, $value['post_type'], $args );

                }

            }

        }
    }

	/**
     * Get taxonomy types arguments
     *
     * @return array of default settings
     */
    public static function taxonomy_args() {

        return array(
			'author' => array(
                'hierarchical'      => 'tag',
                'slug'              => 'author',
                'singular_name'     => esc_html__('Author', 'jove'),
                'general_name'	    => esc_html__('Authors', 'jove'),
                'post_type'         => array( 'video' ),
            ),
			'institution' => array(
                'hierarchical'      => 'tag',
                'slug'              => 'institution',
                'singular_name'     => esc_html__('Institution', 'jove'),
                'general_name'	    => esc_html__('Institutions', 'jove'),
                'post_type'         => array( 'video' ),
            ),
			'journal' => array(
                'hierarchical'      => 'tag',
                'slug'              => 'journal',
                'singular_name'     => esc_html__('Journal', 'jove'),
                'general_name'	    => esc_html__('Journals', 'jove'),
                'post_type'         => array( 'video' ),
            ),
			'keyword' => array(
                'hierarchical'      => 'tag',
                'slug'              => 'keyword',
                'singular_name'     => esc_html__('Keyword', 'jove'),
                'general_name'	    => esc_html__('Keywords', 'jove'),
                'post_type'         => array( 'video' ),
            ),
        );
    }
}