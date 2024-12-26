<?php
/**
 * Define custom functions for the theme.
 *
 * @package Jove
 */

// Define custom functions here.

/**
 * Get hierarchical term items.
 *
 * @param string $taxonomy  Taxonomy.
 * @param int    $parent_id Parent term ID.
 *
 * @return array
 */
function get_hierarchical_term_items( string $taxonomy = '', int $parent_id = 0 ) : array {

	// Build query args.
	$query_args = [
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'fields'                 => 'ids',
		'posts_per_page'         => 1,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	];

	$items = [];

	// 1. Add Parent Terms.
	$the_terms = get_terms(
		[
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
			'parent'     => $parent_id,
		]
	);
	$the_terms = ! is_wp_error( $the_terms ) && ! empty( $the_terms ) ? $the_terms : [];

	foreach ( $the_terms as $the_term ) {

		$query_args['tax_query'] = [
			[
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => [ $the_term->slug ],
			],
		];

		$posts_with_the_term = new WP_Query( $query_args );

		if ( empty( $posts_with_the_term->posts ) ) {
			continue;
		}

		$term_data = [
			'label' => $the_term->name,
			'value' => $the_term->term_id,
			'slug'  => $the_term->slug,
		];

		// 2. Add Child Terms if they exist.
		$term_children = get_terms(
			[
				'taxonomy'     => $taxonomy,
				'hierarchical' => 1,
				'hide_empty'   => 0,
				'parent'       => $the_term->term_id ?? 0,
			]
		);

		if ( ! empty( $term_children ) && ! is_wp_error( $term_children ) ) {
			$term_data['children'] = [];

			foreach ( $term_children as $term_child ) {
				if ( ! empty( $term_child ) && $term_child instanceof WP_Term ) {

					$query_args['tax_query'] = [
						[
							'taxonomy' => $taxonomy,
							'field'    => 'slug',
							'terms'    => [ $term_child->slug ],
						],
					];

					$posts_with_term_child = new WP_Query( $query_args );

					if ( empty( $posts_with_term_child->posts ) ) {
						continue;
					}

					$term_child_data = [
						'label' => $term_child->name ?? '',
						'value' => $term_child->term_id ?? '',
						'slug'  => $term_child->slug,
					];

					// 3. Add grandchildren terms if they exist.
					$term_grand_children = get_terms(
						[
							'taxonomy'     => $taxonomy,
							'hierarchical' => 1,
							'hide_empty'   => 0,
							'parent'       => $term_child->term_id ?? 0,
						]
					);

					if ( ! empty( $term_grand_children ) && ! is_wp_error( $term_grand_children ) ) {
						$term_child_data['children'] = [];

						foreach ( $term_grand_children as $term_grand_child ) {
							if ( ! empty( $term_grand_child ) && $term_grand_child instanceof WP_Term ) {

								$query_args['tax_query'] = [
									[
										'taxonomy' => $taxonomy,
										'field'    => 'slug',
										'terms'    => [ $term_grand_child->slug ],
									],
								];

								$posts_with_term_grand_child = new WP_Query( $query_args );

								if ( empty( $posts_with_term_grand_child->posts ) ) {
									continue;
								}

								$term_grand_child_data = [
									'label' => $term_grand_child->name ?? '',
									'value' => $term_grand_child->term_id ?? '',
									'slug'  => $term_grand_child->slug ?? '',
								];

								// 4. Add great-grandchildren terms if they exist.
								$term_great_grand_children = get_terms(
									[
										'taxonomy'     => $taxonomy,
										'hierarchical' => 1,
										'hide_empty'   => 0,
										'parent'       => $term_grand_child->term_id ?? 0,
									]
								);

								if ( ! empty( $term_great_grand_children ) && ! is_wp_error( $term_great_grand_children ) ) {
									foreach ( $term_great_grand_children as $term_great_grand_child ) {
										if ( ! empty( $term_great_grand_child ) && $term_great_grand_child instanceof WP_Term ) {

											$query_args['tax_query'] = [
												[
													'taxonomy' => $taxonomy,
													'field'    => 'slug',
													'terms'    => [ $term_great_grand_child->slug ],
												],
											];

											$posts_with_term_great_grand_child = new WP_Query( $query_args );

											if ( empty( $posts_with_term_great_grand_child->posts ) ) {
												continue;
											}

											$term_grand_child_data['children'][] = [
												'label' => $term_great_grand_child->name ?? '',
												'value' => $term_great_grand_child->term_id ?? '',
												'slug'  => $term_great_grand_child->slug ?? '',
											];
										}
									}
								}

								$term_child_data['children'][] = $term_grand_child_data;
							}
						}
					}

					$term_data['children'][] = $term_child_data;
				}
			}
		}

		$items[] = $term_data;

	}

	return $items;
}

