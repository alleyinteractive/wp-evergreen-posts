# WP Evergreen Posts

Contributors: alleyinteractive

Tags: alleyinteractive, wp-evergreen-posts

Stable tag: 1.0.0

Requires at least: 6.3

Tested up to: 6.7

Requires PHP: 8.2

License: GPL v2 or later

[![Testing Suite](https://github.com/alleyinteractive/wp-evergreen-posts/actions/workflows/all-pr-tests.yml/badge.svg?branch=develop)](https://github.com/alleyinteractive/wp-evergreen-posts/actions/workflows/all-pr-tests.yml)

This WordPress plugin provides editors with a post admin toggle that allows them to remove dates from posts, creating "evergreen" posts.

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

### Filters and default values
By default, the feature is only enabled on `post` post types, the value of the toggle is stored in the `evergreen_url` meta key, and when toggled on, the post date is replaced with a hard-coded string `feature`, e.g. `https://example.com/2025/09/01/example-post` -> `https://example.com/feature/example-post`

These values can all be filtered:
```
/**
 * Filters the post types to enable evergreen URLs for.
 * 
 * @param array<string> $post_types The post types to enable. Default is ['post'].
 */
$post_types = apply_filters( 'wp_evergreen_posts_post_types', [ 'post' ] );

/**
 * Filters the post meta key to use for evergreen URLs.
 * 
 * @param string $meta_key The evergreen url post meta key. Default is 'evergreen_url'.
 */
$meta_key = apply_filters( 'wp_evergreen_posts_meta_key', 'evergreen_url' );

/**
 * Filters the redirect path for evergreen URLs.
 * 
 * @param string $path The redirect path. Default is 'feature'.
 */
$path = apply_filters( 'wp_evergreen_posts_path', 'feature' );
```

## Development

To setup a WordPress installation and run the plugin in a local environment, you
can use `wp-env` via the `composer dev` command:

```sh
npm install
composer dev
```

The command will start a local WordPress environment with the plugin activated
while also running the front-end assets build process. You can also run `npm run
start` to start the front-end assets build process separately. The front-end
assets will be compiled into the `build` directory and will be enqueued
automatically by the plugin.

## Testing

Run `npm run test` to run Jest tests against JavaScript files. Run
`npm run test:watch` to keep the test runner open and watching for changes.

Run `npm run lint` to run ESLint against all JavaScript files. Linting will also
happen when running development or production builds.

Run `composer test` to run tests against PHPUnit and the PHP code in the plugin.
Unit testing code is written in PSR-4 format and can be found in the `tests`
directory.

### The `entries` directory and entry points

All directories created in the `entries` directory can serve as entry points and will be compiled with [@wordpress/scripts](https://github.com/WordPress/gutenberg/blob/trunk/packages/scripts/README.md#scripts) into the `build` directory with an accompanied `index.asset.php` asset map.

#### Scaffolding an entry point

To generate a new entry point, run the following command:

```sh
npm run create-entry
```

To generate a new slotfill, run the following command:

```sh
npm run create-slotfill
```

The command will prompt the user through several options for creating an entry or slotfill. The entries are scaffolded with the `@alleyinteractive/create-entry` script. Run the help command to see all the options:

```sh
npx @alleyinteractive/create-entry --help
```
[Visit the package README](https://www.npmjs.com/package/@alleyinteractive/create-entry) for more information.

#### Enqueuing Entry Points

You can also include an `index.php` file in the entry point directory for enqueueing or registering a script. This file will then be moved to the build directory and will be auto-loaded with the `load_scripts()` function in the `functions.php` file. Alternatively, if a script is to be enqueued elsewhere there are helper functions in the `src/assets.php` file for getting the assets.

### Scaffold a dynamic block with `create-block`

Use the `create-block` command to create custom blocks with [@alleyinteractive/create-block](https://github.com/alleyinteractive/alley-scripts/tree/main/packages/create-block) script and follow the prompts to generate all the block assets in the `blocks/` directory.
Block registration, script creation, etc will be scaffolded from the `create-block` script. Run `npm run build` to compile and build the custom block. Blocks are enqueued using the `load_scripts()` function in `src/assets.php`.

### Updating WP Dependencies

Update the [WordPress dependency packages](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/#packages-update) used in the project to their latest version.

To update `@wordpress` dependencies to their latest version use the packages-update command:

```sh
npx wp-scripts packages-update
```

This script provides the following custom options:

-   `--dist-tag` – allows specifying a custom dist-tag when updating npm packages. Defaults to `latest`. This is especially useful when using [`@wordpress/dependency-extraction-webpack-plugin`](https://www.npmjs.com/package/@wordpress/dependency-extraction-webpack-plugin). It lets installing the npm dependencies at versions used by the given WordPress major version for local testing, etc. Example:

```sh
npx wp-scripts packages-update --dist-tag=wp-WPVERSION`
```

Where `WPVERSION` is the version of WordPress you are targeting. The version
must include both the major and minor version (e.g., `6.7`). For example:

```sh
npx wp-scripts packages-update --dist-tag=wp-6.7`
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