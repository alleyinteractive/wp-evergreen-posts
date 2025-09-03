<?php
/**
 * Trait file for Singletons.
 *
 * @package wp-evergreen-posts
 */

namespace Alley\WP\WP_Evergreen_Posts\Traits;

/**
 * Make a class into a singleton.
 */
trait Singleton {
	/**
	 * Existing instance.
	 *
	 * @var static|null
	 */
	protected static $instance;

	/**
	 * Get class instance.
	 *
	 * @param mixed ...$args Arguments to pass to the constructor on first instantiation.
	 */
	public static function instance( ...$args ): static {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static( ...$args ); // @phpstan-ignore-line
			static::$instance->setup();
		}
		return static::$instance;
	}

	/**
	 * Setup the singleton.
	 */
	public function setup(): void {
		// Silence.
	}
}
