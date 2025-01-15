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
	 * Option name for storing file size.
	 *
	 * @var string
	 */
	private $file_size_option = 'jove_api_file_size';

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

		// Get the current file size from the remote source.
		$current_file_size = $this->get_remote_file_size();

		if ( $current_file_size === false ) {
			error_log( 'Failed to retrieve remote file size. Skipping fetch.' );
			return;
		}

		// Retrieve the previously stored file size from the database.
		$stored_file_size = get_option( $this->file_size_option, 0 );

		// If the file size has not changed, skip fetching and inserting posts.
		if ( $current_file_size == $stored_file_size ) {
			error_log( 'File size unchanged. Skipping data fetch and insertion.' );
			return;
		}

		// Fetch and insert posts if the file size has changed.
		$this->data = $this->get_remote_url_contents();

		if ( ! empty( $this->data ) ) {
			foreach ( $this->data as $post_id => $data ) {
				$this->insert_post( $post_id, $data );
			}

			// Update the stored file size after processing.
			update_option( $this->file_size_option, $current_file_size );
		}
	}

	/**
	 * Get the size of the remote file.
	 *
	 * @return int|false File size in bytes, or false on failure.
	 */
	protected function get_remote_file_size() {
		$response = wp_remote_head( $this->url );
		if ( is_wp_error( $response ) ) {
			error_log( 'Failed to get remote file size: ' . $response->get_error_message() );
			return false;
		}
		return isset( $response['headers']['content-length'] ) ? (int) $response['headers']['content-length'] : false;
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
	private function insert_post( $post_id, $data ) {
		// Ensure required WordPress functions are loaded.
		if ( ! function_exists( 'wp_insert_post' ) ) {
			require_once ABSPATH . 'wp-admin/includes/post.php';
		}

		// Check if the post already exists.
		if ( ! function_exists( 'post_exists' ) ) {
			require_once ABSPATH . 'wp-admin/includes/post.php';
		}

		// Validate required fields.
		if ( empty( $data['title'] ) ) {
			error_log( 'Missing Title in item.' );
			return;
		}

		// Check if the post already exists by title and content.
		$existing_post_id = post_exists(
			sanitize_text_field( $data['title'] ),
			wp_kses_post( $data['content'] )
		);

		// Use the existing post ID if editing from the dashboard or already present.
		if ( $existing_post_id && $existing_post_id != $post_id ) {
			error_log( 'Post already exists with ID: ' . $existing_post_id );
			$post_id = $existing_post_id;
		}

		// Prepare post date.
		$post_date = ! empty( $data['post_date'] )
			? date( 'Y-m-d H:i:s', strtotime( sanitize_text_field( $data['post_date'] ) ) )
			: current_time( 'mysql' );

		// Prepare the post data.
		$post_data = [
			'import_id'    => intval($post_id), // Update if post ID exists.
			'post_title'   => sanitize_text_field( $data['title'] ),
			'post_content' => wp_kses_post( $data['content'] ),
			'post_status'  => 'publish',
			'post_type'    => 'video',
			'post_date'    => $post_date,
		];

		// Insert or update the post.
		$result = wp_insert_post( $post_data );

		if ( is_wp_error( $result ) ) {
			error_log( 'Error inserting/updating post: ' . $result->get_error_message() );
		} else {
			error_log( 'Post successfully inserted/updated with ID: ' . $result );
		}

		// Assign terms if provided.
		$this->assign_terms( $result, $data, 'authors', 'author' );
		$this->assign_terms( $result, $data, 'institutions', 'institution' );
		$this->assign_terms( $result, $data, 'journals', 'journal' );
		$this->assign_terms( $result, $data, 'Keywords', 'keyword' );

		return $result;
	}

	/**
	 * Assign terms to a post.
	 *
	 * @param int    $post_id Post ID.
	 * @param array  $data    Data array.
	 * @param string $key     Data key for terms.
	 * @param string $taxonomy Taxonomy name.
	 */
	private function assign_terms( $post_id, $data, $key, $taxonomy ) {
		if ( ! empty( $data[ $key ] ) ) {
			$terms = array_map( 'sanitize_text_field', (array) wp_list_pluck( $data[ $key ], 'name' ) );
			wp_set_post_terms( $post_id, $terms, $taxonomy );
		}
	}
}