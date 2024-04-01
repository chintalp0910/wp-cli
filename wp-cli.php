<?php
/**
 * Plugin Name: WP CLI
 * Plugin URI: https://github.com/chintalp0910
 * Description: WP CLI custom command
 * Version: 1.0.0
 * Author: ChintalP
 * Author URI: https://github.com/chintalp0910
 * Text Domain: wpcli
 * Domain Path: /languages/
 *
 * @package WP CLI
 */

/**
 *  Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Basic plugin definitions
 *
 * @package WP CLI
 * @since 1.0.0
 */
if ( ! defined( 'WPCLI_DIR' ) ) {
	define( 'WPCLI_DIR', dirname( __FILE__ ) );   // Plugin dir.
}
if ( ! defined( 'WPCLI_VERSION' ) ) {
	define( 'WPCLI_VERSION', '1.0.0' );  // Plugin Version.
}
if ( ! defined( 'WPCLI_URL' ) ) {
	define( 'WPCLI_URL', plugin_dir_url( __FILE__ ) );  // Plugin url.
}
if ( ! defined( 'WPCLI_INC_DIR' ) ) {
	define( 'WPCLI_INC_DIR', WPCLI_DIR . '/includes' );   // Plugin include dir.
}
if ( ! defined( 'WPCLI_INC_URL' ) ) {
	define( 'WPCLI_INC_URL', WPCLI_URL . 'includes' );    // Plugin include url.
}
if ( ! defined( 'WPCLI_PLUGIN_BASENAME' ) ) {
	define( 'WPCLI_PLUGIN_BASENAME', basename( WPCLI_DIR ) ); // Plugin base name.
}

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package WP CLI
 * @since 1.0.0
 */
/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package WP Custom Post Type
 * @since 1.0.0
 */
function wpcli_load_textdomain() {

	// Set filter for plugin's languages directory.
	$wpcli_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$wpcli_lang_dir = apply_filters( 'wpcli_languages_directory', $wpcli_lang_dir );

	// Traditional WordPress plugin locale filter.
	$locale = apply_filters( 'plugin_locale', get_locale(), 'wpcli' );
	$mofile = sprintf( '%1$s-%2$s.mo', 'wpcli', $locale );

	// Setup paths to current locale file.
	$mofile_local  = $wpcli_lang_dir . $mofile;
	$mofile_global = WP_LANG_DIR . '/' . WPCLI_PLUGIN_BASENAME . '/' . $mofile;

	if ( file_exists( $mofile_global ) ) {
		load_textdomain( 'wpcli', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) {
		load_textdomain( 'wpcli', $mofile_local );
	} else { // Load the default language files.
		load_plugin_textdomain( 'wpcli', false, $wpcli_lang_dir );
	}

}
/**
 * Plugin Setup Activation hook call back
 *
 * Initial setup of the plugin setting default options
 * and database tables creations.
 *
 * @package WP CLI
 * @since 1.0.0
 */
function wpcli_install() {

	global $wpdb;
}

/**
 * Plugin Setup (On Deactivation)
 *
 * Does the drop tables in the database and
 * delete  plugin options.
 *
 * @package WP CLI
 * @since 1.0.0
 */
function wpcli_uninstall() {

	global $wpdb;
}

/**
 * Load Plugin
 *
 * Handles to load plugin after
 * dependent plugin is loaded
 * successfully
 *
 * @package WP CLI
 * @since 1.0.0
 */
function wpcli_plugin_loaded() {

	// load first plugin text domain.
	wpcli_load_textdomain();
}

// add action to load plugin.
add_action( 'plugins_loaded', 'wpcli_plugin_loaded' );

// Global variables.
global $wpcli_public;

// Public class handles most of public functionalities of plugin.
require_once WPCLI_INC_DIR . '/class-wpcli-public.php';
$wpcli_public = new Wpcli_Public();
$wpcli_public->add_hooks();
