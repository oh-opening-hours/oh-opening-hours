=== O/H - Opening Hours ===
Contributors: kirnbauer, janizde
Tags: opening hours,business hours,hours,table,overview,date,time,widget,shortcode,status,currently open,bar,restaurant
Tested up to: 6.1.1
Stable tag: 1.0.0
Requires at least: 5.9.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The "O/H - Opening Hours" WordPress plugin provides a range of customization options for displaying your business's operating hours with the use of Shortcodes and Widgets.

== Description ==

The WordPress Opening Hours plugin offers advanced features, including support for multiple sets of opening hours that can be used independently for different areas of your business, like a restaurant and a bar. It also supports holidays, allowing you to set special opening hours for those occasions. Moreover, the plugin can manage irregular opening hours, such as changes during the Christmas period.

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

[More on Widgets](https://github.com/oh-opening-hours/oh-opening-hours#widgets)

= Shortcodes =
All of the widgets listed up above are also available as shortcodes.
With the [Opening Hours Shortcode Builder](https://oh-opening-hours.github.io/oh-shortcode-builder/) you can assemble a Shortcode by filling in a form. This is particularly useful when you are not comfortable with the shortcode syntax.

* [More on Shortcodes](https://github.com/oh-opening-hours/oh-opening-hours#shortcodes)
* [Shortcode Builder](https://oh-opening-hours.github.io/oh-shortcode-builder/)
* [Shortcode Builder on GitHub](https://github.com/oh-opening-hours/oh-shortcode-builder)

= Further Documentation =
**Further documentation is available on [GitHub](https://github.com/oh-opening-hours/oh-opening-hours).**

* [Features](https://github.com/oh-opening-hours/oh-opening-hours#features)
* [Installation](https://github.com/oh-opening-hours/oh-opening-hours#installation)
	* [WordPress Plugin Installer](https://github.com/oh-opening-hours/oh-opening-hours#wordpress-plugin-installer)
	* [Manual Installation](https://github.com/oh-opening-hours/oh-opening-hours#manual-installation)
	* [Composer](https://github.com/oh-opening-hours/oh-opening-hours#composer)
	* [Clone GitHub Repository](https://github.com/oh-opening-hours/oh-opening-hours#clone-repository)
* [Getting Started](https://github.com/oh-opening-hours/oh-opening-hours#getting-started)
	* [Setting up your Opening Hours](https://github.com/oh-opening-hours/oh-opening-hours#set-up)
	* [Child Sets](https://github.com/oh-opening-hours/oh-opening-hours#child-sets)
* [Widgets](https://github.com/oh-opening-hours/oh-opening-hours#widgets)
	* [Overview Widget](https://github.com/oh-opening-hours/oh-opening-hours#overview-widget)
	* [Is Open Widget](https://github.com/oh-opening-hours/oh-opening-hours#is-open-widget)
	* [Holidays Widget](https://github.com/oh-opening-hours/oh-opening-hours#holidays-widget)
	* [Irregular Openings Widget](https://github.com/oh-opening-hours/oh-opening-hours#irregular-openings-widget)
* [Shortcodes](https://github.com/oh-opening-hours/oh-opening-hours#shortcodes)
	* [Common Attributes](https://github.com/oh-opening-hours/oh-opening-hours#common-attributes)
	* [[op-overview] Shortcode](https://github.com/oh-opening-hours/oh-opening-hours#op-overview-shortcode)
	* [[op-is-open] Shortcode](https://github.com/oh-opening-hours/oh-opening-hours#op-is-open-shortcode)
	* [[op-holidays] Shortcode](https://github.com/oh-opening-hours/oh-opening-hours#op-holidays-shortcode)
	* [[op-irregular-openings] Shortcode](https://github.com/oh-opening-hours/oh-opening-hours#op-irregular-openings-shortcode)
* [Filters](https://github.com/oh-opening-hours/oh-opening-hours#filters)
* [Troubleshooting / FAQ](https://github.com/oh-opening-hours/oh-opening-hours#troubleshooting)
* [Contributing](https://github.com/oh-opening-hours/oh-opening-hours#contributing)
	* [Contributing to Code](https://github.com/oh-opening-hours/oh-opening-hours#contributing-to-code)
	* [Contributing to Translations](https://github.com/oh-opening-hours/oh-opening-hours#contributing-to-translations)
* [Changelog](https://github.com/oh-opening-hours/oh-opening-hours#changelog)
* [License](https://github.com/oh-opening-hours/oh-opening-hours#license)

== Installation ==

There are multiple ways to install the Opening Hours Plugin

1. [WordPress Plugin Installer](https://github.com/oh-opening-hours/oh-opening-hours#wordpress-plugin-installer)
1. [Manual Installation](https://github.com/oh-opening-hours/oh-opening-hours#manual-installation)
1. [Composer](https://github.com/oh-opening-hours/oh-opening-hours#composer)
1. [Clone GitHub Repository](https://github.com/oh-opening-hours/oh-opening-hours#clone-repository)

== Frequently Asked Questions ==

= How can I change the styling of the widgets / shortcodes? =

The Plugin provides very minimal styling, which is the red and green colors for the open / closed messages. All other kind of styling is left to the WordPress Theme you are using or your custom CSS.
To disable the styling of the text color the [`op_use_front_end_styles`](https://github.com/oh-opening-hours/oh-opening-hours/blob/master/doc/filters.md#op_use_front_end_styles) filter hook can be used.

= My language is not provided in the Plugin =

You can participate to Plugin translations to make it available in more languages.
Please read the section on [contributing to translations](https://github.com/oh-opening-hours/oh-opening-hours#contributing-to-translations)

= I found a bug and I would like to fix it =

If you found a bug you would like to fix feel free to [contribute to the project on GitHub](https://github.com/oh-opening-hours/oh-opening-hours#contributing-to-code).

== Credits ==

Opening Hours is based on the great plugin by [Jannik Portz](https://github.com/janizde/WP-Opening-Hours).

== Changelog ==

= 1.0.0 =
initial version
* fix security issues
* improvements