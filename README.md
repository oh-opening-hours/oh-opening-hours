# O/H - Opening Hours 🕐

Opening Hours is a highly customizable WordPress plugin to set up your venue's opening hours and display them with Shortcodes and Widgets.

## <a name="contents"></a>Contents
* [Features](#features)
* [Installation](#installation)
	* [WordPress Plugin Installer](#wordpress-plugin-installer)
	* [Manual Installation](#manual-installation)
	* [Composer](#composer)
	* [Clone GitHub Repository](#clone-repository)
* [Getting Started](#getting-started)
	* [Setting up your Opening Hours](#set-up)
	* [Child Sets](#child-sets)
* [Widgets](#widgets)
	* [Overview Widget](#overview-widget)
	* [Is Open Widget](#is-open-widget)
	* [Holidays Widget](#holidays-widget)
	* [Irregular Openings Widget](#irregular-openings-widget)
	* [Schema.org Widget](#schema-org-widget)
* [Shortcodes](#shortcodes)
    * [Shortcode Builder](#shortcode-builder)
	* [Common Attributes](#common-attributes)
	* [[op-overview] Shortcode](#op-overview-shortcode)
	* [[op-is-open] Shortcode](#op-is-open-shortcode)
	* [[op-holidays] Shortcode](#op-holidays-shortcode)
	* [[op-irregular-openings] Shortcode](#op-irregular-openings-shortcode)
	* [[op-schema] Shortcode](#op-schema-shortcode)
* [Troubleshooting / FAQ](#troubleshooting)
* [Contributing](#contributing)
	* [Contributing to Code](#contributing-to-code)
	* [Contributing to Translations](#contributing-to-translations)
* [Changelog](#changelog)
* [Credits](#credits)
* [License](#license)

## Further Reading
* [Schema.org Integration](./doc/schema-org.md)
* [Developer Guide](./doc/developer-guide.md)
* [Filters](./doc/filters.md)
* [Set Providers](./doc/set-providers.md)

## <a name="features"></a>Features
* Supports multiple Sets of Opening Hours (e.g. one for your restaurant and one for your bar) that you can use independently.
* Supports Hollidays
* Supports Irregular Openings (e.g. different opening hours during Christmas)
* Supports child sets that overwrite your regular opening hours in a specific time period (e.g. seasonal opening hours or an extra day in every second week)
* Four highly customizable Widgets and Shortcodes also displaying contextual information (e.g. "We're currently closed but will be open again on Monday at 8am")

[↑ Table of Contents](#contents)

## <a name="installation"></a>Installation

### <a name="wordpress-plugin-installer"></a>WordPress Plugin Installer
1. Go to your WordPress dashboard
1. Navigate to "Plugins"
1. Click "Install"
1. Search for "Opening Hours"
1. Click "Install" on the Plugin "Opening Hours" by Jannik Portz
1. Activate the Plugin

### <a name="manual-installation"></a>Manual Installation
1. Download the .zip-archive from <https://wordpress.org/plugins/oh-opening-hours/>
1. Unzip the archive
1. Upload the directory /opening-hours to your wp-content/plugins
1. In your Admin Panel go to Plugins and active the Opening Hours Plugin
1. Now you can edit your Opening Hours in the Settings-Section
1. Place the Widgets in your Sidebars or use the Shortcode in your posts and Pages

### <a name="composer"></a>Composer
If you are managing your WordPress Plugins via composer (e.g. when using [Bedrock](https://roots.io/bedrock/docs/composer/)) the Opening Hours Plugin is also available on [wpackagist](https://wpackagist.org/).

Make sure you have wpackagist registered as repository in your composer.json file

~~~json
"repositories": [
  {
    "type": "composer",
    "url": "https://wpackagist.org"
  }
],
~~~

Add the Opening Hours plugin as dependency

~~~json
"require": {
  "wpackagist-plugin/oh-opening-hours": "1.2"
}
~~~

### <a name="clone-repository"></a>From GitHub repository
Especially when installing a beta version for testing it makes sense to clone the GitHub Repository and checkout the branch
from which you want to install the plugin. Before you can actually use the plugin you will have to perform the following steps **(Node.js required)**

1. Open your command line and navigate to the project directory
1. Make sure you have already loaded the submodules. If not run `git submodule update`
1. If you do not already have gulp installed globally run `npm install -g gulp`
1. `npm install`
1. `gulp build`

Alternatively you can also clone the repository somewhere on your computer and run `gulp export` instead of `gulp build`.
A .zip archive containing a built version of the plugin will be placed inside the project directory that you can unzip and place in
the `wp-content/plugins` directory of the WordPress installation of your choice.

[↑ Table of Contents](#contents)

## <a name="getting-started"></a>Getting Started
### <a name="set-up"></a>Setting up your Opening Hours

The first step to set up your Opening Hours is to create a Set.
A Set consists of Periods for all weekdays, Holidays and Irregular Openings.
If you only want to display the Opening Hours for one venue you're fine with a single Set but you can as well add multiple Sets, each representing individual Opening Hours. You can for example add one Set for your restaurant and one Set for your Bar if you use one website for them and specify the desired Set per Widget or Shortcode.

**Please Note: You will need to have administrator priviledges to manage Sets**

**Step 1:** Go to your admin Dashboard and navigate to "Opening Hours". You will see a list of all your Sets. To add a new Set click "Add New" next to the heading.

![Opening Hours Menu](./doc/screenshots/menu.png)

**Step 2:** Give your Set a name in the "Enter title here" input. The name is only used internally and you can specify individual titles per Widget or Shortcode.

![Specify Set name](./doc/screenshots/set-name.png)

**Step 3:** Set up Opening Hours. In the Opening Hours Section you can edit the time inputs for each weekday. When clicking the `+`-Button you can add more periods per day. When clicking the `x`-Button next to a period you can delete periods.

![Specify Opening Hours](./doc/screenshots/opening-hours.png)

**Step 4:** Set up Holidays. In the Holidays Section you can edit the name and the start and end dates. When clicking the "Add New Holiday" you can add more Holidays. You can also delete holidays when clicking the `x`-Button next to a Holiday.

![Specify Holidays](./doc/screenshots/holidays.png)

**Step 5:** Set up Irregular Openings. Irregular Openings specify irregular opening hours for a specific day. You would for example add an Irregular Opening for NYE when you are only open in the morning. You can edit the name, the date and start and end time.  
When clicking the "Add New Irregular Opening" you can add more Irregular Openings. You can also delete Irregular Openings when clicking the `x`-Button next to a row.

![Specify Irregular Openings](./doc/screenshots/irregular-openings.png)

**Step 6 (optional):** In the Set Details Section you can give your Set a description. This is optional but the description can be displayed in the Overview Widget/Shortcode.

![Specify Set name](./doc/screenshots/set-description.png)

<a name="getting-started-specify-set-alias"></a>
**Step 7 (optional):** In the Set Details section you can also set your custom Set Alias [which you can use instead of the Set Id in Shortcodes.](#common-attributes) If you specify a specific Set Alias for more than one Set all Shortcodes will use the Set with the least value for `menu_order`.  
Your Theme or a 3rd party Plugin [may also specify Set Alias presets](./doc/filters.md#op_set_alias_presets) to make it easier for yor to enter the right one. Please note that Set Alias presets only work in browsers supporting HTML5 `datalist`.

![Specify Set Alias](./doc/screenshots/set-alias-presets.png)

**Step 8:** Save the data by clicking the "Save"/"Publish"-Button. **Any changes will not be saved without saving the whole Set!**

### <a name="child-sets"></a>Child Sets

You may also set up child Sets with different Opening Hours for a longer Period of time. You can define a date range or a week scheme (even/odd weeks) when the Opening Hours of the Child Set should be used. You can for example use Child Sets if you have different Opening Hours in winter.   
In Child Sets you can only set up Opening Hours but no Holidays or Irregular Openings.

**Step 1:** Make sure you have another Set which you can use as parent Set with the "regular" Opening Hours.

**Step 2:** Add a new Set by clicking the "Add New"-Button in the list of Sets.

**Step 3:** In the Attributes Section select the parent Set under "Parent".

![Specify parent Set](./doc/screenshots/child-set-parent.png)

**Step 4:** Click the "Save"/"Publish"-Button

**Step 5:** Set up the custom Opening Hours for the Child Set.

**Step 6:** Set the usage criteria in the Set Details Section. You can set a start and end date and/or a week scheme. Note that if you don't set start or end date and leave week scheme at "Every Week" the Child Set will never be used.

![Specify child Set criteria](./doc/screenshots/child-set-criteria.png)

**Step 7:** Save the Child Set.

The Plugin will now automatically use the Opening Hours of the Child Set when the usage criteria matches the current time.

[↑ Table of Contents](#contents)

## <a name="widgets"></a>Widgets
### <a name="overview-widget"></a>Overview Widget
The Overview widget displays a table with all the opening hours in the speficied set.  
There are the following options:

<table>
	<header>
		<div width="25%">Name</div>
		<div class="col">Description</div>
	</header>
	<div class="row">
		<div>
			<td>Title</div>
			<td>The title of the Widget. Will be displayed above the opening hours</div>
		</div>
		<div>
			<td>Set to show</div>
			<td>Select the set whose opening hours you want to show</div>
		</div>
		<div>
			<td>Highlight</div>
			<td>
			Select which type of information shall be highlighted.<br>
			Possible options are:
			<ul>
				<li>Nothing</li>
				<li>Running Period</li>
				<li>Current Weekday</li>
			</ul>
			</div>
		</div>
		<div>
			<td>Show closed days</div>
			<td>Whether to display a row for closed days with a "Closed"-caption</div>
		</div>
		<div>
			<td>Show description</div>
			<td>Whether to display the set description above the opening hours</div>
		</div>
		<div>
			<td>Compress opening hours</div>
			<td>Whether to compress the opening hours. This means that the plugin will search for days with mutual opening hours and then group those together to one row in the table with a title like "Monday - Wednesday".</div>
		</div>
		<div>
			<td>Use short day captions</div>
			<td>Whether to use abbreviations for weekdays. E.g. "Monday" becomes "Mon.". This feature is also available in all other supported languages.</div>
		</div>
		<div>
			<td>Include Irregular Openings</div>
			<td>If there is an irregular opening on any day in the table it will replace the regular opening hours with the irregular opening hours for that day.</div>
		</div>
		<div>
			<td>Include Holidays</div>
			<td>If there is a holiday during one or more days in the table it will replace the regular opening hours of those days with the name of the holiday.</div>
		</div>
		<div>
			<td>Template</div>
			<td>You can choose among two templates: Table and List. The list template will display all data in a vertical list. This is useful for narrow sidebars.</div>
		</div>
	</div>
	<header>
		<div colspan="2">Extended Settings</div>
	</header>
	<div class="row">
		<div>
			<td>Caption closed</div>
			<td>Speficy a custom caption for closed days.</div>
		</div>
		<div>
			<td>Highlighted period class</div>
			<td>Custom CSS class for highlighted periods. default <code>highlighted</code></div>
		</div>
		<div>
			<td>Highlighted day class</div>
			<td>Custom CSS class for highlighted days. default: <code>highlighted</code></div>
		</div>
		<div>
			<td>PHP Time Format</div>
			<td>Custom format for times. The default is your standard WordPress setting. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
		<div>
			<td>Hide date of irregular openings</div>
			<td>Whether to hide the date of irregular openings if they are in the table.</div>
		</div>
		<div>
			<td>Week offset</div>
			<td>Number of weeks the shortcode data shall be offset. Might be a positive or negative integer.</div>
		</div>
	</div>
</section>

#### Overview Widget in table view
![Overview Widget Table](./doc/screenshots/widget-overview-table.png)

#### Overview Widget in list view
![Overview Widget List](./doc/screenshots/widget-overview-list.png)

#### Overview Widget Options
![Overview Widget Options](./doc/screenshots/widget-overview-options.png)

### <a name="is-open-widget"></a>Is Open Widget
The Is Open Widget displays a message whether a venue (a Set) is currently open/active.  
There are the folliwing options:

<table>
	<header>
		<div width="25%">Name</div>
		<div class="col">Description</div>
	</header>
	<div class="row">
		<div>
			<td>Title</div>
			<td>The Widget Title</div>
		</div>
		<div>
			<td>Set</div>
			<td>Select a set whose opening status you want to show</div>
		</div>
		<div>
			<td>Show next open period</div>
			<td>When checked, a message telling the next open period will be displayed if the venue (set) is currently closed.</div>
		</div>
		<div>
			<td>Show today's opening hours</div>
			<td>Specify in which cases today's opening hours shall be displayed in the widget</div>
		</div>
	</div>
	<header>
		<div colspan="2">Extended Settings</div>
	</header>
	<div class="row">
		<div>
			<td>Caption if open</div>
			<td>Custom caption to show when the venue is open</div>
		</div>
		<div>
			<td>Caption if closed</div>
			<td>Custom caption to show when the venue is closed</div>
		</div>
		<div>
			<td>Class if open</div>
			<td>Custom CSS class when the venue is open</div>
		</div>
		<div>
			<td>Class if closed</div>
			<td>Custom CSS class when the venue is closed</div>
		</div>
		<div>
			<td>Next Period string format</div>
			<td>A custom string format for the next open period message.<br />
			You can populate the string with the following placeholders:
			<ul>
				<li><code>%1$s</code> The formatted date of the next open period</li>
				<li><code>%2$s</code> The name of the weekday of the next open period</li>
				<li><code>%3$s</code> The formatted start time of the next open period</li>
				<li><code>%4$s</code> The formatted end time of the next open period</li>
			</ul>
			Example: <code>We're open again on %2$s (%1$s) from %3$s to %4$s</code>
			</div>
		</div>
		<div>
			<td>Today' opening hours string format</div>
			<td>A custom string format for the today's opening hours message.<br />
			You can populate the string with the following placeholders:
			<ul>
				<li><code>%1$s</code> The formatted time ranges of all periods</li>
				<li><code>%2$s</code> The formatted start time of the first period</li>
				<li><code>%3$s</code> The formatted end time of the last period</li>
			</ul>
			Example: <code>We're open today from %2$s to %3$s.</code>
			</div>
		</div>
		<div>
			<td>PHP Date Format</div>
			<td>Custom PHP date format for the date of the next open period. The default is your standard WordPress setting. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
		<div>
			<td>PHP Time Format</div>
			<td>Custom PHP date format for the start and end time of the next open period. The default is your standard WordPress setting. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
	</div>
</section>

#### Is Open Widget showing next open Period
![Is Open Widget](./doc/screenshots/widget-is-open.png)

#### Is Open Widget Options
![Is Open Widget Options](./doc/screenshots/widget-is-open-options.png)

### <a name="holidays-widget"></a>Holidays Widget
The holiday widget displays all holidays in the specified set in a table or list. Holidays are always sorted ascedingly by their start dates.  
There are the following options:

<table>
	<header>
		<div width="25%">Name</div>
		<div class="col">Description</div>
	</header>
	<div class="row">
		<div>
			<td>Title</div>
			<td>The Widget title</div>
		</div>
		<div>
			<td>Set</div>
			<td>Select a set whose holidays you want to display.</div>
		</div>
		<div>
			<td>Highlight active holidays</div>
			<td>Whether to highlight active holidays in the table</div>
		</div>
		<div>
			<td>Template</div>
			<td>You can choose among two templates: Table and List. The list template will display all data in a vertical list. This is useful for narrow sidebars.</div>
		</div>
		<div>
			<td>Include past holidays</div>
			<td>Whether to show past holidays in the widget</div>
		</div>
	</div>
	<header>
		<div colspan="2">Extended Settings</div>
	</header>
	<div class="row">
		<div>
			<td>Class for highlighted Holiday</div>
			<td>Custom CSS class for highlighted Holidays. default: <code>highlighted</code></div>
		</div>
		<div>
			<td>PHP Date Format</div>
			<td>Custom PHP date format for the start and end date of the holidays. The default is your standard WordPress setting. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
	</div>
</section>

#### Holidays Widget in table view
![Holidays Widget in table view](./doc/screenshots/widget-holidays-table.png)

#### Holidays Widget in list view
![Holidays Widget in list view](./doc/screenshots/widget-holidays-list.png)

#### Holidays Widget Options
![Holidays Widget options](./doc/screenshots/widget-holidays-options.png)

### <a name="irregular-openings-widget"></a>Irregular Openings Widget

The Irregular Openings Widget displays all Irregular Openings in the specified Set in a table or list. Irregular Openings are always sorted ascendingly by their start dates and times.  
An Irregular Opening is reagarded as being in the past, when the full day, when the Irregular Opening takes place, has ended.  
There are the following options:

<table>
	<header>
		<div width="25%">Name</div>
		<div class="col">Description</div>
	</header>
	<div class="row">
		<div>
			<td>Title</div>
			<td>The Widget title</div>
		</div>
		<div>
			<td>Set</div>
			<td>Select a Set whose Irregular Openings you want to show.</div>
		</div>
		<div>
			<td>Highlight active Irregular Opening</div>
			<td>Whether to highlight active irregular openings in the table or list</div>
		</div>
		<div>
			<td>Template</div>
			<td>You can choose among two templates: Table and List. The list template will display all data in a vertical list. This is useful for narrow sidebars.</div>
		</div>
		<div>
			<td>Include past irregular openings</div>
			<td>Whether to show past irregular openings in the widget</div>
		</div>
	</div>
	<header>
		<div colspan="2">Extended Settings</div>
	</header>
	<div class="row">
		<div>
			<td>Class for Highlighted Irregular Opening</div>
			<td>Custom CSS class for highlighted Irregular Openings in the table or list. default: <code>highlighted</code></div>
		</div>
		<div>
			<td>PHP Date Format</div>
			<td>Custom PHP date format for the date of the irregular openings. The default is your standard WordPress setting. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
		<div>
			<td>PHP Time Format</div>
			<td>Custom PHP date format for the start and end time of the irregular openings. The default is your standard WordPress setting. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
	</div>
</section>

#### Irregular Openings Widget in list view
![Irregular Openings Widget in list view](./doc/screenshots/widget-irregular-openings-list.png)

#### Irregular Openings Widget options
![Irregular Openings Widget options](./doc/screenshots/widget-irregular-openings-options.png)

### <a name="schema-org-widget"></a>Schema.org Widget

The **Schema.org Widget**adds a JSON-LD record to the WordPress site representing the opening hours of a given Set. [Refer to the docs on Schema.org integration](doc/schema-org.md) for more information. 

There are the following options:

<table>
	<header>
		<div width="25%">Name</div>
		<div class="col">Description</div>
	</header>
	<div class="row">
		<div>
			<td>Set</div>
			<td>The Set whose JSON-LD representation to insert</div>
		</div>
		<div>
			<td>Exclude Holidays</div>
			<td>When enabled, holidays are not considered for the SpecialOpeningHoursSpecification</div>
		</div>
		<div>
			<td>Exclude Irregular Openings</div>
			<td>When enabled, irregular openings are not considered for the SpecialOpeningHoursSpecification</div>
		</div>
	</div>
	<header>
		<div colspan="2">Extended Settings</div>
	</header>
	<div class="row">
		<div>
			<td><code>@Type</code> property of the schema object</div>
			<td>Custom override for the @type of the schema record. By default <a href="https://schema.org/Place" target="_blank">Place</a> is taken.</div>
		</div>
		<div>
			<td><code>name</code> property of the schema object</div>
			<td>Custom override for the <code>name</code> of the schema record. By default the name of the selected Set is taken.</div>
		</div>
		<div>
			<td><code>description</code> property of the schema object</div>
			<td>Custom override for the <code>description</code> of the schema record. By default the description of the selected Set is taken.</div>
		</div>
	</div>
</section>

#### Schema.org Widget options
![Schema.org Widget options](./doc/screenshots/widget-schema-options.png)

[↑ Table of Contents](#contents)

## <a name="shortcodes"></a>Shortcodes

### About Shortcodes

Shortcodes are a WordPress core component, which give you the ability to add rich components to your posts' and pages' content. You can insert a Shortcode in the default WordPress editor.

The basic format of a shortcode is:

```
[shortcode-tag an_attribute="attr_value" another_attribute="another_attr_value"]
```

> **Heads up**  
> Shortcode attributes of type `bool` can either be `true` (meaning "yes") or `false` (meaning "no").

You can read more about Shortcodes in the [WordPress documentation.](https://codex.wordpress.org/Shortcode)

Shortcodes have exactly the same options as Widgets because every Widget is basically a representation of the corresponding Shortcode with a GUI for the Widget edit section.  
**The only required attribute for all Shortcodes is `set_id`. All other attributes are optional!**

### <a name="shortcode-builder"></a>Shortcode Builder

The [Opening Hours Shortcode Builder](https://oh-opening-hours.github.io/oh-shortcode-builder/) assembles shortcodes for you that you can copy and insert into your content. This is particularly useful for people who are unfamiliar with shortcodes.

The builder can be found at [https://janizde.github.io/opening-hours-shortcode-builder/](https://oh-opening-hours.github.io/oh-shortcode-builder/)  
Development takes place in the [GitHub Repo](https://github.com/oh-opening-hours/oh-shortcode-builder)

In the edit page of parent sets the button *Create a Shortcode* opens the shortcode builder in a popup and prefills the `set_id` accordingly.

### <a name="common-attributes"></a>Common attributes for all Shortcodes
<table>
	<header>
		<div width="25%">Name</div>
		<div width="15%">Type</div>
		<div width="15%">Default</div>
		<div width="45%">Description</div>
	</header>
	<div class="row">
		<div>
			<td><code>set_id</code></div>
			<td><code>int|string</code></div>
			<td>–</div>
			<td><strong>(required)</strong> The id of the set whose data you want to show. For regular Sets you may also use <a href="#getting-started-specify-set-alias">your custom Set Alias here</a></div>
		</div>
		<div>
			<td><code>title</code></div>
			<td><code>string</code></div>
			<td>–</div>
			<td>The widget title</div>
		</div>
		<div>
			<td><code>before_title</code></div>
			<td><code>string</code></div>
			<td><code>&lt;h3 class="op-{name}-title"&gt;</code></div>
			<td>HTML before the title. When using Widgets this will be overridden by the sidebar's <code>before_title</code> attribute.</div>
		</div>
		<div>
			<td><code>after_title</code></div>
			<td><code>string</code></div>
			<td><code>&lt;/h3&gt;</code></div>
			<td>HTML after the title. When using Widgets this will be overridden by the sidebar's <code>after_title</code> attribute.</div>
		</div>
		<div>
			<td><code>before_widget</code></div>
			<td><code>string</code></div>
			<td><code>&lt;div class="op-{name}-shortcode"&gt;</code></div>
			<td>HTML before shortcode contents. When using Widgets this will be overridden by the sidebar's <code>before_widget</code> attribute.</div>
		</div>
		<div>
			<td><code>after_widget</code></div>
			<td><code>string</code></div>
			<td><code>&lt;/div&gt;</code></div>
			<td>HTML after shortcode contents. When using Widgets this will be overridden by the sidebar's <code>after_widget</code> attribute.</div>
		</div>
	</div>
</section>

### <a name="op-overview-shortcode"></a>op-overview Shortcode
Corresponds to the Overview Widget.  
The **[op-overview]** shortcode displays the opening hours of the specified set.  
The following attributes are available (Also mind the **[Common Attributes](#common-attributes)**):

<table>
	<header>
		<div width="25%">Name</div>
		<div width="15%">Type</div>
		<div width="15%">Default</div>
		<div width="45%">Description</div>
	</header>
	<div class="row">
		<div>
			<td><code>show_closed_days</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Whether to display a row for closed days with a "Closed"-caption</div>
		</div>
		<div>
			<td><code>caption_closed</code></div>
			<td><code>string</code></div>
			<td><code>Closed</code></div>
			<td>Change the text of the closed caption</div>
		</div>
		<div>
			<td><code>show_description</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Whether to display the set description above the opening hours</div>
		</div>
		<div>
			<td><code>highlight</code></div>
			<td><code>string</code></div>
			<td><code>noting</code></div>
			<td>What type of information to highlight. Possible values are: <code>noting</code>, <code>period</code> (currently active period), <code>day</code> (current weekday)</div>
		</div>
		<div>
			<td><code>compress</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Whether to compress the opening hours. This means that the plugin will search for days with mutual opening hours and then group those together to one row in the table with a title like "Monday - Wednesday".</div>
		</div>
		<div>
			<td><code>short</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Whether to use abbreviations for weekdays. E.g. "Monday" becomes "Mon.". This feature is also available in all other supported languages.</div>
		</div>
		<div>
			<td><code>include_io</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>If there is an irregular opening on any day in the table it will replace the regular opening hours with the irregular opening hours for that day.</div>
		</div>
		<div>
			<td><code>include_holidays</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>If there is a holiday during one or more days in the table it will replace the regular opening hours of those days with the name of the holiday.</div>
		</div>
		<div>
			<td><code>highlighted_period_class</code></div>
			<td><code>string</code></div>
			<td><code>highlighted</code></div>
			<td>CSS class for highlighted periods</div>
		</div>
		<div>
			<td><code>highlighted_day_class</code></div>
			<td><code>string</code></div>
			<td><code>highlighted</code></div>
			<td>CSS class for current weekday</div>
		</div>
		<div>
			<td><code>time_format</code></div>
			<td><code>string</code></div>
			<td>WordPress setting</div>
			<td>Custom format for times. The default is your standard WordPress setting. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
		<div>
			<td><code>hide_io_date</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Whether to hide the date of irregular openings if they are in the table.</div>
		</div>
		<div>
			<td><code>template</code></div>
			<td><code>string</code></div>
			<td><code>table</code></div>
			<td>Identifier for the template to use. Possible values are <code>table</code> and <code>list</code></div>
		</div>
		<div>
			<td><code>week_offset</code></div>
			<td><code>int</code></div>
			<td><code>0</code></div>
			<td>
				Number of weeks the shortcode data shall be offset. Might be a positive or negative integer.<br />
				<strong>Example:</strong> <code>1</code>: Show data of next week
			</div>
		</div>
	</div>
</section>

### <a name="op-is-open-shortcode"></a>op-is-open Shortcode
Corresponds to the Is Open Widget.  
The **[op-is-open]** shortcode displays a message whether the specified venue (set) is currently open or not.  
The following attributes are available (Also mind the **[Common Attributes](#common-attributes)**):

<table>
	<header>
		<div width="25%">Name</div>
		<div width="15%">Type</div>
		<div width="15%">Default</div>
		<div width="45%">Description</div>
	</header>
	<div class="row">
		<div>
			<td><code>open_text</code></div>
			<td><code>string</code></div>
			<td>We're currently open (translated)</div>
			<td>Caption to show when the venue is open</div>
		</div>
		<div>
			<td><code>closed_text</code></div>
			<td><code>string</code></div>
			<td>We're currently closed (translated)</div>
			<td>Caption to show when the venue is closed</div>
		</div>
		<div>
			<td><code>closed_holiday_text</code></div>
			<td><code>string</code></div>
			<td>We\'re currently closed for <code>%1$s</code>. (translated)</div>
			<td>Caption to show when the venue is closed and if there is one or more holidays, show them in a comma separated list<br><strong>Note:</strong> <code>show_closed_holidays</code> must be set to <code>true</code> for this to be displayed.<br>
			<ul>
				<li><code>%1$s</code> A comma separated formatted string of todays holiday(s)</li>
			</ul></div>
		</div>
		<div>
			<td><code>show_next</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>When <code>true</code>, a message telling the next open period will be displayed if the venue (set) is currently closed.</div>
		</div>
		<div>
			<td><code>show_today</code></div>
			<td><code>string (enum)</code></div>
			<td><code>never</code></div>
			<td>
				When to show today's opening hours<br />
				The following values are valid:
				<ul>
					<li><code>never</code></li>
					<li><code>open</code></li>
					<li><code>always</code></li>
				</ul>
			</div>
		</div>
		<div>
			<td><code>show_closed_holidays</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Show today's holiday name(s) when closed</div>
		</div>
		<div>
			<td><code>next_format</code></div>
			<td><code>string</code></div>
			<td>We're open again on <code>%2$s</code> (<code>%1$s</code>) from <code>%3$s</code> to <code>%4$s</code></div>
			<td>A custom string format for the next open period message.<br />
			You can populate the string with the following placeholders:
			<ul>
				<li><code>%1$s</code> The formatted date of the next open period</li>
				<li><code>%2$s</code> The name of the weekday of the next open period (translated)</li>
				<li><code>%3$s</code> The formatted start time of the next open period</li>
				<li><code>%4$s</code> The formatted end time of the next open period</li>
			</ul></div>
		</div>
		<div>
			<td><code>today_format</code></div>
			<td><code>string</code></div>
			<td>Opening Hours today: <code>%1$s</code></div>
			<td>A custom string format for the today's opening hours message.<br />
			You can populate the string with the following placeholders:
			<ul>
				<li><code>%1$s</code> The formatted time ranges of all periods</li>
				<li><code>%2$s</code> The formatted start time of the first period</li>
				<li><code>%3$s</code> The formatted end time of the last period</li>
			</ul></div>
		</div>
		<div>
			<td><code>open_class</code></div>
			<td><code>string</code></div>
			<td><code>op-open</code></div>
			<td>CSS class if the venue (set) is open</div>
		</div>
		<div>
			<td><code>closed_class</code></div>
			<td><code>string</code></div>
			<td><code>op-closed</code></div>
			<td>CSS class if the venue (set) is closed</div>
		</div>
		<div>
			<td><code>date_format</code></div>
			<td><code>string</code></div>
			<td>WordPress setting</div>
			<td>PHP date format for the date of the next open period. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
		<div>
			<td><code>time_format</code></div>
			<td><code>string</code></div>
			<td>WordPress setting</div>
			<td>PHP date format for the start and end time of the next open period. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
	</div>
</section>

### <a name="op-holidays-shortcode"></a>op-holidays Shortcode
Corresponds to the Holidays Widget.  
The **[op-holidays]** shortcode displays all holidays in the specified set in a table or list.  
The following attributes are available (Also mind the **[Common Attributes](#common-attributes)**):

<table>
	<header>
		<div width="25%">Name</div>
		<div width="15%">Type</div>
		<div width="15%">Default</div>
		<div width="45%">Description</div>
	</header>
	<div class="row">
		<div>
			<td><code>highlight</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Whether to highlight currently active holidays</div>
		</div>
		<div>
			<td><code>include_past</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Whether to include past holidays</div>
		</div>
		<div>
			<td><code>class_holiday</code></div>
			<td><code>string</code></div>
			<td><code>op-holiday</code></div>
			<td>CSS class for a single holiday</div>
		</div>
		<div>
			<td><code>class_highlighted</code></div>
			<td><code>string</code></div>
			<td><code>highlighted</code></div>
			<td>CSS class for highlighted holidays</div>
		</div>
		<div>
			<td><code>date_format</code></div>
			<td><code>string</code></div>
			<td>WordPress setting</div>
			<td>PHP date format for the start and end date of the holidays. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
		<div>
			<td><code>template</code></div>
			<td><code>string</code></div>
			<td><code>table</code></div>
			<td>Identifier for the template to use. Possible values are <code>table</code> and <code>list</code></div>
		</div>
	</div>
</section>

### <a name="op-irregular-openings-shortcode"></a>op-irregular-openings Shortcode
Corresponds to the Irregular Openings Widget.  
The **[op-irregular-openings]** shortcode displays all irregular openings in the specified set in a table or list.  
The following attributes are available (Also mind the **[Common Attributes](#common-attributes)**):

<table>
	<header>
		<div width="25%">Name</div>
		<div width="15%">Type</div>
		<div width="15%">Default</div>
		<div width="45%">Description</div>
	</header>
	<div class="row">
		<div>
			<td><code>highlight</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Whether to highlight currently active irregular openings.</div>
		</div>
		<div>
			<td><code>include_past</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>Whether to include past irregular openings</div>
		</div>
		<div>
			<td><code>class_highlighted</code></div>
			<td><code>string</code></div>
			<td><code>highlighted</code></div>
			<td>CSS class for highlighted irregular openings</div>
		</div>
		<div>
			<td><code>date_format</code></div>
			<td><code>string</code></div>
			<td>WordPress setting</div>
			<td>PHP date format for the date of the irregular openings. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
		<div>
			<td><code>time_format</code></div>
			<td><code>string</code></div>
			<td>WordPress setting</div>
			<td>PHP date format for the start and end time of the irregular openings. <a href="http://bit.ly/16Wsegh" target="_blank">More on PHP date and time formats</a></div>
		</div>
		<div>
			<td><code>template</code></div>
			<td><code>string</code></div>
			<td><code>table</code></div>
			<td>Identifier for the template to use. Possible values are <code>table</code> and <code>list</code></div>
		</div>
	</div>
</section>

### <a name="op-schema-shortcode"></a>op-schema Shortcode
Corresponds to the Schema.org Widget.  
The **[op-schema]** shortcode adds a JSON-LD record to the WordPress site representing the opening hours of a given Set. [Refer to the docs on Schema.org integration](doc/schema-org.md) for more information.    
The following attributes are available (**This shortcode does not process the [Common Attributes](#common-attributes)**):

<table>
	<header>
		<div width="25%">Name</div>
		<div width="15%">Type</div>
		<div width="15%">Default</div>
		<div width="45%">Description</div>
	</header>
	<div class="row">
		<div>
			<td><code>set_id</code></div>
			<td><code>number|string</code></div>
			<td>none</div>
			<td>The Set id or Set alias of the set</div>
		</div>
		<div>
			<td><code>exclude_holidays</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>When enabled, holidays are not considered for <code>specialOpeningHoursSpecification</code></div>
		</div>
		<div>
			<td><code>exclude_irregular_openings</code></div>
			<td><code>bool</code></div>
			<td><code>false</code></div>
			<td>When enabled, irregular openings are not considered for <code>specialOpeningHoursSpecification</code></div>
		</div>
		<div>
			<td><code>schema_attr_type</code></div>
			<td><code>string</code></div>
			<td><code>Place</code></div>
			<td>The <code>@type</code> property of the schema.org object.</div>
		</div>
		<div>
			<td><code>schema_attr_name</code></div>
			<td><code>string</code></div>
			<td>Name of the seleted Set</div>
			<td>The <code>name</code> property of the schema.org object.</div>
		</div>
		<div>
			<td><code>schema_attr_description</code></div>
			<td><code>string</code></div>
			<td>Description of the selected Set</div>
			<td>The <code>name</code> property of the schema.org object.</div>
		</div>
	</div>
</section>

[↑ Table of Contents](#contents)

## <a name="troubleshooting"></a>Troubleshooting / FAQ
### Where can I set the standard date and time formats?
If you worked with previous verions of the Plugin you may miss the settings page. The new version of the Plugin uses your WordPress setting you can set under **Settings > General**  
Furthermore you may also set your custom date and time formates per Widget / Shortcode.

### The Is Open Widget / Shortcode does not work properly
The calculation of the Is Open status depends on the Timezone setting in WordPress. Please double check your Timezone setting under **Settings > General** before opening an issue.

### How can I change the styling of the widgets / shortcodes?
The Plugin provides very minimal styling, which is the red and green colors for the open / closed messages. All other kind of styling is left to the WordPress Theme you are using or your custom CSS.
To disable the styling of the text color the [`op_use_front_end_styles`](https://github.com/oh-opening-hours/oh-opening-hours/blob/master/doc/filters.md#op_use_front_end_styles) filter hook can be used.

[↑ Table of Contents](#contents)

## <a name="contributing"></a>Contributing
### <a name="contributing-to-code"></a>Contribute to Code

The development of the Opening Hours Plugin takes place at [GitHub](https://github.com/oh-opening-hours/oh-opening-hours).  
If you want to contribute feel free to fork the repository and send pull requests.

[↑ Table of Contents](#contents)

## <a name="changelog"></a>Changelog

### v1.0.0

initial version
* fix security issues
* improvements

[↑ Table of Contents](#contents)

## <a name="credits"></a> Credits
O/H - Opening Hours is based on the original plugin by [Jannik Portz](https://github.com/janizde/WP-Opening-Hours).

## <a name="license"></a>License
Copyright &copy; 2016 Jannik Portz

This program is free software: you can redistribute it and/or modify  
it under the terms of the GNU General Public License as published by  
the Free Software Foundation, either version 3 of the License, or  
(at your option) any later version.

This program is distributed in the hope that it will be useful,  
but WITHOUT ANY WARRANTY; without even the implied warranty of  
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the  
GNU General Public License for more details.

You should have received a copy of the GNU General Public License  
along with this program.  If not, see <http://www.gnu.org/licenses/>.

[↑ Table of Contents](#contents)
