<?php
/**
 * Movie List Class, Include Required Files
 *
 * @package MovieList/includes
 */

namespace MovieList;

use MovieList\Classes\Custom_Posts;
use MovieList\Classes\Custom_Style;
use MovieList\Classes\Short_Code;
use MovieList\CLasses\Taxonomies;

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
	public function __construct() {
		Custom_Style::add_styles();
		Short_Code::generate_shortcode();
		Custom_Posts::init();
		Taxonomies::init();
	}
}
