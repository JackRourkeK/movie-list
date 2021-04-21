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
	 * Loading required files calling static classes.
	 */
	public static function load_includes() {
		Custom_Style::add_styles();
		Short_Code::generate_shortcode();
		Custom_Posts::init();
		Taxonomies::init();
	}
}
