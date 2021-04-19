<?php
/**
 * Custom MetaBox Class, Creates Metabox
 *
 * @package MovieList/includes/classes/class-metabox.php
 */

namespace includes\classes;

defined( 'ABSPATH' ) || exit;

/**
 * Metabox Class
 */
class Custom_Metabox {

	/**
	 * Initialization of Custom Metabox and Save post.
	 */
	public function generate_metaboxes() {
		add_action( 'add_meta_boxes', array( self::class, 'add' ) );
		add_action( 'save_post', array( self::class, 'save' ) );
	}

	/**
	 * Function to add metabox to the mentioned post type (post, movie-list and so on).
	 */
	public static function add() {
		$to_show = array( 'post', 'movie-list' );
		foreach ( $to_show as $screens ) {
			add_meta_box(
				'movie_price_id',
				'Movie Details',
				array( self::class, 'box_html_field' ),
				$to_show
			);
		}
	}

	/**
	 * Function to save the metabox into the database
	 *
	 * @param int $post_id to save the metabox for given post id.
	 */
	public static function save( int $post_id ) {
		if ( array_key_exists( 'movie_price', $_POST ) ) {
			update_post_meta(
				$post_id,
				'_movie_price',
				$_POST['movie_price'],
			);
		}
	}

	/**
	 * Function to show the HTML Field for Movie Price Metabox
	 *
	 * @param mixed $post Get the value from post.
	 */
	public static function box_html_field( $post ) {
		wp_nonce_field( BU_PLUGIN_BASENAME, 'movie_price_box_content_nonce' );
		$movie_price_key = get_post_meta( $post->ID, '_movie_price', true );
		$movie_price     = get_terms(
			array(
				'taxonomy' => '_movie_price',
			),
		);
		$box_html        = '';
		$box_html       .= '<label for="movie_price">Movie Price</label>';
		$box_html       .= '<input type="text" id="movie_price" name="movie_price" placeholder="Enter Movie Price" value="' . esc_attr( get_post_meta( get_the_ID(), 'movie_price', true ) ) . '">';
		echo $box_html;
	}
}
