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
		$screen_to_show = array( 'post', 'movie-list' );
		foreach ( $screen_to_show as $screens ) {
			add_meta_box(
				'movie_price_id',
				'Movie Details',
				array( self::class, 'box_html_field' ),
				$screen_to_show
			);
		}
	}

	/**
	 * Function to save the metabox into the database
	 *
	 * @param int $post_id to save the metabox for given post id.
	 */
	public static function save( int $post_id ) {
		$movie_price  = ( isset( $_POST['movie_price'] ) && ! empty( $_POST['movie_price'] ) ) ? sanitize_text_field(
			wp_unslash( $_POST['movie_price'] )
		) : 0;
		$movie_rating = ( isset( $_POST['movie_rating'] ) && ! empty( $_POST['movie_rating'] ) ) ? sanitize_text_field(
			wp_unslash( $_POST['movie_rating'] )
		) : 0;

		self::update_movie_list_fields( $post_id, 'movie_price', $movie_price );
		self::update_movie_list_fields( $post_id, 'movie_rating', $movie_rating );
	}

	/**
	 * Update Movie List Fields
	 *
	 * @param int    $post_id (Post ID ).
	 * @param string $field_name (Field which we have to update).
	 * @param mixed  $field_value (Value to update).
	 */
	private static function update_movie_list_fields( $post_id, $field_name, $field_value ) {
		if ( array_key_exists( $field_name, $_POST ) ) {
			update_post_meta(
				$post_id,
				$field_name,
				$field_value
			);
		}
	}

	/**
	 * Function to show the HTML Field for Movie Price Metabox
	 *
	 * @param mixed $post (Get the value from post).
	 */
	public static function box_html_field( $post ) {
		$box_html  = '';
		$box_html .= '<label for="movie_price">Movie Price: </label>';
		$box_html .= '<input type="text" id="movie_price" name="movie_price" placeholder="Enter Movie Price" value="' . esc_attr( get_post_meta( get_the_ID(), 'movie_price', true ) ) . '">';
		$box_html .= ' <label for="movie_rating">Movie Rating: </label>';
		$box_html .= '<input type="number" id="movie_rating" min="1" max="5" name="movie_rating" placeholder="Enter Rating" value="' . esc_attr( get_post_meta( get_the_ID(), 'movie_rating', true ) ) . '">';
		echo $box_html;
	}
}
