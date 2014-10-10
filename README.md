# (Better) Genesis Featured Page Widget

This plugin works within the Genesis Framework. It replaces the default Genesis Featured Page widget.

## Description

This plugin is a very slightly modified version of the Genesis Featured Page Widget. For sites using a static _Front Page_ plus a _Posts Page_, this plugin will allow you to display your posts page in the widget. If you select the posts/blog page to show in the Featured Page widget, the output will work this way:

* if the posts page has no content of its own, the title and content of the first page shall be used for output.
* if the posts page has content of its own, even if it doesn't show on the page itself, the title and content of the posts page shall be used for output.

_For standard pages, the behavior of the Featured Page widget is unchanged._


## Requirements
* WordPress 3.8, tested up to 4.0
* the Genesis Framework

## Installation

### Upload

1. Download the latest tagged archive (choose the "zip" option).
2. Go to the __Plugins -> Add New__ screen and click the __Upload__ tab.
3. Upload the zipped archive directly.
4. Go to the Plugins screen and click __Activate__.

### Manual

1. Download the latest tagged archive (choose the "zip" option).
2. Unzip the archive.
3. Copy the folder to your `/wp-content/plugins/` directory.
4. Go to the Plugins screen and click __Activate__.

Check out the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

### Git

Using git, browse to your `/wp-content/plugins/` directory and clone this repository:

`git clone git@github.com:robincornett/genesis-featured-page-static-widget.git`

Then go to your Plugins screen and click __Activate__.

## Frequently Asked Questions

### How do I show the title/content on my posts/blog page?

Create a home.php file with [this code](https://gist.github.com/robincornett/cca2a45f273b35399bd2) in it and upload it to your theme directory.

## Credits

* Built by [Robin Cornett](http://robincornett.com/)

## Changelog

###1.0.3
* corrected image link if widget is not for home page
* tightened logic to test against page_id instead of is_home()

###1.0.2
* plugin now deactivates if Genesis isn't the active theme.

###1.0.1
* Title/content output is now conditional on existence of Posts Page content
* confusing new option is removed from widget input

###1.0.0
* Initial release on Github