<?php
/**
 * Rewrite the permalink for post types using the Custom Link option
 *
 * @param string $url  The original permalink.
 * @param object $post The post object.
 *
 * @since 1.0.0
 */
function prefix_custom_link_option( $url, $post ) {
    // Create an array of post types to skip.
    $skip_post_types   = array(
        'attachment',
    );

    // page_link gives the ID rather than the $post object.
    if ( 'integer' === gettype( $post ) ) {
        $post_id = $post;
    } else {
        $post_id = $post->ID;
    }

    // Check if the current post type should be skipped.
    if ( in_array( get_post_type( $post_id ), $skip_post_types, true ) ) {
        return $url;
    }

    // Get the custom_link if one exists.
    $custom_link = 'http://lookdress/testing';

    if ( $custom_link ) {
        $url = $custom_link;
    }

    return $url;
}

/**
 * Add filters for post_link, page_link, and post_type_link to update Custom Link
 */
foreach ( [ 'post', 'page', 'post_type' ] as $post_type ) {
    add_filter( $post_type . '_link', 'prefix_custom_link_option', 10, 2 );
}
