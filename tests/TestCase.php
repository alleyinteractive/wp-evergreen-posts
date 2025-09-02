<?php
/**
 * WP Evergreen Posts Tests: Base Test Class
 *
 * @package wp-evergreen-posts
 */

namespace Alley\WP\WP_Evergreen_Posts\Tests;

use Mantle\Testing\Concerns\Prevent_Remote_Requests;
use Mantle\Testkit\Test_Case as TestkitTest_Case;

/**
 * WP Evergreen Posts Base Test Case
 */
abstract class TestCase extends TestkitTest_Case {
	use Prevent_Remote_Requests;
}
