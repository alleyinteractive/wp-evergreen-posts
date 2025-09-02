<?php
/**
 * The main plugin function
 *
 * @package wp-evergreen-posts
 */

namespace Alley\WP\WP_Evergreen_Posts;

use Alley\WP\Features\Group;

/**
 * Instantiate the plugin.
 */
function main(): void {
	// Add features here.
	$plugin = new Group();

	$plugin->boot();
}
