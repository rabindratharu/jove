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




function jove_get_authors_affiliations_posts( $args ) {
	if ( is_string( $args ) ) {
		$args = add_query_arg(
			[
				'suppress_filters' => false,
			]
		);
	} elseif ( is_array( $args ) && ! isset( $args['suppress_filters'] ) ) {
		$args['suppress_filters'] = false;
	}

	// WP_Query to fetch the post
	$items 		= [];
	$the_query 	= new WP_Query( $args );

	if ($the_query->have_posts()) {
		while ($the_query->have_posts()) { $the_query->the_post();
			$post_id = get_the_ID();
			$items[$post_id]['title'] = get_the_title();
			$items[$post_id]['url']   = get_the_permalink();
			// Get all taxonomies associated with this post type
			$taxonomies = get_object_taxonomies('author', 'names');
			foreach ($taxonomies as $taxonomy) {
				$terms = get_the_terms(get_the_ID(), $taxonomy);
				if ($terms && !is_wp_error($terms)) {
					foreach ($terms as $key => $term) {
						// echo '<pre>'; print_r($term); echo '</pre>';

						$items[$post_id][$taxonomy][$term->term_id] = $term->name;

						// if ( $taxonomy == 'affiliation' ) {
						// 	$items[$post_id][$taxonomy][$term->term_id] = $term->name;
						// }
						// else {
						// 	$items[$post_id][$taxonomy][$term->term_id]['name'] = $term->name;
						// 	$items[$post_id][$taxonomy][$term->term_id]['url'] = get_term_link($term->slug, $taxonomy);
						// }
					}
				}
			}
		}
	}
	// Reset post data
	wp_reset_postdata();

	return $items;
}


// Function to set post views
function set_post_view($post_id) {
    $count_key = 'jove_post_views';
    $count = get_post_meta($post_id, $count_key, true);

    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, 1);
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

// Function to get post views
function get_post_view($post_id) {
    $count_key = 'jove_post_views';
    $count = get_post_meta($post_id, $count_key, true);

    if ($count == '') {
        return '0';
    }

    return format_number_short($count);
}

function format_number_short( $number ) {
	$precision 		= 2;
	if ( $number >= 1000 && $number < 1000000 ) {
		$formatted 	= number_format( $number/1000, $precision ).'K';
	} else if ( $number >= 1000000 && $number < 1000000000 ) {
		$formatted 	= number_format( $number/1000000, $precision ).'M';
	} else if ( $number >= 1000000000 ) {
		$formatted 	= number_format( $number/1000000000, $precision ).'B';
	} else {
		$formatted 	= $number; // Number is less than 1000
	}
	$formatted 		= str_replace( '.00', '', $formatted );
	return $formatted;
}

// Hook into the single post to increment views
add_action('wp_head', function () {
	//if (is_single() && !is_user_logged_in()) {
    if (is_single()) {
        global $post;
        if (isset($post->ID)) {
            set_post_view($post->ID);
        }
    }
});

/**
 * Encore a string to be safely included in the URL.
 *
 * @param string $str String to encode for URL.
 */
if (! function_exists('jove_encode_uri_component')) {
	function jove_encode_uri_component( $str ) {
		$revert = [
			'%21' => '!',
			'%2A' => '*',
			'%27' => "'",
			'%28' => '(',
			'%29' => ')',
		];

		return strtr( rawurlencode( $str ), $revert );
	}
}

function get_json_file_data() {
    // Get the upload directory path
    $upload_dir = wp_upload_dir();
    $json_file_path = $upload_dir['basedir'] . '/jove/api-data.json'; // Adjust file name accordingly

    // Check if the file exists
    if (file_exists($json_file_path)) {
        // Get the contents of the JSON file
        $json_data = file_get_contents($json_file_path);

        // Decode the JSON data into an array
        $data = json_decode($json_data, true);

        // Return the parsed data or handle errors
        if ($data) {
            return $data;
        } else {
            return 'Error parsing JSON file.';
        }
    } else {
        return 'JSON file not found.';
    }
}

/**
 * Limit a string by character count without breaking words.
 *
 * @param string $string The input string to limit.
 * @param int    $limit  The maximum number of characters.
 * @param string $suffix The suffix to append if the string is trimmed (default: '...').
 * @return string The trimmed string.
 */
function limit_string_by_characters($string, $limit, $suffix = '...') {
    // Strip extra white spaces from the string.
    $string = trim($string);

    // If the string length is less than or equal to the limit, return the string as is.
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    // Trim the string to the limit without breaking words.
    $trimmed = mb_substr($string, 0, $limit);
    $last_space = mb_strrpos($trimmed, ' ');

    // Ensure we don't cut in the middle of a word.
    if ($last_space !== false) {
        $trimmed = mb_substr($trimmed, 0, $last_space);
    }

    // Return the trimmed string with the suffix.
    return $trimmed . $suffix;
}