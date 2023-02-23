=== O/H - Opening Hours ===
Contributors: kirnbauer, janizde
Tags: opening hours,business hours,hours,table,overview,date,time,widget,shortcode,status,currently open,bar,restaurant
Tested up to: 6.1.1
Stable tag: 1.0.0
Requires at least: 5.9.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The WordPress plugin "Opening Hours" offers extensive customization options for displaying your venue's operating hours through the use of Shortcodes and Widgets.

== Description ==

The Opening Hours plugin for WordPress offers several advanced features. Firstly, it supports multiple sets of opening hours, which you can use independently for different parts of your establishment (such as a restaurant and a bar). Secondly, it supports holidays, allowing you to set special opening hours for these occasions. Additionally, the plugin can handle irregular openings, such as different hours during the Christmas period.

Moreover, the plugin allows you to create child sets that can overwrite your regular opening hours during specific periods, such as seasonal hours or an extra day every second week. Finally, the plugin provides four highly customizable widgets and shortcodes that can display contextual information, such as a message indicating when you will next be open if currently closed.

* Supports multiple Sets of Opening Hours (e.g. one for your restaurant and one for your bar) that you can use independently.
* Supports Holidays
* Supports Irregular Openings (e.g. different opening hours during Christmas)
* Supports child sets that overwrite your regular opening hours in a specific time period (e.g. seasonal opening hours or an extra day in every second week)
* Four highly customizable Widgets and Shortcodes also displaying contextual information (e.g. "We're currently closed but will be open again on Monday at 8am")

= Widgets =

* Overview Widget: Lists up all Opening Hours with contextual information in a table or list
* Is Open Widget: Indicates whether the selected venue is currently open or closed and optionally shows when it will be open again
* Holidays Widget: Lists up all Holidays in a table or list
* Irregular Openings Widget: Lists up all Irregular Openings in a table or list
* Schema.org Widgets: Inserts structured [JSON-LD](https://en.wikipedia.org/wiki/JSON-LD) into a WordPress page or post

[More on Widgets](https://github.com/janizde/WP-Opening-Hours#widgets)

= Shortcodes =
All of the widgets listed up above are also available as shortcodes.
With the [Opening Hours Shortcode Builder](http://bit.ly/2mmneSk) you can assemble a Shortcode by filling in a form. This is particularly useful when you are not comfortable with the shortcode syntax.

* [More on Shortcodes](https://github.com/janizde/WP-Opening-Hours#shortcodes)
* [Shortcode Builder](http://bit.ly/2mmneSk)
* [Shortcode Builder on GitHub](http://bit.ly/35rsQiD)

= Further Documentation =
**Further documentation is available on [GitHub](https://github.com/janizde/WP-Opening-Hours).**

* [Features](https://github.com/janizde/WP-Opening-Hours#features)
* [Installation](https://github.com/janizde/WP-Opening-Hours#installation)
	* [WordPress Plugin Installer](https://github.com/janizde/WP-Opening-Hours#wordpress-plugin-installer)
	* [Manual Installation](https://github.com/janizde/WP-Opening-Hours#manual-installation)
	* [Composer](https://github.com/janizde/WP-Opening-Hours#composer)
	* [Clone GitHub Repository](https://github.com/janizde/WP-Opening-Hours#clone-repository)
* [Getting Started](https://github.com/janizde/WP-Opening-Hours#getting-started)
	* [Setting up your Opening Hours](https://github.com/janizde/WP-Opening-Hours#set-up)
	* [Child Sets](https://github.com/janizde/WP-Opening-Hours#child-sets)
* [Widgets](https://github.com/janizde/WP-Opening-Hours#widgets)
	* [Overview Widget](https://github.com/janizde/WP-Opening-Hours#overview-widget)
	* [Is Open Widget](https://github.com/janizde/WP-Opening-Hours#is-open-widget)
	* [Holidays Widget](https://github.com/janizde/WP-Opening-Hours#holidays-widget)
	* [Irregular Openings Widget](https://github.com/janizde/WP-Opening-Hours#irregular-openings-widget)
* [Shortcodes](https://github.com/janizde/WP-Opening-Hours#shortcodes)
	* [Common Attributes](https://github.com/janizde/WP-Opening-Hours#common-attributes)
	* [[op-overview] Shortcode](https://github.com/janizde/WP-Opening-Hours#op-overview-shortcode)
	* [[op-is-open] Shortcode](https://github.com/janizde/WP-Opening-Hours#op-is-open-shortcode)
	* [[op-holidays] Shortcode](https://github.com/janizde/WP-Opening-Hours#op-holidays-shortcode)
	* [[op-irregular-openings] Shortcode](https://github.com/janizde/WP-Opening-Hours#op-irregular-openings-shortcode)
* [Filters](https://github.com/janizde/WP-Opening-Hours#filters)
* [Troubleshooting / FAQ](https://github.com/janizde/WP-Opening-Hours#troubleshooting)
* [Contributing](https://github.com/janizde/WP-Opening-Hours#contributing)
	* [Contributing to Code](https://github.com/janizde/WP-Opening-Hours#contributing-to-code)
	* [Contributing to Translations](https://github.com/janizde/WP-Opening-Hours#contributing-to-translations)
* [Changelog](https://github.com/janizde/WP-Opening-Hours#changelog)
* [License](https://github.com/janizde/WP-Opening-Hours#license)

== Installation ==

There are multiple ways to install the Opening Hours Plugin

1. [WordPress Plugin Installer](https://github.com/janizde/WP-Opening-Hours#wordpress-plugin-installer)
1. [Manual Installation](https://github.com/janizde/WP-Opening-Hours#manual-installation)
1. [Composer](https://github.com/janizde/WP-Opening-Hours#composer)
1. [Clone GitHub Repository](https://github.com/janizde/WP-Opening-Hours#clone-repository)

== Frequently Asked Questions ==

= How can I change the styling of the widgets / shortcodes? =

The Plugin provides very minimal styling, which is the red and green colors for the open / closed messages. All other kind of styling is left to the WordPress Theme you are using or your custom CSS.
To disable the styling of the text color the [`op_use_front_end_styles`](https://github.com/janizde/WP-Opening-Hours/blob/master/doc/filters.md#op_use_front_end_styles) filter hook can be used.

= My language is not provided in the Plugin =

You can participate to Plugin translations to make it available in more languages.
Please read the section on [contributing to translations](https://github.com/janizde/WP-Opening-Hours#contributing-to-translations)

= I found a bug and I would like to fix it =

If you found a bug you would like to fix feel free to [contribute to the project on GitHub](https://github.com/janizde/WP-Opening-Hours#contributing-to-code).

== Changelog ==

= 1.0.0 =
initial version

== Upgrade Notice ==

= 2.0 =
The plugin has been rewritten from scratch and a lot has changed. Old data should be converted automatically but a lot of the CSS classes have changed. Take some time to update it and maybe test it in a development environment to make sure it works as expected. Requires PHP >= 5.3, WordPress >= 4


== Credits ==

Opening Hours is based on the original plugin by Jannik Portz. The new release also includes work by several other people:
•	Daniel Mester Pirttijärvi (Jdenticon),
•	Shamus Young (Wavatars),
•	Andreas Gohr (the original MonsterID and RingIcon),
•	Scott Sherrill-Mix & Katherine Garner (the hand-drawn monster update)
•	Benjamin Laugueux (Identicon),
•	David Revoy (Bird and Cat Avatars),
•	Zikri Kader, Colin Davis & Nimiq (RoboHash), and
•	Johanna Amann (the Avatar Privacy icon).
https://wordpress.org/plugins/avatar-privacy/

