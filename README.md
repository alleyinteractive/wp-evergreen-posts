# WP Evergreen Posts

Contributors: alleyinteractive

Tags: alleyinteractive, wp-evergreen-posts

Stable tag: 0.0.0

Requires at least: 6.3

Tested up to: 6.7

Requires PHP: 8.2

License: GPL v2 or later

[![Testing Suite](https://github.com/alleyinteractive/wp-evergreen-posts/actions/workflows/all-pr-tests.yml/badge.svg?branch=develop)](https://github.com/alleyinteractive/wp-evergreen-posts/actions/workflows/all-pr-tests.yml)

WordPress plugin for removing the date from post URLs.

## Installation

You can install the package via Composer:

```bash
composer require alleyinteractive/wp-evergreen-posts
```

## Usage

Activate the plugin in WordPress and use it like so:

```php
$plugin = Create_WordPress_Plugin\WP_Evergreen_Posts\WP_Evergreen_Posts();
$plugin->perform_magic();
```


## Releasing the Plugin

The plugin uses
[action-release](https://github.com/alleyinteractive/action-release) via a
[built release workflow](./.github/workflows/built-release.yml) to compile and
tag releases. Whenever a new version is detected in the root plugin's headers in
the `wp-evergreen-posts.php` file or in the `composer.json` file, the workflow will
automatically build the plugin and tag it with a new version. The built tag will
contain all the required front-end assets the plugin may require. This works
well for publishing to WordPress.org or for submodule-ing.

When you are ready to release a new version of the plugin, you can run
`npm run release`/`composer release` to start the process of setting up a new
release. If you want to do this manually you can follow these steps:

1. Change the `Version` in the `wp-evergreen-posts.php` file to a new higher-level version.

	```diff
	- * Version: 0.0.0
	+ * Version: 0.0.1
	```

	**✨ `npm run release` will do this for you automatically.**

2. Commit your changes and push to the repository.
3. Check the actions tab in the repository to see the progress of the release.
   The action will automatically create a new tag and release for the plugin.
   You are done!

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

This project is actively maintained by [Alley
Interactive](https://github.com/alleyinteractive). Like what you see? [Come work
with us](https://alley.co/careers/).

- [Alley](https://github.com/Alley)
- [All Contributors](../../contributors)

## License

The GNU General Public License (GPL) license. Please see [License File](LICENSE) for more information.