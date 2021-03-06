=== Plugin Name ===
Contributors: Elementous, dominykasgel, darius_fx
Donate link: https://www.elementous.com
Tags: random, text, quote, joke, featured, image, video, widget, shortcode, slider, slideshow, elementous
Requires at least: 3.0.1
Tested up to: 4.9.2
Stable tag: 1.2.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin allows you to add texts, images, videos and display them in a random order or slideshow.

== Description ==

Content Randomizer plugin allows you to create sets of short texts, images or even video and to show them on any widgetized area. You can make sets of quotes, phrases, jokes and other short texts separate from the other website content. Content Randomizer plugin uses its own custom type posts for the full control over the website content. Same custom type posts are used to add images or videos (embedded).

The plugin is user-friendly and easy to use. Just install the plugin and activate it. Now you’ll be able to create categories for random content, each category will represent an individual set of content. Create random content posts and assign them to the preferred category. Now when you have at least one content set you can go to the Widget Manager (Appearance → Widgets) and add one of the two available Content Randomizer plugin widgets.

The main Content Randomizer widget reacts only when you browse from one page to another on your website, it will change content every time on load or refresh action. Second widget available with Content Randomizer plugin shows random content as slides, so there is no need to browse to another page or refresh the current page to see all content that was assigned to the active content set. The active content set is determined by random content category selection in widget settings (just a simple dropdown).

There are shortcodes available for more advanced users. You can use these shortcodes to render random content at any selected location of your website. We hope you will enjoy this plugin.

[Content Randomizer Documentation](https://www.elementous.com/documentation/#color-filters-for-woocommerce)

We also have a public [GIT repository](https://github.com/elementous/content-randomizer) for this plugin and you're welcome to contribute your patch.

= Features =

* Display sets of random texts, images or videos
* Display sets of random content like a slideshow
* Set the date range to control when your random content will be displayed
* Categories to define random sets of content
* Widgets and shortcodes to display random content
* Ability to change randomizer permalinks

== Installation ==

1. Upload `content-randomizer` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

For FAQ and more information, please go to [Content Randomizer Documentation](https://www.elementous.com/documentation/#content-randomizer)

== Screenshots ==

1. Randomizer posts.
2. Adding a new category.
3. Adding a new randomizer post.
4. Randomizer widgets.
5. Final result in front-end.

== Changelog ==

= 1.2.3 =
* Tweak: Flush rewrite rules after plugin activation
* Tweak: Date field input CSS

= 1.2.2 =
* Fixed: WP_Query is missing posts_per_page argument to randomize all posts (Reported by Matt Jones)

= 1.2.1 =
* Feature: Added ability to change randomizer custom post type and randomizer taxonomy permalinks
* Tweak: Added language (.po) file

= 1.2 =
* Feature: Added categories for randomizer custom posts
* Feature: Added slideshow (Owl carousel) widget and shortcode (As requested by Lance Jacobs)
* Feature: Added video to the list of types
* Feature: Now date range is not required when adding a randomizer post
* Improved: Overall logic and structure
* Fixed: Closing randomizer widget wrapper div (Reported by Lance Jacobs)

= 1.1 =
* WPML Support

= 1.0 =
* Initial release.
