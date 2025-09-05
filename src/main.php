<?php
/**
 * The main plugin function
 *
 * @package wp-evergreen-posts
 */

namespace Alley\WP\WP_Evergreen_Posts;

use Alley\WP\Features\Group;
use Alley\WP\WP_Evergreen_Posts\Features\Evergreen_Post;

/**
 * Instantiate the plugin.
 */
function main(): void {
	$plugin = new Group(
		initialize_evergreen_post_feature(),
	);

	$plugin->boot();
}

/**
 * Initialize the Evergreen_Post feature.
 *
 * @return Evergreen_Post The initialized feature.
 */
function initialize_evergreen_post_feature(): Evergreen_Post {
	/**
	 * Filters the post types to enable evergreen post functionality for.
	 * 
	 * @param array<string> $post_types The post types to enable. Default is ['post'].
	 */
	$post_types = apply_filters( 'wp_evergreen_posts_post_types', [ 'post' ] );
	if ( ! is_array( $post_types ) ) {
		$post_types = [ 'post' ];
	}

	/**
	 * Filters the post meta key to use for evergreen posts.
	 * 
	 * @param string $meta_key The evergreen post meta key. Default is 'evergreen_post'.
	 */
	$meta_key = apply_filters( 'wp_evergreen_posts_meta_key', 'evergreen_post' );
	if ( ! is_string( $meta_key ) ) {
		$meta_key = 'evergreen_post';
	}

	/**
	 * Filters the redirect path for evergreen posts.
	 * 
	 * @param string $path The redirect path. Default is 'feature'.
	 */
	$path = apply_filters( 'wp_evergreen_posts_path', 'feature' );
	if ( ! is_string( $path ) ) {
		$path = 'feature';
	}

	return Evergreen_Post::instance( $post_types, $meta_key, $path );
}
