<?php
/**
 * Defines helper functions for the plugin.
 *
 * @package wp-evergreen-posts
 */

namespace Alley\WP\WP_Evergreen_Posts;

use Alley\WP\WP_Evergreen_Posts\Features\Evergreen_Post;

/**
 * Helper function to determine whether the post is an evergreen post.
 *
 * @param int $post_id Post ID.
 * @return bool True if the post is an evergreen post, false otherwise.
 */
function is_post_evergreen( int $post_id ): bool {
	if ( empty( $post_id ) ) {
		return false;
	}

	return Evergreen_Post::instance()->is_evergreen( $post_id );
}
