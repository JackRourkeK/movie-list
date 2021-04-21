<?php
/**
 * Custom MetaBox Class, Creates Metabox
 *
 * @package MovieList/includes/classes/class-metabox.php
 */

namespace MovieList\Classes;

defined( 'ABSPATH' ) || exit;

/**
 * Custom Style Class
 */
class Custom_Style {
	/**
	 * Adding Styles to Rating Star
	 */
	public static function add_styles() {
		add_action(
			'init',
			function () {
				wp_enqueue_style( 'bu_styles', BU_PLUGIN_URL . 'public/css/style.css', '1.0', array() );
			}
		);
	}
}
