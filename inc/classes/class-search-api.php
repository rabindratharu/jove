<?php
/**
 * Search API
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;
use WP_Query;
use WP_Post;
use stdClass;

/**
 * Class Search_Api
 *
 * Handles the custom REST API search endpoint.
 */
class Search_Api {

	use Singleton;

	/**
	 * Protected class constructor to prevent direct object creation.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Sets up hooks.
	 *
	 * @since 1.0.0
	 */
	protected function setup_hooks() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Register the routes for the REST API controller.
	 */
	public function register_routes(): void {
		/**
		 * Register search api.
		 * e.g. https://example.com/wp-json/jove/v1/search?s='Hello'&categories=23,43&post_tag=23,32&page_no=1&posts_per_page=9
		 */
		register_rest_route(
			'jove/v1',
			'/search',
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_items' ],
				'permission_callback' => '__return_true',
				'args'                => [
					's' => [
						'required'          => false,
						'type'              => 'string',
						'description'       => esc_html__( 'Search query', 'jove' ),
						'sanitize_callback' => 'sanitize_text_field',
					],
					'categories' => [
						'required'          => false,
						'type'              => 'string',
						'description'       => esc_html__( 'Comma-separated category IDs', 'jove' ),
						'sanitize_callback' => 'sanitize_text_field',
					],
					'tags' => [
						'required'          => false,
						'type'              => 'string',
						'description'       => esc_html__( 'Comma-separated tag IDs', 'jove' ),
						'sanitize_callback' => 'sanitize_text_field',
					],
					'author' => [
						'required'          => false,
						'type'              => 'string',
						'description'       => esc_html__( 'Comma-separated author IDs', 'jove' ),
						'sanitize_callback' => 'sanitize_text_field',
					],
					'institution' => [
						'required'          => false,
						'type'              => 'string',
						'description'       => esc_html__( 'Comma-separated institution IDs', 'jove' ),
						'sanitize_callback' => 'sanitize_text_field',
					],
					'journal' => [
						'required'          => false,
						'type'              => 'string',
						'description'       => esc_html__( 'Comma-separated journal IDs', 'jove' ),
						'sanitize_callback' => 'sanitize_text_field',
					],
					'page_no' => [
						'required'          => false,
						'type'              => 'integer',
						'description'       => esc_html__( 'Page number', 'jove' ),
						'default'           => 1,
					],
					'posts_per_page' => [
						'required'          => false,
						'type'              => 'integer',
						'description'       => esc_html__( 'Number of posts per page', 'jove' ),
						'default'           => 10,
					],
				],
			]
		);
	}

	/**
	 * Handles the search API request.
	 *
	 * @param WP_REST_Request $request The request object.
	 * @return WP_REST_Response The response object.
	 */
	public function get_items( WP_REST_Request $request ): WP_REST_Response {
		$search_term     = $request->get_param( 's' );
		$category_ids    = $request->get_param( 'categories' );
		$tag_ids         = $request->get_param( 'tags' );
		$author_ids      = $request->get_param( 'author' );
		$institution_ids = $request->get_param( 'institution' );
		$journal_ids     = $request->get_param( 'journal' );
		$post_type       = $request->get_param( 'post_type' ) ?: [ 'video' ]; // Default to 'post' and 'video'.
		$page_no         = (int) $request->get_param( 'page_no' );
		$posts_per_page  = (int) $request->get_param( 'posts_per_page' );

		$query_args = [
			'post_status'            => 'publish',
			'posts_per_page'         => $posts_per_page,
			'paged'                  => $page_no,
			'post_type'              => $post_type, // Include custom post type.
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		];

		// Add search query if provided.
		if ( ! empty( $search_term ) ) {
			$query_args['s'] = $search_term;
		}

		// Add taxonomy query if categories, tags, authors, institutions, or journals are provided.
		if ( ! empty( $category_ids ) || ! empty( $tag_ids ) || ! empty( $author_ids ) || ! empty( $institution_ids ) || ! empty( $journal_ids ) ) {
			$query_args['tax_query'] = [];
		}

		// Add category filter.
		if ( ! empty( $category_ids ) ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'category',
				'field'    => 'id',
				'terms'    => array_map( 'intval', explode( ',', $category_ids ) ),
				'operator' => 'IN',
			];
		}

		// Add tag filter.
		if ( ! empty( $tag_ids ) ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'post_tag',
				'field'    => 'id',
				'terms'    => array_map( 'intval', explode( ',', $tag_ids ) ),
				'operator' => 'IN',
			];
		}

		// Add author filter.
		if ( ! empty( $author_ids ) ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'author',
				'field'    => 'id',
				'terms'    => array_map( 'intval', explode( ',', $author_ids ) ),
				'operator' => 'IN',
			];
		}

		// Add institution filter.
		if ( ! empty( $institution_ids ) ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'institution',
				'field'    => 'id',
				'terms'    => array_map( 'intval', explode( ',', $institution_ids ) ),
				'operator' => 'IN',
			];
		}

		// Add journal filter.
		if ( ! empty( $journal_ids ) ) {
			$query_args['tax_query'][] = [
				'taxonomy' => 'journal',
				'field'    => 'id',
				'terms'    => array_map( 'intval', explode( ',', $journal_ids ) ),
				'operator' => 'IN',
			];
		}

		// Perform the query.
		$results = new WP_Query( $query_args );

		// Build and return the response.
		return rest_ensure_response( $this->build_response( $results ) );
	}

	/**
	 * Builds the response data.
	 *
	 * @param WP_Query $results The query results.
	 * @return stdClass The formatted response data.
	 */
	private function build_response( WP_Query $results ): stdClass {
		$posts = [];

		if ( ! empty( $results->posts ) && is_array( $results->posts ) ) {
			foreach ( $results->posts as $post ) {
				if ( ! $post instanceof WP_Post ) {
					continue;
				}

				$posts[] = [
					'id'        => $post->ID,
					'title'     => esc_html( get_the_title( $post ) ),
					'content'   => wp_trim_words( wp_strip_all_tags( get_the_content( null, false, $post ) ), 40 ),
					'date'      => get_the_date( get_option( 'date_format' ), $post ),
					'permalink' => get_permalink( $post ),
					'journal'   => get_the_term_list( $post, 'journal', '', ', ', '' ),

				];
			}
		}

		// Calculate total pages.
		$total_pages = $this->calculate_page_count(
			$results->found_posts ?? 0,
			$results->query['posts_per_page'] ?? 0
		);

		return (object) [
			'posts'          => $posts,
			'total_posts'    => $results->found_posts,
			'posts_per_page' => $results->query['posts_per_page'],
			'no_of_pages'    => $total_pages,
		];
	}

	/**
	 * Calculates the total number of pages.
	 *
	 * @param int $total_found_posts Total posts found.
	 * @param int $posts_per_page    Posts per page.
	 * @return int Total number of pages.
	 */
	private function calculate_page_count( int $total_found_posts, int $posts_per_page ): int {
		if ( $total_found_posts <= 0 || $posts_per_page <= 0 ) {
			return 0;
		}
		return (int) ceil( $total_found_posts / $posts_per_page );
	}
}