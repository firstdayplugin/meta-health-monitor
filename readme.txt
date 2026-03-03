=== Meta Health Monitor ===
Contributors: edikurniawan
Tags: database, postmeta, performance, optimization, admin tools
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Analyze WordPress postmeta usage, detect heavy metadata, and monitor database health safely.

== Description ==

WP Meta Health Monitor helps administrators understand how postmeta is distributed across their site.

It provides:

- Total postmeta row count
- Meta usage by post type
- Top heavy posts
- Top meta keys
- Meta Health Score
- Cached scan system for large databases
- Manual "Scan Now" refresh

Designed to work safely on large WordPress installations.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the WordPress admin.
3. Go to **Meta Health** in the admin menu.

== Frequently Asked Questions ==

= Will this slow down my site? =

No. Scan results are cached using WordPress transients to prevent heavy queries on every page load.

= Does this modify my database? =

No. The plugin is read-only and does not change or delete any data.

= Does it work with WooCommerce? =

Yes. It detects commerce-related metadata and includes it in analysis.

== Screenshots ==

1. Dashboard overview with Meta Health Score
2. Meta usage by post type
3. Top heavy posts and top meta keys

== Changelog ==

= 0.1.0 =
* Initial release
* Meta Health Score
* Cached scanning
* Admin dashboard

== Upgrade Notice ==

= 0.1.0 =
Initial release.