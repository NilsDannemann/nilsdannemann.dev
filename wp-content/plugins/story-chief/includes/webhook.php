<?php

namespace Storychief\Webhook;

use WP_REST_Request;
use WP_Error;

function register_routes() {
    register_rest_route('storychief', 'webhook', array(
        'methods'  => 'POST',
        'callback' =>  __NAMESPACE__ . '\handle',
    ));
}
add_action('rest_api_init', __NAMESPACE__ . '\register_routes');


/**
 * The Main webhook function, orchestrates the requested event to its corresponding function.
 *
 * @param WP_REST_Request $request
 * @return mixed
 */
function handle(WP_REST_Request $request) {
    // We do this because some badly configured servers will return notices and warnings
    // that get prepended or appended to the rest response.
    error_reporting(0);

    $payload = json_decode($request->get_body(), true);

    if (!\Storychief\Tools\validMac($payload)) return new WP_Error('invalid_mac', 'The Mac is invalid', array('status' => 400));
    if (!isset($payload['meta']['event'])) return new WP_Error('no_event_type', 'The event is not set', array('status' => 400));

    $payload = apply_filters('storychief_before_handle_filter', $payload);

    if (isset($payload['meta']['fb-page-ids'])) {
        \Storychief\Settings\update_sc_option('meta_fb_pages', $payload['meta']['fb-page-ids']);
    }

    switch ($payload['meta']['event']) {
        case 'publish':
            $response = handlePublish($payload);
            break;
        case 'update':
            $response = handleUpdate($payload);
            break;
        case 'delete':
            $response = handleDelete($payload);
            break;
        case 'test':
            $response = handleConnectionCheck($payload);
            break;
        default:
            $response = missingMethod();
            break;
    }

    if (is_wp_error($response)) return $response;
    if (!is_null($response)) $response  = \Storychief\Tools\appendMac($response);

    return rest_ensure_response($response);
}

/**
 * Handle a publish webhook call
 *
 * @param $payload
 * @return array
 */
function handlePublish($payload) {
    $story = $payload['data'];

    // Before publish action
    do_action('storychief_before_publish_action', array_merge($story));

    $post = array(
        'post_title'   => $story['title'],
        'post_content' => $story['content'],
        'post_excerpt' => $story['excerpt'] ? $story['excerpt'] : '',
        'post_status'  => (\Storychief\Settings\get_sc_option('test_mode')) ? 'draft' : 'publish',
        'meta_input'   => array(),
    );

    // Author
    if (isset($story['author']['data']['email'])) {
        $user_id = email_exists($story['author']['data']['email']);
        if (!$user_id && \Storychief\Settings\get_sc_option('author_create')) {
            $user_id = wp_create_user($story['author']['data']['email'], '', $story['author']['data']['email']);
            wp_update_user(array(
                'ID'            => $user_id,
                'first_name'    => $story['author']['data']['first_name'],
                'last_name'     => $story['author']['data']['last_name'],
                'display_name'  => $story['author']['data']['first_name'] . ' ' . $story['author']['data']['last_name'],
                'user_nicename' => $story['author']['data']['first_name'] . ' ' . $story['author']['data']['last_name'],
                'description'   => $story['author']['data']['bio'],
                'role'          => 'author',
            ));
        }

        $post['post_author'] = $user_id ? $user_id : null;
    }

    // Set the slug
    if (isset($story['seo_slug']) && !empty($story['seo_slug'])) {
        $post['post_name'] = $story['seo_slug'];
    }

    if (isset($story['amphtml'])) {
        $post['meta_input']['_amphtml'] = $story['amphtml'];
    }

    // disable sanitation
    kses_remove_filters();
    // create post
    $post_ID = wp_insert_post($post);
    // enable sanitation
    kses_init_filters();

    $story = array_merge($story, array('external_id' => $post_ID));

    // Tags
    do_action('storychief_save_tags_action', $story);

    // Categories
    do_action('storychief_save_categories_action', $story);

    // Featured Image
    do_action('storychief_save_featured_image_action', $story);

    // SEO
    do_action('storychief_save_seo_action', $story);

    // After publish action
    do_action('storychief_sideload_images_action', $post_ID);
    do_action('storychief_after_publish_action', $story);

    $permalink = \Storychief\Tools\getPermalink($post_ID);

    return array(
        'id'        => $post_ID,
        'permalink' => $permalink,
    );
}

