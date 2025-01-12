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

		// Prepare the post data.
		$post_data = array_merge([
			'import_id'    => $post_id, // Custom post ID.
			'post_title'   => isset($data['title']) ? sanitize_text_field($data['title']) : '',
			'post_content' => isset($data['content']) ? wp_kses_post($data['content']) : '',
			'post_status'  => 'publish',
			'post_type'    => 'video',
		], $data);

		// Insert or update the post.
		$result = wp_insert_post($post_data);

		if (is_wp_error($result)) {
			error_log('Error inserting/updating post: ' . $result->get_error_message());
		} else {
			error_log('Post successfully inserted/updated with ID: ' . $result);
		}

		return $result;
	}
}
