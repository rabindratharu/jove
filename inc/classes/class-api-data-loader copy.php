<?php
/**
 * Register Post Types
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;

/**
 * Register Post Types
 *
 * @package Jove
 */
class Api_Data_Loader {

	use Singleton;

	/**
	 * API URL
	 *
	 * @var string
	 */
	private $url = 'https://demo.wpwheels.com/blockwheels/template/wp-json/wpwheels/v1/patterns';

	/**
	 * Base URL.
	 *
	 * @access protected
	 * @var string
	 */
	protected $base_url;
	/**
	 * Base path.
	 *
	 * @access protected
	 * @var string
	 */
	protected $base_path;
	/**
	 * Subfolder name.
	 *
	 * @access protected
	 * @var string
	 */
	protected $subfolder_name;

	/**
	 * The starter templates folder.
	 *
	 * @access protected
	 * @var string
	 */
	protected $block_library_folder;
	/**
	 * The local stylesheet's path.
	 *
	 * @access protected
	 * @var string
	 */
	protected $local_template_data_path;
	/**
	 * The local stylesheet's URL.
	 *
	 * @access protected
	 * @var string
	 */
	protected $local_pages_data_url;
	/**
	 * The final data.
	 *
	 * @access protected
	 * @var string
	 */
	protected $data;
	/**
	 * Cleanup routine frequency.
	 */
	const CLEANUP_FREQUENCY = 'monthly';

	/**
	 * Private class constructor to prevent direct object creation.
	 *
	 * This method sets up all the hooks related to the post type.
	 * It is meant to be overridden in the classes which implement
	 * this trait. This is ideal for doing stuff that you only want to
	 * do once, such as hooking into actions and filters, etc.
	 */
	protected function __construct() {

		// load class.
		$this->setup_hooks();
	}

	protected function setup_hooks() {

		/**
		 * Actions.
		 */
		// Do you have the data?
		$get_data = $this->get_template_data( true );
		// Add a cleanup routine.
		$this->schedule_cleanup();
		add_filter( 'cron_schedules', [ $this, 'add_monthly_to_cron_schedule' ], 10, 1 );
		add_action( 'delete_block_library_folder', [ $this, 'delete_block_library_folder' ] );
	}

	/**
	 * Get the local data file if there.
	 *
	 * @access public
	 * @return string
	 */
	public function get_only_local_template_data( $skip_local = false ) {
		// If the local file exists, return it's data.
		return file_exists( $this->get_local_template_data_path() )
			? $this->get_local_template_data_contents()
			: '';
	}
	/**
     * Get the local data file if there, else query the API.
     *
     * @access public
     * @return string
     */
    public function get_template_data($skip_local = false) {
        if ($skip_local || !$this->local_file_exists() || $this->is_remote_file_different()) {
            if ($this->create_template_data_file()) {
                return $this->get_local_template_data_contents();
            }
        }
        
        return file_exists($this->get_local_template_data_path())
            ? $this->get_local_template_data_contents()
            : '';
    }

	/**
     * Check if the remote file size differs from the local file size.
     *
     * @access protected
     * @return bool
     */
    protected function is_remote_file_different() {
        $remote_size = $this->get_remote_file_size();
        $local_size = $this->get_local_file_size();

        return $remote_size !== $local_size;
    }

	/**
     * Get the size of the remote file.
     *
     * @access protected
     * @return int|false File size in bytes, or false on failure.
     */
    protected function get_remote_file_size() {
        $response = wp_remote_head($this->url);

        if (is_wp_error($response)) {
            return false;
        }

        return isset($response['headers']['content-length']) ? (int) $response['headers']['content-length'] : false;
    }


	/**
     * Get the size of the local file.
     *
     * @access protected
     * @return int|false File size in bytes, or false on failure.
     */
    protected function get_local_file_size() {
        $local_path = $this->get_local_template_data_path();

        return file_exists($local_path) ? filesize($local_path) : false;
    }

	/**
     * Write the data to the filesystem.
     *
     * @access protected
     * @return string|false Returns the absolute path of the file on success, or false on fail.
     */
    protected function create_template_data_file() {
        $file_path = $this->get_local_template_data_path();
        $filesystem = $this->get_filesystem();

        if (!$filesystem->exists($this->get_block_library_folder())) {
            $chmod_dir = (0755 & ~umask());
            if (defined('FS_CHMOD_DIR')) {
                $chmod_dir = FS_CHMOD_DIR;
            }
            $filesystem->mkdir($this->get_block_library_folder(), $chmod_dir);
        }

        if (!$filesystem->exists($file_path) && !$filesystem->touch($file_path)) {
            return false;
        }

        if (!$this->data) {
            $this->get_data();
        }

        if (!$filesystem->put_contents($file_path, $this->data)) {
            return false;
        }

        return $file_path;
    }
	
