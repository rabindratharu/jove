<?php
/**
 * REST API Video controller
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;
use WP_Error;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Query;
use WP_Post;
use stdClass;
use WP_REST_Controller;

/**
 * REST API Video controller class.
 *
 * @package Jove
 */
class Video_Post_REST_Controller extends WP_REST_Controller {

	use Singleton;

	/**
	 * Constructor.
	 */
	protected function __construct() {
		$this->namespace = 'jove-video-api/v1';
		$this->rest_base = 'video';
		$this->setup_hooks();
	}

	/**
	 * Setup hooks.
	 */
	protected function setup_hooks() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/' . $this->rest_base,
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'create_video' ),
					'permission_callback' => array( $this, 'premission_check' ),
				),
			)
		);
	}

	public function premission_check( $request ) {
		return current_user_can( 'edit_posts' );
	}

	public function create_video( $request ) {
		$data = $request->get_json_params();
		$args = array(
			'post_type' => 'video',
			'post_title' => $data['title'],
			'post_content' => $data['description'],
			'post_status' => 'publish',
		);
		$post_id = wp_insert_post( $args );
		if ( is_wp_error( $post_id ) ) {
			return new WP_Error( 'create_error', $post_id->get_error_message(), array( 'status' => 500 ) );
		}
		return new WP_REST_Response( $post_id, 200 );
	}
}
