=== Inline Ajax Comments Reloaded ===
Contributors: studiograsshopper
Donate link: http://www.studiograsshopper.ch/
Tags: comments, ajax, inline
Requires at least: 3.6
Tested up to: 3.6
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates and displays Facebook-style single line comment form and comments, using Ajax. Based on ZaneMatthew's Inline Ajax Comments plugin, tweaked for studiograsshopper's needs.


== Description ==

This plugin replaces your theme's comments form and template with a Facebook-style, single line comment entry, powered by AJAX. 

= Features =
* Single line textarea for comment entry
* Auto expanding textarea (not working yet)
* AJAX submitted comments
* AJAX loaded comments

This is a highly modified version of ZaneMatthew's [Inline Ajax Comments plugin](http://zanematthew.com/blog/plugins/inline-comments/).
Nice work, Sir!


== Installation ==

1. Upload the entire `inline-ajax-comments-reloaded` folder to the `/wp-content/plugins/` directory
2. DO NOT change the name of the `inline-ajax-comments-reloaded` folder
3. Activate the plugin through the 'Plugins' menu in the WordPress Dashboard


== Frequently Asked Questions ==

= Doesn't this prevent search engines from seeing comments? =
Yes, though as with the original version of this code from which this plugin is forked, [Google Ajax Crawling](https://developers.google.com/webmasters/ajax-crawling/docs/getting-started) will be added in a later version.

= Does this work with Custom Post Types? =
Yes

= Does this work on Pages? =
No

= Does this support paging? =
No


== Screenshots ==

To be done


== Upgrade Notice ==

To be done


== Misc ==
Theoretically, the plugin's inline documentation standards comply with [WordPress Coding Standards](http://make.wordpress.org/core/handbook/inline-documentation-standards/php-documentation-standards/#4-hooks-actions-and-filters). However, this is a work in progress, so no guarantees!


== Changelog ==

= 0.8.0 =
* Released 09 October 2013
* Reorganised js scripts
* Reorganised nonce handling and ajax action functions
* Lots of minor code tweaks for standrads, inline docs, etc

= 0.7.0 =
* Initial release 25 September 2013
* This is a dev version and probably does not work properly. Yet.
