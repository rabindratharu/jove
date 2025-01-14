Pull API Example
In this approach, WordPress fetches data from an external API and creates posts using that data.

<?php
/**
 * Fetch data from an external API and insert WordPress posts.
 */

function pull_api_and_insert_posts() {
    // External API URL.
    $api_url = 'https://api.example.com/posts';

    // Fetch data from the API.
    $response = wp_remote_get( $api_url, [ 'timeout' => 20 ] );

    if ( is_wp_error( $response ) ) {
        error_log( 'Error fetching API data: ' . $response->get_error_message() );
        return;
    }

    $data = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( json_last_error() !== JSON_ERROR_NONE ) {
        error_log( 'JSON decoding error: ' . json_last_error_msg() );
        return;
    }

    // Loop through API data and insert posts.
    foreach ( $data as $item ) {
        if ( empty( $item['title'] ) || empty( $item['content'] ) ) {
            continue; // Skip incomplete data.
        }

        // Check if post already exists.
        if ( ! function_exists( 'post_exists' ) ) {
            require_once ABSPATH . 'wp-admin/includes/post.php';
        }

        $existing_post_id = post_exists( $item['title'] );
        if ( $existing_post_id ) {
            error_log( 'Post already exists with ID: ' . $existing_post_id );
            continue;
        }

        // Insert post.
        $post_data = [
            'post_title'   => sanitize_text_field( $item['title'] ),
            'post_content' => wp_kses_post( $item['content'] ),
            'post_status'  => 'publish',
            'post_type'    => 'post', // Use custom post type if needed.
        ];

        $post_id = wp_insert_post( $post_data );

        if ( is_wp_error( $post_id ) ) {
            error_log( 'Error inserting post: ' . $post_id->get_error_message() );
        } else {
            error_log( 'Post inserted successfully with ID: ' . $post_id );
        }
    }
}

// Hook the function to run periodically (e.g., via a cron job).
add_action( 'wp_loaded', 'pull_api_and_insert_posts' );


Push API Example
In this method, an external application pushes data to your WordPress site via a custom REST API endpoint.

1. Register a Custom REST API Endpoint
<?php
/**
 * Register a custom REST API endpoint for post creation.
 */

function register_push_api_endpoint() {
    register_rest_route( 'custom-api/v1', '/create-post', [
        'methods'             => 'POST',
        'callback'            => 'handle_push_api_request',
        'permission_callback' => function () {
            return current_user_can( 'edit_posts' ); // Add proper authentication here.
        },
    ] );
}

add_action( 'rest_api_init', 'register_push_api_endpoint' );

function handle_push_api_request( $request ) {
    $parameters = $request->get_json_params();

    // Validate input data.
    if ( empty( $parameters['title'] ) || empty( $parameters['content'] ) ) {
        return new WP_Error( 'missing_data', 'Missing required fields: title or content.', [ 'status' => 400 ] );
    }

    // Check if post already exists.
    if ( ! function_exists( 'post_exists' ) ) {
        require_once ABSPATH . 'wp-admin/includes/post.php';
    }

    $existing_post_id = post_exists( $parameters['title'] );
    if ( $existing_post_id ) {
        return new WP_Error( 'post_exists', 'Post already exists.', [ 'status' => 400 ] );
    }

    // Insert the post.
    $post_data = [
        'post_title'   => sanitize_text_field( $parameters['title'] ),
        'post_content' => wp_kses_post( $parameters['content'] ),
        'post_status'  => 'publish',
        'post_type'    => 'post', // Use custom post type if needed.
    ];

    $post_id = wp_insert_post( $post_data );

    if ( is_wp_error( $post_id ) ) {
        return new WP_Error( 'insert_failed', $post_id->get_error_message(), [ 'status' => 500 ] );
    }

    return rest_ensure_response( [ 'message' => 'Post created successfully.', 'post_id' => $post_id ] );
}

2. Example Request to Push Data
Use a tool like Postman or write a script to push data to the endpoint:

Endpoint:
https://your-site.com/wp-json/custom-api/v1/create-post

Request:
{
    "title": "API Pushed Post",
    "content": "This is the content pushed via API."
}
Notes
Pull API:

Scheduled with wp-cron or triggered manually.
Useful when WordPress needs to pull data from a third-party service.
Push API:

External applications trigger the API to push data to WordPress.
Requires authentication (e.g., API keys, OAuth, or basic authentication) for secure access.
Both approaches can be customized for advanced scenarios, such as handling custom fields, taxonomies, or media uploads.
