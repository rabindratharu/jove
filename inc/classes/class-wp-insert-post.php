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

		add_action( 'init', [ $this, 'fetch_and_insert_posts' ] );
	}

	public function fetch_and_insert_posts() {

		if ( !$this->data ) {
			$this->data = $this->get_remote_url_contents();
		}

		// Loop through the data and insert posts.
        foreach ($this->data as $item) {
            $this->insert_post($item);
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

		// Early exit if there was an error.
		if ( is_wp_error( $contents ) ) {
			return;
		}

		return $contents;
	}

	/**
	 * Insert a WordPress post from API data.
	 *
	 * @param array $item Single API item data.
	 */
	private function insert_post($item) {

		if ( ! function_exists( 'post_exists' ) ) {
			require_once ABSPATH . 'wp-admin/includes/post.php';
		}
		// Check required fields.
		if (empty($item['id']) || empty($item['title'])) {
			error_log('Missing ID or Title in item.');
			return;
		}

		// Check if the post already exists.
		$existing_post_id = post_exists(
			sanitize_text_field($item['title']),
			wp_kses_post($item['content'])
		);

		if ($existing_post_id) {
			error_log('Post already exists with ID: ' . $existing_post_id);
			return;
		}

		// Prepare post arguments.
		$post_data = [
			'ID'           => absint($item['id']),
			'post_title'   => sanitize_text_field($item['title']),
			'post_content' => wp_kses_post($item['content']),
			'post_status'  => 'publish',
			'post_type'    => 'video', // Change to custom post type if needed.
		];

		// Insert the post.
		$post_id = wp_insert_post($post_data);

		if (is_wp_error($post_id)) {
			error_log('Error inserting post: ' . $post_id->get_error_message());
		} else {
			error_log('Post inserted successfully with ID: ' . $post_id);
		}
	}

}