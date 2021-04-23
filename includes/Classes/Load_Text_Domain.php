<?php
/**
 * Custom MetaBox Class, Creates Metabox
 *
 * @package MovieList/includes/classes/class-metabox.php
 */

namespace MovieList\Classes;

defined( 'ABSPATH' ) || exit;

/**
 * Loading Text Domain Class
 */
class Load_Text_Domain {
	/**
	 * Initialize class to load language template
	 */
	public static function init() {

		if ( function_exists( 'determine_locale' ) ) {
			$locale = determine_locale();
		} else {
			// Remove when start supporting WP 5.0 or later.
			$locale = is_admin() ? get_user_locale() : get_locale();
		}
		$locale = apply_filters( 'plugin_locale', $locale, 'movie-list' );

		unload_textdomain( 'movie-list' );
		load_textdomain( 'movie-list', BU_PLUGIN_PATH . '/languages/movie-list-' . $locale . '.mo' );
		load_plugin_textdomain( 'movie-list', false, BU_PLUGIN_PATH . '/languages' );
	}
}
