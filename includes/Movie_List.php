<?php
/**
 * Movie List Class, Include Required Files
 *
 * @package MovieList/includes
 */

namespace MovieList;

use MovieList\Classes\Custom_Posts as CustomPosts;
use MovieList\Classes\Custom_Style as CustomStyle;
use MovieList\Classes\LoadTextDomain as TextDomain;
use MovieList\Classes\Short_Code as ShortCode;
use MovieList\CLasses\Taxonomies as Taxonomies;

defined( 'ABSPATH' ) || exit;

/**
 * MovieList class which contains all the functions to include required files.
 */
class Movie_List {

	/**
	 * Single instance of the class.
	 *
	 * @var $instance
	 */
	protected static $instance;

	/**
	 * Instance class instance for main plugin.
	 *
	 * Makes sure that single instance of the plugin is loading or can be loaded.
	 */
	final public static function instance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Loading required files calling static classes.
	 */
	private function __construct() {
		CustomStyle::add_styles();
		ShortCode::generate_shortcode();
		CustomPosts::init();
		Taxonomies::init();
		TextDomain::init();
	}
}