	/**
	 * Get data.
	 *
	 * @access public
	 * @return string
	 */
	public function get_data() {
		// Get the remote URL contents.
		$this->data = $this->get_remote_url_contents();

		return $this->data;
	}
	/**
	 * Get local data contents.
	 *
	 * @access public
	 * @return string|false Returns the data contents.
	 */
	public function get_local_template_data_contents() {
		$local_path = $this->get_local_template_data_path();

		// Check if the local exists. (true means the file doesn't exist).
		if ( $this->local_file_exists() ) {
			return false;
		}
		return file_get_contents( $local_path );
	}
	/**
	 * Get remote file contents.
	 *
	 * @access public
	 * @return string Returns the remote URL contents.
	 */
	public function get_remote_url_contents() {
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
	 * Check if the local file exists.
	 *
	 * @access public
	 * @return bool
	 */
	public function local_file_exists() {
		return ( ! file_exists( $this->get_local_template_data_path() ) );
	}
	/**
	 * Get the data path.
	 *
	 * @access public
	 * @return string
	 */
	public function get_local_template_data_path() {
		if ( ! $this->local_template_data_path ) {
			$this->local_template_data_path = $this->get_block_library_folder() . '/' . $this->get_local_template_data_filename() . '.json';
		}
		return $this->local_template_data_path;
	}
	/**
	 * Get the local data filename.
	 *
	 * This is a hash, generated from the site-URL, the wp-content path and the URL.
	 * This way we can avoid issues with sites changing their URL, or the wp-content path etc.
	 *
	 * @access public
	 * @return string
	 */
	public function get_local_template_data_filename() {
		return md5( $this->get_base_url() . $this->get_base_path() );
	}

	/**
	 * Schedule a cleanup.
	 *
	 * Deletes the templates files on a regular basis.
	 * This way templates get updated regularly.
	 *
	 * @access public
	 * @return void
	 */
	public function schedule_cleanup() {
		if ( ! is_multisite() || ( is_multisite() && is_main_site() ) ) {
			if ( ! wp_next_scheduled( 'delete_block_library_folder' ) && ! wp_installing() ) {
				wp_schedule_event( time(), self::CLEANUP_FREQUENCY, 'delete_block_library_folder' );
			}
		}
	}
	/**
	 * Add Monthly to Schedule.
	 *
	 * @param array $schedules the current schedules.
	 * @access public
	 */
	public function add_monthly_to_cron_schedule( $schedules ) {
		// Adds once monthly to the existing schedules.
		if ( ! isset( $schedules[ self::CLEANUP_FREQUENCY ] ) ) {
			$schedules[ self::CLEANUP_FREQUENCY ] = array(
				'interval' => MONTH_IN_SECONDS,
				'display' => __( 'Once Monthly', 'kadence-blocks' ),
			);
		}
		return $schedules;
	}
	/**
	 * Delete the fonts folder.
	 *
	 * This runs as part of a cleanup routine.
	 *
	 * @access public
	 * @return bool
	 */
	public function delete_block_library_folder() {
		if ( file_exists( $this->get_old_block_library_folder() ) ) {
			$this->get_filesystem()->delete( $this->get_old_block_library_folder(), true );
		}
		return $this->get_filesystem()->delete( $this->get_block_library_folder(), true );
	}
	/**
	 * Get the old folder for templates data.
	 *
	 * @access public
	 * @return string
	 */
	public function get_old_block_library_folder() {
		$old_block_library_folder = trailingslashit( $this->get_filesystem()->wp_content_dir() ) . 'jove_data';
		return $old_block_library_folder;
	}
	/**
	 * Get the folder for templates data.
	 *
	 * @access public
	 * @return string
	 */
	public function get_block_library_folder() {
		if ( ! $this->block_library_folder ) {
			$this->block_library_folder = $this->get_base_path();
			if ( $this->get_subfolder_name() ) {
				$this->block_library_folder .= $this->get_subfolder_name();
			}
		}
		return $this->block_library_folder;
	}
	/**
	 * Get the subfolder name.
	 *
	 * @access public
	 * @return string
	 */
	public function get_subfolder_name() {
		if ( ! $this->subfolder_name ) {
			$this->subfolder_name = apply_filters( 'kadence_block_library_local_data_subfolder_name', 'jove_data' );
		}
		return $this->subfolder_name;
	}
	/**
	 * Get the base path.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_path() {
		if ( ! $this->base_path ) {
			$upload_dir = wp_upload_dir();
			$this->base_path = apply_filters( 'kadence_block_library_local_data_base_path', trailingslashit( $upload_dir['basedir'] ) );
		}
		return $this->base_path;
	}
	/**
	 * Get the base URL.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_url() {
		if ( ! $this->base_url ) {
			$this->base_url = apply_filters( 'kadence_block_library_local_data_base_url', content_url() );
		}
		return $this->base_url;
	}
	/**
	 * Get the filesystem.
	 *
	 * @access protected
	 * @return WP_Filesystem
	 */
	protected function get_filesystem() {
		global $wp_filesystem;

		// If the filesystem has not been instantiated yet, do it here.
		if ( ! $wp_filesystem ) {
			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
			}
			$wpfs_creds = apply_filters( 'kadence_wpfs_credentials', false );
			WP_Filesystem( $wpfs_creds );
		}
		return $wp_filesystem;
	}
}