/**
 * Handle a update webhook call
 *
 * @param $payload
 * @return array|WP_Error
 */
function handleUpdate($payload) {
    $story = $payload['data'];

    if (!get_post_status($story['external_id'])) {
        return new WP_Error('post_not_found', 'The post could not be found', array('status' => 404));
    }

    // After publish action
    do_action('storychief_before_publish_action', array_merge($story));

    $post = array(
        'ID'           => $story['external_id'],
        'post_title'   => $story['title'],
        'post_content' => $story['content'],
        'post_excerpt' => $story['excerpt'] ? $story['excerpt'] : '',
        'post_status'  => (\Storychief\Settings\get_sc_option('test_mode')) ? 'draft' : 'publish',
        'meta_input'   => array(),
    );

    // Author
    if (isset($story['author']['data']['email'])) {
        $user_id = email_exists($story['author']['data']['email']);
        if (!$user_id && \Storychief\Settings\get_sc_option('author_create')) {
            $user_id = wp_create_user($story['author']['data']['email'], '', $story['author']['data']['email']);
            wp_update_user(array(
                'ID'            => $user_id,
                'first_name'    => $story['author']['data']['first_name'],
                'last_name'     => $story['author']['data']['last_name'],
                'display_name'  => $story['author']['data']['first_name'] . ' ' . $story['author']['data']['last_name'],
                'user_nicename' => $story['author']['data']['first_name'] . ' ' . $story['author']['data']['last_name'],
                'description'   => $story['author']['data']['bio'],
                'role'          => 'author',
            ));
        }

        $post['post_author'] = $user_id ? $user_id : null;
    }

    // Set the slug
    if (isset($story['seo_slug']) && !empty($story['seo_slug'])) {
        $post['post_name'] = $story['seo_slug'];
    }

    if (isset($story['amphtml'])) {
        $post['meta_input']['_amphtml'] = $story['amphtml'];
    }

    // disable sanitation
    kses_remove_filters();
    // update post
    $post_ID = wp_update_post($post);
    // enable sanitation
    kses_init_filters();

    $story = array_merge($story, array('external_id' => $post_ID));

    // Tags
    do_action('storychief_save_tags_action', $story);

    // Categories
    do_action('storychief_save_categories_action', $story);

    // Featured Image
    do_action('storychief_save_featured_image_action', $story);

    // SEO
    do_action('storychief_save_seo_action', $story);

    // After publish action
    do_action('storychief_sideload_images_action', $post_ID);
    do_action('storychief_after_publish_action', $story);

    $permalink = \Storychief\Tools\getPermalink($post_ID);

    return array(
        'id'        => $post_ID,
        'permalink' => $permalink,
    );
}

/**
 * Handle a delete webhook call
 *
 * @param $payload
 * @return array
 */
function handleDelete($payload) {
    $story = $payload['data'];
    $post_ID = $story['external_id'];
    wp_delete_post($post_ID);

    do_action('storychief_after_delete_action', $story);

    return array(
        'id'        => $story['external_id'],
        'permalink' => null,
    );
}

/**
 * Handle a connection test webhook call
 * @param $payload
 * @return array
 */
function handleConnectionCheck($payload) {
    $story = $payload['data'];

    do_action('storychief_after_test_action', $story);

    return array();
}


/**
 * Handle calls to missing methods on the controller.
 *
 * @return mixed
 */
function missingMethod() {
    return;
}