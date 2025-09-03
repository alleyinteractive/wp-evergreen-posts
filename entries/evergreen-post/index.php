<?php
/**
 * The evergreen-post slotfill script registration and enqueue.
 *
 * This file will be copied to the assets output directory
 * with Webpack using wp-scripts build. The build command must
 * be run before this file will be available.
 *
 * This file must be included from the build output directory in a project.
 * and will be loaded from there.
 *
 * @package wp-evergreen-posts
 */

/**
 * Registers all evergreen-post slotfill assets so that they can be enqueued in
 * the corresponding context.
 */
function wp_evergreen_posts_register_evergreen_post_scripts(): void {
	// Automatically load dependencies and version.
	$asset_file = include __DIR__ . '/index.asset.php';

	if (
		empty( $asset_file )
		|| ! is_array( $asset_file )
		|| empty( $asset_file['dependencies'] )
		|| ! is_array( $asset_file['dependencies'] )
		|| empty( $asset_file['version'] )
		|| ! is_string( $asset_file['version'] )
	) {
		return;
	}

	/**
	 * The assets dependencies array.
	 *
	 * @var array<string>
	 */
	$dependencies = $asset_file['dependencies'];
	$version      = $asset_file['version'];

	// Register the evergreen-post script.
	wp_register_script(
		'wp-evergreen-posts-evergreen-post-js',
		plugins_url( 'index.js', __FILE__ ),
		$dependencies,
		$version,
		true
	);
	wp_set_script_translations( 'wp-evergreen-posts-evergreen-post-js', 'wp-evergreen-posts' );
}
add_action( 'init', 'wp_evergreen_posts_register_evergreen_post_scripts' );

/**
 * Enqueue block editor assets for the evergreen-post slotfill.
 *
 * This function is called by the enqueue_block_editor_assets hook. Use it to
 * enqueue assets that are loaded in the block editor.
 */
function wp_evergreen_posts_enqueue_evergreen_post_assets(): void {
	// Only enqueue on the post edit screen.
	if ( ! function_exists( 'get_current_screen' ) ) {
		return;
	}

	$screen = get_current_screen();

	if ( empty( $screen ) ) {
		return;
	}

	$evergreen_post_types = \Alley\WP\WP_Evergreen_Posts\Features\Evergreen_URL::instance()->get_post_types();

	if ( ! empty( $screen->post_type ) && in_array( $screen->post_type, $evergreen_post_types, true ) ) {
		wp_enqueue_script( 'wp-evergreen-posts-evergreen-post-js' );
	}
}
add_action( 'enqueue_block_editor_assets', 'wp_evergreen_posts_enqueue_evergreen_post_assets' );
