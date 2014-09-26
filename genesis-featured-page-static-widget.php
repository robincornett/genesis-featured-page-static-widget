<?php
/**
 * Featured Page Widget For Genesis
 * @package GenesisFeaturedPageStaticWidget
 * @author Robin Cornett
 * @license GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: (Better) Genesis Featured Page Widget
 * Description: Widget to Display featured page, intended for sites using a static front page. This replaces the built in Genesis Featured Page widget.
 * Version:     1.0.2
 * Author:      Robin Cornett
 * Author URI:  http://robincornett.com/
 * Text Domain: genesis-featured-page-static-widget
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// if this file is called directly abort
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'widgets_init', 'featuredpagestatic_init', 10 );
function featuredpagestatic_init() {
	if ( ! class_exists( 'Genesis_Featured_Page' ) ) {
		add_action( 'admin_init', 'featuredpagestatic_deactivate' );
		add_action( 'admin_notices', 'featuredpagestatic_notice' );
		return;
	}

}

// Register the widget
add_action( 'widgets_init', 'featuredpagestatic_register_widget', 15 );
function featuredpagestatic_register_widget() {
	unregister_widget( 'Genesis_Featured_Page' );
	register_widget( 'Genesis_Featured_Page_Static_Widget' );
}

function featuredpagestatic_deactivate() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

function featuredpagestatic_notice() {
	echo '<div class="error"><p><strong>(Better) Genesis Featured Page Widget</strong> works only with the Genesis Framework. It has been <strong>deactivated</strong>.</p></div>';
}

require plugin_dir_path( __FILE__ ) . 'includes/class-genesisfeaturedpagestaticwidget.php';
