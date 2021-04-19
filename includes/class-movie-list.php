<?php
/**
 * Movie List Class, Include Required Files
 *
 * @package MovieList/includes
 */

namespace includes;

use includes\classes\Custom_Posts;
use includes\classes\Custom_Style;
use includes\classes\Short_Code;
use includes\classes\Taxonomies;

defined( 'ABSPATH' ) || exit;

/**
 * MovieList class which contains all the functions to include required files.
 */
class Movie_List {
	/**
	 * Initialization of functions to load include files.
	 */
	public function __construct() {
		$this->includes();
		$this->load_includes();
	}

	/**
	 * Includes the required files.
	 */
	protected function includes() {
		include_once BU_PLUGIN_PATH . 'includes/classes/class-short-code.php';
		include_once BU_PLUGIN_PATH . 'includes/classes/class-custom-posts.php';
		include_once BU_PLUGIN_PATH . 'includes/classes/class-taxonomies.php';
		include_once BU_PLUGIN_PATH . 'includes/classes/class-custom-metabox.php';
		include_once BU_PLUGIN_PATH . 'includes/classes/class-custom-style.php';
	}

	/**
	 * Loading required files calling static classes.
	 */
	public function load_includes() {
		Custom_Style::add_styles();
		Short_Code::generate_shortcode();
		new Custom_Posts();
		new Taxonomies();
	}
}
