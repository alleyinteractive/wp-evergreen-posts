<?php
/**
 * WP Evergreen Posts Tests: Evergreen Post
 *
 * @package wp-evergreen-posts
 */

namespace Alley\WP\WP_Evergreen_Posts\Tests\Feature;

use Alley\WP\WP_Evergreen_Posts\Tests\TestCase;
use Alley\WP\WP_Evergreen_Posts\Features\Evergreen_Post;

/**
 * A test suite for the Evergreen Post feature.
 */
class EvergreenPostTest extends TestCase {
	/**
	 * The feature instance.
	 *
	 * @var Evergreen_Post
	 */
	private Evergreen_Post $feature;

	/**
	 * The post types to be used in tests.
	 *
	 * @var array<string>
	 */
	private array $post_types = [ 'post', 'custom_type' ];

	/**
	 * The meta key and path to be used in tests.
	 *
	 * @var string
	 */
	private string $meta_key = 'evergreen_post';

	/**
	 * The path to be used in tests.
	 *
	 * @var string
	 */
	private string $path = 'feature';

	/**
	 * The post object.
	 * 
	 * @var \WP_Post
	 */
	private \WP_Post $post;

	/**
	 * The evergreen post URL to be used in tests.
	 * 
	 * @var string
	 */
	private string $post_url_evergreen = '';

	/**
	 * Set up the feature instance for tests.
	 */
	protected function setUp(): void {
		parent::setUp();
		$this->feature = new Evergreen_Post(
			$this->post_types,
			$this->meta_key,
			$this->path,
		);

		// Create a post with a valid post type.
		$this->post = $this->factory()->post->create_and_get(
			[
				'post_title'  => 'Test Post',
				'post_status' => 'publish',
				'post_type'   => 'post',
				'post_name'   => 'test-post',
			]
		);

		// Set the expected evergreen post URL.
		$this->post_url_evergreen = trailingslashit( home_url( $this->path . '/test-post' ) );
	}

	/**
	 * Test that get_post_types returns the configured post types.
	 */
	public function test_get_post_types_returns_configured_types() {
		// Get the post types.
		$post_types = $this->feature->get_post_types();

		$this->assertSame( $this->post_types, $post_types );
	}

	/**
	 * Test that get_post_types returns an empty array when no post types are set.
	 */
	public function test_get_post_types_returns_empty_array_when_none_set() {
		// Set up the feature with an empty post types array.
		$feature = new Evergreen_Post(
			[],
			$this->meta_key,
			$this->path,
		);

		// Get the post types.
		$post_types = $feature->get_post_types();

		$this->assertSame( [], $post_types );
	}

	/**
	 * Test that the is_evergreen method returns false for empty meta key.
	 */
	public function test_is_evergreen_returns_false_for_empty_meta_key() {
		// Set up the feature with an empty meta key.
		$feature = new Evergreen_Post(
			$this->post_types,
			'',
			$this->path,
		);

		// Call is_evergreen with a valid post ID.
		$is_evergreen = $feature->is_evergreen( $this->post->ID );

		$this->assertFalse( $is_evergreen );
	}

	/**
	 * Test that the is_evergreen method returns false for empty post ID.
	 */
	public function test_is_evergreen_returns_false_for_empty_post_id() {
		// Call is_evergreen with an invalid post ID.
		$is_evergreen = $this->feature->is_evergreen( 0 );

		$this->assertFalse( $is_evergreen );
	}

	/**
	 * Test that the is_evergreen method returns false for an invalid post type.
	 */
	public function test_is_evergreen_returns_false_for_invalid_post_type() {
		// Create a post with an invalid post type.
		$post_id = $this->factory()->post->create(
			[
				'post_title'  => 'Test Post',
				'post_status' => 'publish',
				'post_type'   => 'invalid_post_type',
				'post_name'   => 'test-post',
			]
		);

		// Call is_evergreen with the post ID.
		$is_evergreen = $this->feature->is_evergreen( $post_id );

		$this->assertFalse( $is_evergreen );
	}

	/**
	 * Test that the is_evergreen method returns false for draft post.
	 */
	public function test_is_evergreen_returns_false_for_draft_post() {
		// Create a draft post.
		$post_id = $this->factory()->post->create(
			[
				'post_title'  => 'Draft Post',
				'post_status' => 'draft',
				'post_type'   => 'post',
				'post_name'   => 'draft-post',
			]
		);

		// Call is_evergreen with the post ID.
		$is_evergreen = $this->feature->is_evergreen( $post_id );

		$this->assertFalse( $is_evergreen );
	}

	/**
	 * Test that the is_evergreen method returns false for false meta key.
	 */
	public function test_is_evergreen_returns_false_for_false_meta_key() {
		// Set the meta key to false.
		add_post_meta( $this->post->ID, $this->meta_key, false );

		$is_evergreen = $this->feature->is_evergreen( $this->post->ID );

		$this->assertFalse( $is_evergreen );
	}

	/**
	 * Test that the is_evergreen method returns false for missing meta key.
	 */
	public function test_is_evergreen_returns_false_for_missing_meta_key() {
		// Delete the post meta.
		delete_post_meta( $this->post->ID, $this->meta_key );

		$is_evergreen = $this->feature->is_evergreen( $this->post->ID );

		$this->assertFalse( $is_evergreen );
	}

	/**
	 * Test that the is_evergreen method returns true when the post type is valid
	 * and the meta key indicates it's an evergreen post.
	 */
	public function test_is_evergreen_returns_true_when_post_type_and_meta_match() {
		// Set the post meta key to true.
		add_post_meta( $this->post->ID, $this->meta_key, true );
	
		// Call is_evergreen with the post ID.
		$is_evergreen = $this->feature->is_evergreen( $this->post->ID );

		$this->assertTrue( $is_evergreen );
	}

	/**
	 * Test that get_permalink returns the modified URL when the post
	 * is an evergreen post.
	 */
	public function test_get_permalink_for_evergreen_post() {
		// Set the meta key to true.
		add_post_meta( $this->post->ID, $this->meta_key, true );

		// Get the post URL.
		$post_url = get_permalink( $this->post->ID );

		$this->assertSame( $this->post_url_evergreen, $post_url );
	}

	/**
	 * Test that get_permalink returns the original URL when the post
	 * is not an evergreen post.
	 */
	public function test_get_permalink_for_non_evergreen_post() {
		// Set the meta key to false.
		add_post_meta( $this->post->ID, $this->meta_key, false );

		// Get the post URL.
		$post_url = get_permalink( $this->post->ID );

		$this->assertNotSame( $this->post_url_evergreen, $post_url );
	}
}