/**
 * Get Filter Ids with their title.
 *
 * Pairs of filter ids and title in their respective key's
 * e.g. ['destinations'=> [123 => 'Canada', 345 => 'Egypt']].
 *
 * @todo Write tests for this and add recursion for the loops
 *       inside this function.
 *
 * @param array $filters_data Filter's data.
 *
 * @return array filter ids.
 */
function get_filter_ids( array $filters_data = [] ): array {
	if ( empty( $filters_data ) || ! is_array( $filters_data ) ) {
		return [];
	}

	$filter_ids = [];

	foreach ( $filters_data as $filter_data ) {
		if (
			empty( $filter_data['slug'] )
			|| empty( $filter_data['children'] )
			|| ! is_array( $filter_data['children'] )
		) {
			continue;
		}

		// Build Data.
		$key                = $filter_data['slug'];
		$filter_ids[ $key ] = [];

		// Parent.
		foreach ( $filter_data['children'] as $parent_item ) {
			$filter_ids[ $key ][ $parent_item['value'] ] = [
				'slug' => $parent_item['slug'] ?? '',
				'text' => $parent_item['label'] ?? '',
			];

			if ( empty( $parent_item['children'] ) || ! is_array( $parent_item['children'] ) ) {
				continue;
			}

			// Children.
			foreach ( $parent_item['children'] as $child_item ) {
				$filter_ids[ $key ][ $child_item['value'] ] = [
					'slug' => $child_item['slug'] ?? '',
					'text' => $child_item['label'] ?? '',
				];

				if ( empty( $child_item['children'] ) || ! is_array( $child_item['children'] ) ) {
					continue;
				}

				// Grand Children.
				foreach ( $child_item['children'] as $grand_child_item ) {
					$filter_ids[ $key ][ $grand_child_item['value'] ] = [
						'slug' => $grand_child_item['slug'] ?? '',
						'text' => $grand_child_item['label'] ?? '',
					];

					if ( empty( $grand_child_item['children'] ) || ! is_array( $grand_child_item['children'] ) ) {
						continue;
					}

					// Great Grand Children.
					foreach ( $grand_child_item['children'] as $great_grand_child_item ) {
						$filter_ids[ $key ][ $great_grand_child_item['value'] ] = [
							'slug' => $great_grand_child_item['slug'] ?? '',
							'text' => $great_grand_child_item['label'] ?? '',
						];
					}
				}
			}
		}
	}

	return $filter_ids;
}

/**
 * Get Filters data.
 *
 * @return array[]
 */
function get_filters_data(): array {
	$category_terms = get_hierarchical_term_items( 'category' );
	$tag_terms = get_hierarchical_term_items( 'post_tag' );

	return [
		[
			'label'    => 'Categories',
			'slug'     => 'categories',
			'children' => $category_terms,
		],
		[
			'label'    => 'Tags',
			'slug'     => 'tags',
			'children' => $tag_terms,
		],
	];
}


function jove_set_default_site_logo( $block_content, $block ) {
    if ( $block['blockName'] === 'core/site-logo' && empty( $block['attrs']['url'] ) ) {
        $default_logo_url = get_template_directory_uri() . '/assets/images/logo.png';
        $block_content = sprintf(
            '<div class="wp-block-site-logo"><img src="%s" alt="%s" /></div>',
            esc_url( $default_logo_url ),
            esc_attr__( 'Site Logo', 'jove' )
        );
    }
    return $block_content;
}
//add_filter( 'render_block', 'jove_set_default_site_logo', 10, 2 );

function register_social_icons_circle_style() {
    if ( function_exists( 'register_block_style' ) ) {
        register_block_style(
            'core/social-icons', // The block to apply the style to.
            [
                'name'  => 'circle-border', // A unique identifier for the style.
                'label' => __( 'Circle with Border', 'jove' ), // Display name in the editor.
                'inline_style' => '
                    .wp-block-social-icons.is-style-circle-border .wp-block-social-icon {
                        border-radius: 50%;
                        border: 1px solid white;
                        padding: 5px;
                    }
                ',
            ]
        );
    }
}
//add_action( 'init', 'register_social_icons_circle_style' );

