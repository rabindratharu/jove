<?php
/**
 * Wp Insert Post
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;

/**
 * Handles API data loading.
 *
 * @package Jove
 */
class Wp_Insert_Post {

	use Singleton;

	/**
	 * API URL
	 *
	 * @var string
	 */
	private $url = 'https://raw.githubusercontent.com/rabindratharu/jove/refs/heads/main/assets/api-data.json';

	/**
	 * The final data.
	 *
	 * @access protected
	 * @var string
	 */
	protected $data;

	/**
	 * Constructor.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Setup hooks.
	 */
	protected function setup_hooks() {

		add_action( 'wp_loaded', [ $this, 'fetch_and_insert_posts' ] );
	}

	public function fetch_and_insert_posts() {

		if ( !$this->data ) {
			$this->data = $this->get_remote_url_contents();
		}

		// Loop through the data and insert posts.
        foreach ($this->data as $key => $item) {
        	$this->insert_post($key, $item);
        }
	}

	/**
	 * Get remote file contents.
	 *
	 * @access private
	 * @return string Returns the remote URL contents.
	 */
	private function get_remote_url_contents() {
		if ( is_callable( 'network_home_url' ) ) {
			$site_url = network_home_url( '', 'http' );
		} else {
			$site_url = get_bloginfo( 'url' );
		}
		$site_url = preg_replace( '/^https/', 'http', $site_url );
		$site_url = preg_replace( '|/$|', '', $site_url );
		$args = array(
			'site' => $site_url,
		);

		// Get the response.
		$api_url  = add_query_arg( $args, $this->url );

		$response = wp_remote_get(
			$api_url,
			array(
				'timeout' => 20,
			)
		);
		// Early exit if there was an error.
		if ( is_wp_error( $response ) ) {
			return '';
		}

		// Get the CSS from our response.
		$contents = wp_remote_retrieve_body( $response );

		if (is_wp_error($contents)) {
			error_log('Error retrieving remote content.');
			return [];
		}

		$data = json_decode($contents, true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			error_log('JSON decoding error: ' . json_last_error_msg());
			return [];
		}

		return $data;

	}

	/**
	 * Insert or update a post with a specific post ID.
	 *
	 * @param int   $post_id Custom post ID.
	 * @param array $data    Post data array.
	 */
	private function insert_post($post_id, $data) {

		// Ensure required WordPress functions are loaded.
		if ( ! function_exists( 'wp_insert_post' ) ) {
			require_once ABSPATH . 'wp-admin/includes/post.php';
		}

		// Validate required fields.
		if ( empty( $data['title'] ) ) {
			error_log( 'Missing Title in item.' );
			return;
		}

		// Check if the post already exists.
		if ( ! function_exists( 'post_exists' ) ) {
			require_once ABSPATH . 'wp-admin/includes/post.php';
		}

		$existing_post_id = post_exists(
			sanitize_text_field( $data['title'] ),
			wp_kses_post( $data['content'] )
		);

		if ( $existing_post_id ) {
			error_log( 'Post already exists with ID: ' . $existing_post_id );
			return;
		}

		// Prepare post date.
		$post_date = ! empty( $data['post_date'] )
			? date( 'Y-m-d H:i:s', strtotime( sanitize_text_field( $data['post_date'] ) ) )
			: current_time( 'mysql' ); // Default to current time in WordPress timezone.


		// Prepare the post data.
		$post_data = array_merge([
			'import_id'    => $post_id, // Custom post ID.
			'post_title'   => isset($data['title']) ? sanitize_text_field($data['title']) : '',
			'post_content' => isset($data['content']) ? wp_kses_post($data['content']) : '',
			'post_status'  => 'publish',
			'post_type'    => 'video',
			'post_date'    => $post_date, // Add post date here.
		], $data);

		// Insert or update the post.
		$result = wp_insert_post($post_data);

		if (is_wp_error($result)) {
			error_log('Error inserting/updating post: ' . $result->get_error_message());
		} else {
			error_log('Post successfully inserted/updated with ID: ' . $result);
		}

		// Assign author if provided.
		if ( ! empty( $data['authors'] ) ) {
			$aurhors = array_map( 'sanitize_text_field', (array) wp_list_pluck( $data['authors'], 'name' ) );
			wp_set_post_terms( $post_id, $aurhors, 'author' );
		}

		if ( ! empty( $data['institutions'] ) ) {
			$institutions = array_map( 'sanitize_text_field', (array) wp_list_pluck( $data['institutions'], 'name' ) );
			wp_set_post_terms( $post_id, $institutions, 'institution' );

			//$this->set_terms_with_descriptions( $post_id, $data['institutions'], 'institution' );
		}

		return $result;
	}

	/**
	 * Assign terms to a post and set descriptions if provided.
	 *
	 * @param int    $post_id     Post ID.
	 * @param array  $terms       Terms with optional descriptions.
	 * @param string $taxonomy    Taxonomy name.
	 */
	private function set_terms_with_descriptions($post_id, $terms, $taxonomy) {
		// foreach ( $terms as $key => $value ) {

		// 	$term_name 		= sanitize_text_field( $value['institutionTitle'] );
		// 	$description 	= isset( $value['departmentTitle'] ) ? wp_kses_post( $value['departmentTitle'] ) : '';
		// 	// Create the term with description if it doesn't exist.
		// 	$term = wp_insert_term(
		// 		$term_name,
		// 		$taxonomy,
		// 		[ 'description' => wp_kses_post( $description ) ]
		// 	);

		// 	if ( is_wp_error( $term ) ) {
		// 		error_log( 'Error creating term: ' . $term->get_error_message() );
		// 		continue;
		// 	}

		// 	// Associate the term with the post.
		// 	wp_set_post_terms( $post_id, $term['term_id'], $taxonomy, true );
		// }
	}
}
