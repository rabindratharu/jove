<?php
/**
 * Register Meta Boxes
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;

/**
 * Class Meta_Boxes
 */
class Meta_Boxes {

	use Singleton;

	protected function __construct() {

		// load class.
		$this->setup_hooks();
	}

	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		add_action( 'add_meta_boxes', [ $this, 'add_custom_meta_box' ] );
		add_action( 'save_post', [ $this, 'save_post_meta_data' ] );

	}

	/**
	 * Add custom meta box.
	 *
	 * @return void
	 */
	public function add_custom_meta_box() {
		$screens = [ 'post' ];
		foreach ( $screens as $screen ) {
			add_meta_box(
				'video_url_meta_box',           	// Unique ID
				__( 'Video URL', 'aquila' ),  		// Box title
				[ $this, 'custom_meta_box_html' ],  // Content callback, must be of type callable
				$screen,                   			// Post type
				'side', 							// context
				'default'                   		// Priority.
			);
		}
	}

	/**
	 * Custom meta box HTML( for form )
	 *
	 * @param object $post Post.
	 *
	 * @return void
	 */
	public function custom_meta_box_html( $post ) {

		// Retrieve current value of the meta key if it exists.
    	$video_url = get_post_meta( $post->ID, '_video_url', true );

		/**
		 * Use nonce for verification.
		 * This will create a hidden input field with id and name as
		 * 'video_url_meta_box_nonce' and unique nonce input value.
		 */
    	wp_nonce_field( 'save_video_url_meta_box', 'video_url_meta_box_nonce' );

		?>
<p>
    <input type="url" name="video_url" id="video_url" value="<?php echo esc_url( $video_url ); ?>"
        style="width: 100%;" />
</p>
<?php
	}

	/**
	 * Save post meta into database
	 * when the post is saved.
	 *
	 * @param integer $post_id Post id.
	 *
	 * @return void
	 */
	public function save_post_meta_data( $post_id ) {

		/**
		 * When the post is saved or updated we get $_POST available
		 * Check if the current user is authorized
		 */
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if nonce is set and valid.
		if ( ! isset( $_POST['video_url_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['video_url_meta_box_nonce'], 'save_video_url_meta_box' ) ) {
			return;
		}
		// Sanitize and save the data.
		if ( isset( $_POST['video_url'] ) ) {
			$video_url = sanitize_text_field( $_POST['video_url'] );
			update_post_meta( $post_id, '_video_url', $video_url );
		} else {
			delete_post_meta( $post_id, '_video_url' );
		}
	}

}
