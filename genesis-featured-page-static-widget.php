<?php
/**
 * Featured Page Widget For Genesis
 * @package GenesisFeaturedPageStaticWidget
 * @author Robin Cornett
 * @license GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Featured Page Widget for Genesis sites with Static Home Page
 * Description: Widget to Display featured page. Tweaked to allow for a site using a static home page. This replaces the built in Genesis Featured Page widget.
 * Version:     1.0.0
 * Author:      Robin Cornett
 * Author URI:  http://robincornett.com/
 * Text Domain: genesis-featured-page-static-widget
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
*/

// if this file is called directly abort
if ( ! defined( 'WPINC' ) ) {
	die;
}

 // Register the widget
add_action( 'widgets_init', 'featuredpagestatic_register_widget', 20 );
function featuredpagestatic_register_widget() {
	unregister_widget( 'Genesis_Featured_Page' );
	register_widget( 'Genesis_Featured_Page_Static_Widget' );
}

require plugin_dir_path( __FILE__ ) . 'includes/class-genesisfeaturedpagestaticwidget.php';
