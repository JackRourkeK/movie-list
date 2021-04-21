<?php
/**
 * Plugin Name
 *
 * @package MovieList
 * Plugin Name: Movie List
 * Plugin URI: https://github.com/JackRourkeK/movie-list
 * Description: Movie Listing with Custom Categories and Tags. Listing and Details Page Included.
 * Version: 1.0.0
 * Requires at least: 5.7.1
 * Author: Balram Upadhyay
 * Author URI: https://www.bru.com.np
 * Text Domain: movie-list
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace MovieList;

use includes\Movie_List;

// Code exits if the plugin execution is done by another frameworks or CMS.
defined( 'ABSPATH' ) || exit;

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

if ( ! class_exists( 'Movie_List' ) ) {
	include BU_PLUGIN_PATH . 'includes/class-movie-list.php';
	new Movie_List();
}
