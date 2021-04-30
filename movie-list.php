<?php
/**
 * Plugin Name: Movie List
 *
 * @package MovieList
 * Plugin URI: https://github.com/JackRourkeK/movie-list
 * Description: Movie Listing with Custom Categories and Tags. Listing and Details Page Included.
 * Version: 1.0.0
 * Requires at least: 5.7.1
 * Author: Balram Upadhyay
 * Author URI: https://www.bru.com.np
 * Text Domain: movie-list
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

use MovieList\Movie_List;

/**
 * Code exits if the plugin execution is done by another frameworks or CMS.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Autoloading Files using Composer and Autoloader feature.
 */
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * Defining required constants available throughout the plugin.
 */
if ( ! defined( 'BU_PLUGIN_FILE' ) ) {
	define( 'BU_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'BU_PLUGIN_PATH' ) ) {
	define( 'BU_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'BU_PLUGIN_URL' ) ) {
	define( 'BU_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'BU_PLUGIN_BASENAME' ) ) {
	define( 'BU_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

/**
 * Checks if Movie_List class exists or not, if not, then create an instance of the Movie_List class (Checking for PR New Added and Rebase and Squash).
 */
if ( ! class_exists( 'Movie_List' ) ) {
	Movie_List::instance();
}
