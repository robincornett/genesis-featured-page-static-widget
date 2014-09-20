# Featured Page Widget for Genesis Sites with Static Home Page

This plugin works within the Genesis Framework. It replaces the default Genesis Featured Page widget.

## Description

This plugin is a very slightly modified version of the Genesis Featured Page Widget. For sites using a static front page plus a posts page, this plugin will allow you to display your posts page in the widget. Due to how WordPress handles this page, I've added a new option to "Show Blog Page Content(full)". If you have selected the posts page to show in your widget, you can opt for the widget to show either the actual content of the posts/blog page, or show the full/limited content from the first post. Some caveats:
* It's one or the other--either the content from the posts/blog page, or the full/limited content from the first post.
* Currently there is no way to show limited content from the posts/blog page. All or nothing.
* The More Text option is not available if you choose Show Blog Page Content (full).
* If you choose Show Page Content with a limit and More Text, the link will go to the post, not the posts/blog page. The Page Title will link to the posts/blog page.

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

## Credits

* Built by [Robin Cornett](http://robincornett.com/)

## Changelog

###1.0.0
* Initial release on Github