<?php
/**
 * WP Evergreen Posts Tests: Bootstrap
 *
 * @package wp-evergreen-posts
 */

/**
 * Visit {@see https://mantle.alley.com/testing/test-framework.html} to learn more.
 */
\Mantle\Testing\manager()
	// Rsync the plugin to plugins/wp-evergreen-posts when testing.
	->maybe_rsync_plugin()
	// Load the main file of the plugin.
	->loaded( fn () => require_once __DIR__ . '/../wp-evergreen-posts.php' )
	->install();
