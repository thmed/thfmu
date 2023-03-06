=== Randomize ===
Contributors: sirjavik, se-schwarz, goinput
Donate link: https://paypal.me/benny003
Tags: widget, plugin, sidebar, random, text, quotes, rotate, rotation, shuffle, images, pictures
Requires at least: 4.6
Tested up to: 5.7
Requires PHP: 5.6
Stable tag: 1.4.3
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Store and display randomized/rotated content by categories in sidebar widgets, pages, posts or templates.

== Description ==

Randomize simply displays randomized text. You're able to deposit text passages, quotes and HTML code in the administration backend by categories. You can use the widget, a shortcode or template tag to show up randomized content on your site.

= Ready for translation =

Since version 1.4 was released Randomize is ready for translation. Feel free to add or support your language on [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/randomize)!

= Development Notice =

The original author has discontinued the development, so that I decided to continue the free distribution under the new name "Randomize". It's based on "Random Text" by pantsonhead.

== Installation ==

1. Upload the zip to your WordPress installation and activate it.
2. Switch to "Appearance" -> "Widgets" for using the widget OR embed a shortcode/template tag.
3. Manage your entries in "Settings" -> "Randomize".

Note: During installation, Randomize creates a new table to your WP database to store the entries by category. After setup you should see two sample entries.
By uninstalling the plugin the DB tables will be removed also.

== Screenshots ==

1. Sample output on frontend
2. Single import with HTML
3. Bulk import with multiple lines of content
4. Randomize overview
5. Widget configuration

== Frequently Asked Questions ==

= Can I use shortcodes? =

Yes, you can use...
    [randomize]
for all strings, or
    [randomize category='EXAMPLE_CATEGORY']
for a specific category, or even
    [randomize category='EXAMPLE_CATEGORY' random='1']
for a specific category also, but with randomization instead of rotating.

= What about template tags? = 

You can use something like this, where 'EXAMPLE_CATEGORY' is the group you wish to select items from:

    <?php randomize('EXAMPLE_CATEGORY'); ?>

= Can I embed images? = 

You are able to embed images by using the general HTML <img> tag. Maybe you would like to create an own category for images in Randomize.

== Changelog ==

= v1.4.2 2018-08-01 =

* Deleted local language files (no longer necessary)
* added a small donation link in admin area

= v1.4 2018-04-27 =

* Internationalized
* added german language file
* requires WordPress 4.6+ now
* requires PHP 5.6+ now 

= v1.3.1 2018-04-26 =

* tested with WP 4.9.5
* Updated licence to GPLv3
* Updated assets
* Updated FAQ for PHP template tags
* Updated required PHP version 

= v1.3 2017-03-05 =

* Hotfix

= v1.1 2016-10-20 =

* Replaced function "WP_Widget()" with "parent::__construct()", which is deprecated since version 4.3.0 of WordPress

= v1.0 2014-06-03 =

* Initial release
