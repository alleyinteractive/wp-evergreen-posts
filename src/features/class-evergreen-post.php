<?php
/**
 * Feature implementation of Evergreen Posts.
 *
 * @package wp-evergreen-posts
 */

namespace Alley\WP\WP_Evergreen_Posts\Features;

use Alley\WP\Types\Feature;
use Alley\WP\WP_Evergreen_Posts\Traits\Singleton;

/**
 * Evergreen_Post feature class.
 */
final class Evergreen_Post implements Feature {
	use Singleton;

	/**
	 * Set up.
	 *
	 * @param array<string> $post_types The post types to enable.
	 * @param string        $meta_key The evergreen post meta key.
	 * @param string        $path The redirect path.
	 */
	public function __construct(
		private readonly array $post_types = [],
		private readonly string $meta_key = '',
		private readonly string $path = '',
	) {}

	/**
	 * Boot the feature.
	 */
	public function boot(): void {
		add_action( 'init', $this->register_post_meta( ... ) );
		add_action( 'init', $this->rewrite_rule( ... ) );
		add_filter( 'post_link', $this->modify_evergreen_url( ... ), 10, 2 );
		add_filter( 'pre_post_link', $this->modify_evergreen_url( ... ), 10, 2 );
		add_action( 'template_redirect', $this->redirect_to_canonical_url( ... ) );
	}

	/**
	 * Get the post types.
	 * 
	 * @return array<string> The post types.
	 */
	public function get_post_types(): array {
		if ( $this->post_types === [] ) {
			return [];
		}

		return $this->post_types;
	}

	/**
	 * Determine whether the post is an enabled post type and has
	 * the evergreen post toggle enabled.
	 *
	 * @param int $post_id Post ID.
	 * @return bool True if the post is an evergreen post, false otherwise.
	 */
	public function is_evergreen( int $post_id ): bool {
		if ( empty( $this->meta_key ) || empty( $post_id ) ) {
			return false;
		}

		$post_type = get_post_type( $post_id );

		if ( empty( $post_type ) ) {
			return false;
		}

		$post_meta = get_post_meta( $post_id, $this->meta_key, true );

		return in_array( $post_type, $this->post_types, true ) && ! empty( $post_meta );
	}

	/**
	 * Register the post meta for evergreen posts.
	 */
	public function register_post_meta(): void {
		foreach ( $this->post_types as $post_type ) {
			register_post_meta(
				$post_type,
				$this->meta_key,
				[
					'show_in_rest'  => true,
					'single'        => true,
					'type'          => 'boolean',
					'auth_callback' => fn() => current_user_can( 'edit_posts' ),
				] 
			);
		}
	}

	/**
	 * Add rewrite rule for evergreen posts.
	 */
	public function rewrite_rule(): void {
		if ( empty( $this->path ) ) {
			return;
		}

		add_rewrite_rule(
			'^' . $this->path . '/([^/]+)/?$',
			'index.php?name=$matches[1]',
			'top'
		);
	}

	/**
	 * Modify the url for evergreen posts.
	 *
	 * @param string   $url The post url.
	 * @param \WP_Post $post The post object.
	 * @return string The modified url.
	 */
	public function modify_evergreen_url( $url, $post ): string {
		if ( ! empty( $url )
			&& in_array( $post->post_type, $this->post_types, true )
			&& 'publish' === $post->post_status
			&& $this->is_evergreen( $post->ID )
			&& ! empty( $this->path )
		) {
			return trailingslashit( home_url( $this->path . '/' . $post->post_name ) );
		}

		return $url;
	}

	/**
	 * Redirect to the canonical URL if the current URL does not match.
	 */
	public function redirect_to_canonical_url(): void {
		if (
			$this->post_types === []
			|| ! is_array( $this->post_types )
			|| ! is_singular( $this->post_types )
			|| is_preview()
		) {
			return;
		}

		/**
		 * The global WordPress object.
		 *
		 * @var \WP $wp
		 */
		global $wp;

		// Get the current request URL.
		$request_url = home_url( trailingslashit( $wp->request ) );

		// Get the current post ID.
		$post_id = get_the_ID();

		if ( empty( $post_id ) ) {
			return;
		}

		// Get the current post URL.
		$url = get_the_permalink( $post_id );

		if ( empty( $url ) ) {
			return;
		}

		// If the URLs match, no redirect is needed.
		if ( $url === $request_url ) {
			return;
		}

		// Determine the redirect direction.
		$is_evergreen_post    = $this->is_evergreen( $post_id );
		$is_evergreen_request = str_starts_with( (string) $wp->request, $this->path );

		/**
		 * The post is evergreen, and the request is for a date-based URL.
		 * Redirect the user to the evergreen URL.
		 */
		if ( $is_evergreen_post && empty( $is_evergreen_request ) ) {
			wp_safe_redirect( $url, 301, 'Evergreen Post (WordPress)' );
			exit;
		}

		/**
		 * The post is not evergreen, and the request is for an evergreen URL.
		 * Redirect the user to the date-based URL.
		 */
		if ( empty( $is_evergreen_post ) && $is_evergreen_request ) {
			wp_safe_redirect( $url, 301, 'Non-Evergreen Post (WordPress)' );
			exit;
		}
	}
}
