<?php
/**
 * Register Meta Boxes
 *
 * @package Jove
 */

namespace Jove\Inc;

use Jove\Inc\Traits\Singleton;

/**
 * Class Utils
 */
class Utils {

    use Singleton;

    /**
     * Get video details by video URL.
     *
     * @param string $video_url The video link.
     * @param int|null $post_id The post ID to fetch the thumbnail if no video thumbnail is found.
     * @return array
     */
    public static function get_video_details_by_url( $video_url, $post_id = null ) {
        $output = [];

        $youtube_id  = self::check_for_youtube( $video_url );
        $vimeo_id    = self::check_for_vimeo( $video_url );
        $media_video = self::check_for_media_video( $video_url );

        if ( $youtube_id ) {
            $youtube_details = self::get_youtube_details( $youtube_id );
            $output['thumbnail'] = $youtube_details['video_thumbnail_url'];
            $output['video_url'] = $youtube_details['video_url'];
        } elseif ( $vimeo_id ) {
            $vimeo_details       = self::get_vimeo_details( $vimeo_id );
            $output['thumbnail'] = $vimeo_details['video_thumbnail_url'];
            $output['video_url'] = $vimeo_details['video_url'];
        } elseif ( $media_video ) {
            $output['thumbnail'] = $post_id ? get_the_post_thumbnail_url( $post_id, 'full' ) : '';
            $output['video_url'] = $media_video;
        }
        return $output;
    }

    /**
     * Check if the URL is a YouTube link.
     *
     * @param string $content
     * @return string|false
     */
    private static function check_for_youtube( $content ) {
        if ( preg_match( '/\/\/(www\.)?(youtu|youtube)\.(com|be)\/(watch|embed)?\/?(\?v=)?([a-zA-Z0-9\-\_]+)/', $content, $matches ) ) {
            return $matches[6];
        }
        return false;
    }

    /**
     * Check if the URL is a Vimeo link.
     *
     * @param string $content
     * @return string|false
     */
    private static function check_for_vimeo( $content ) {
        if ( preg_match( '#https?://(.+\.)?vimeo\.com/.*#i', $content, $matches ) ) {
            return preg_replace( "/[^0-9]/", '', $matches[0] );
        }
        return false;
    }

    /**
     * Check if the URL is a custom media video link.
     *
     * @param string $content
     * @return string|false
     */
    private static function check_for_media_video( $content ) {
        $allowed_extensions = array( "mp4", "3gp", "mov", "flv", "wmv", "swf", "bmp", "avi" );
        $pattern = '/(https?:.*?\.(?:' . implode( '|', $allowed_extensions ) . '))/';

        if ( preg_match( $pattern, $content, $matches ) ) {
            return preg_replace( '/\\\\/', '', $matches[0] );
        }
        return false;
    }

    /**
     * Get YouTube video details.
     *
     * @param string $youtube_id
     * @return array
     */
    private static function get_youtube_details( $youtube_id ) {
        $thumbnail_url = 'http://img.youtube.com/vi/' . $youtube_id . '/maxresdefault.jpg';
        $response      = wp_remote_head( $thumbnail_url );

        $video['video_thumbnail_url'] = ( 404 === wp_remote_retrieve_response_code( $response ) )
            ? 'http://img.youtube.com/vi/' . $youtube_id . '/hqdefault.jpg'
            : $thumbnail_url;

        $video['video_url'] = 'https://www.youtube.com/watch?v=' . $youtube_id;

        return $video;
    }

    /**
     * Get Vimeo video details.
     *
     * @param string $vimeo_id
     * @return array|false
     */
    private static function get_vimeo_details( $vimeo_id ) {
        $response = wp_remote_get( 'http://www.vimeo.com/api/v2/video/' . intval( $vimeo_id ) . '.php' );

        if ( is_array( $response ) && isset( $response['response']['code'] ) && '200' == $response['response']['code'] ) {
            $data = unserialize( $response['body'] );

            return [
                'video_thumbnail_url' => $data[0]['thumbnail_large'] ?? false,
                'video_url'           => 'https://vimeo.com/' . $vimeo_id,
            ];
        }

        return false;
    }

	/**
	 * Fetches data from an API.
	 *
	 * @param string $url The API URL.
	 * @param array  $params The parameters to be appended to the URL as a query string.
	 *
	 * @return array The API response as an associative array.
	 */
	public static function fetch_api_data($url, $params) {
		// Initialize the cURL handle
		$ch = curl_init();

		// Set the URL
		curl_setopt($ch, CURLOPT_URL, $url);

		// Set method to POST
		curl_setopt($ch, CURLOPT_POST, true);

		// Set POST fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

		// Set options to return the response as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Set headers if needed (example: JSON content type)
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			// Content type should be specified if the API is expecting it
			// 'Content-Type: application/json'
			'Content-Type: application/x-www-form-urlencoded'
		]);

		// Execute the request and fetch the response
		$response = curl_exec($ch);

		// Check for errors
		if ($response === false) {
			$error_msg = curl_error($ch);
			curl_close($ch);
			return "cURL error: " . $error_msg;
		}

		// Close the cURL handle
		curl_close($ch);

		// Decode and return the response
		// Assuming the API returns JSON data
		return json_decode($response, true);
	}
}