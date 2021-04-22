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
	 * Adding Styles to Rating Stars by adding action to wp_enqueue scripts
	 */
	public static function add_styles() {
		add_action( 'wp_enqueue_scripts', array( self::class, 'enqueue_custom_front_style' ) );
	}

	/**
	 * Function to register styles and enqueue to front.
	 */
	public static function enqueue_custom_front_style() {
		global $post;
		if ( empty( $post ) ) {
			return false;
		}
		wp_register_style( 'bu_styles', BU_PLUGIN_URL . 'assets/css/style.css', array(), array() );

		if ( ( has_shortcode( $post->post_content, 'bu_movie_list' ) || is_singular( 'movie-list' ) ) && ( is_page() || is_singular( 'movie-list' ) ) ) {
			wp_enqueue_style( 'bu_styles' );
		}
	}
}