function add_custom_social_links_styles() {

	register_block_style(
		'core/social-links', // The block to apply the style to.
		[
			'name'  => 'outline-border', // A unique identifier for the style.
			'label' => esc_html__( 'Jove: Outline', 'jove' ), // Display name in the editor.
		]
	);
}
//add_action( 'init', 'add_custom_social_links_styles' );



function modify_existing_custom_post_labels( $labels ) {
    $labels->name               = __( 'Videos', 'jove' );
    $labels->singular_name      = __( 'Video', 'jove' );
    $labels->menu_name          = __( 'Videos', 'jove' );
    $labels->name_admin_bar     = __( 'Video', 'jove' );
    $labels->add_new            = __( 'Add New', 'jove' );
    $labels->add_new_item       = __( 'Add New Video', 'jove' );
    $labels->edit_item          = __( 'Edit Video', 'jove' );
    $labels->new_item           = __( 'New Video', 'jove' );
    $labels->view_item          = __( 'View Video', 'jove' );
    $labels->search_items       = __( 'Search Videos', 'jove' );
    $labels->not_found          = __( 'No videos found', 'jove' );
    $labels->not_found_in_trash = __( 'No videos found in Trash', 'jove' );

    return $labels;
}
//add_filter( 'post_type_labels_post', 'modify_existing_custom_post_labels' );


function modify_existing_taxonomy_labels( $args, $taxonomy ) {
    if ( 'post_tag' === $taxonomy ) {
        $args['labels']['name']              = __( 'Keywords', 'textdomain' );
        $args['labels']['singular_name']     = __( 'Keyword', 'textdomain' );
        $args['labels']['search_items']      = __( 'Search Keywords', 'textdomain' );
        $args['labels']['all_items']         = __( 'All Keywords', 'textdomain' );
        $args['labels']['edit_item']         = __( 'Edit Keyword', 'textdomain' );
        $args['labels']['view_item']         = __( 'View Keyword', 'textdomain' );
        $args['labels']['add_new_item']      = __( 'Add New Keyword', 'textdomain' );
        $args['labels']['new_item_name']     = __( 'New Keyword Name', 'textdomain' );
    }

	if ( 'category' === $taxonomy ) {
        $args['labels']['name']              = __( 'Institutions', 'textdomain' );
        $args['labels']['singular_name']     = __( 'Institution', 'textdomain' );
        $args['labels']['search_items']      = __( 'Search Institutions', 'textdomain' );
        $args['labels']['all_items']         = __( 'All Institutions', 'textdomain' );
        $args['labels']['edit_item']         = __( 'Edit Institution', 'textdomain' );
        $args['labels']['view_item']         = __( 'View Institution', 'textdomain' );
        $args['labels']['add_new_item']      = __( 'Add New Institution', 'textdomain' );
        $args['labels']['new_item_name']     = __( 'New Institution Name', 'textdomain' );
        $args['labels']['menu_name']         = __( 'Institutions', 'textdomain' );
    }

    return $args;
}
add_filter( 'register_taxonomy_args', 'modify_existing_taxonomy_labels', 10, 2 );

/**
 * Helper function to import the ACF field group if it doesn't exist.
 *
 * @link https://gist.github.com/bacoords/986029d783edf320ce93455e0f6b5dd6
 * @return void
 */
function wpe_register_acf_fields() {

	if ( function_exists( 'acf_import_field_group' ) ) {

		// Get all json files from the /acf-field-groups directory.
		$files = glob( get_template_directory() . '/inc/acf-field-groups/*.json' );

		// If no files, bail.
		if ( ! $files ) {
			return;
		}

		// Loop through each file.
		foreach ( $files as $file ) {
			// Grab the JSON file.
			$group = file_get_contents( $file );

			// Decode the JSON.
			$group = json_decode( $group, true );

			// If not empty, import it.
			if ( is_array( $group ) && ! empty( $group ) && ! acf_get_field_group( $group[0]['key'] ) ) {
				acf_import_field_group( $group [0] );
			}
		}
	}
}
add_action( 'acf/include_fields', 'wpe_register_acf_fields' );