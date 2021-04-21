<?php
/**
 * Custom Post Type Class
 *
 * @package MovieList/includes/classes/custom-post-type.php
 */

namespace MovieList\Classes;

use MovieList\Classes\Custom_Metabox as MetaBox;

defined( 'ABSPATH' ) || exit;

/**
 * Custom Post Type Class
 */
class Custom_Posts {

	/**
	 * Initialization of function to generate custom post.
	 */
	public static function init() {
		add_action( 'init', array( MetaBox::class, 'generate_metaboxes' ) );
		add_action( 'init', array( self::class, 'generate_custom_posts' ) );
		add_filter( 'single_template', array( self::class, 'single_page_posts' ) );

	}

	/**
	 * Function to Generate Custom Post Type
	 */
	public static function generate_custom_posts() {
		$labels = array(
			'name'               => _x( 'Movies List', 'Post Type General Name', 'movie-list' ),
			'singular_name'      => _x( 'Movie', 'Post Type Singular Name', 'movie-list' ),
			'add_new'            => esc_html__( 'Add New', 'movie-list' ),
			'add_new_item'       => esc_html__( 'Add New Movie', 'movie-list' ),
			'edit_item'          => esc_html__( 'Edit Movie', 'movie-list' ),
			'new_item'           => esc_html__( 'New Movie', 'movie-list' ),
			'all_items'          => esc_html__( 'All Movies', 'movie-list' ),
			'view_item'          => esc_html__( 'View Movies', 'movie-list' ),
			'search_items'       => esc_html__( 'Search Movies', 'movie-list' ),
			'not_found'          => esc_html__( 'No Movies found', 'movie-list' ),
			'not_found_in_trash' => esc_html__( 'No Movies found in the Trash', 'movie-list' ),
			'parent_item_colon'  => esc_html__( 'Add Movie', 'movie-list' ),
			'menu_name'          => esc_html__( 'Movies', 'movie-list' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => esc_html__( 'Holds our Movies and Movie specific data', 'movie-list' ),
			'public'             => true,
			'menu_icon'          => 'dashicons-format-video',
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'         => array( 'movie_type' ),
			'has_archive'        => true,
			'show_in_rest'       => true,
			'publicly_queryable' => true,
			'rewrite'            => array(
				'slug'       => 'movie-list',
				'with_front' => true,
			),
			'query_var'          => true,
		);
		register_post_type( 'movie-list', $args );
	}

	/**
	 * Function to call single page for the movie detail page
	 *
	 * @param mixed $single (Returns single page).
	 */
	public static function single_page_posts( $single ) {
		global $post;
		if ( 'movie-list' === $post->post_type && is_singular( 'movie-list' ) ) {
			if ( file_exists( BU_PLUGIN_PATH . 'public/templates/single-movie-list.php' ) ) {
				return BU_PLUGIN_PATH . 'public/templates/single-movie-list.php';
			}
		}
		return $single;
	}

	/**
	 * Function to Get Movie Tags for Custom Post Type
	 *
	 * @param array $get_movie_tags (Movie Tag results passed and returns result.).
	 */
	private static function get_movie_tags( $get_movie_tags ) {
		$movie_tags = array();
		if ( ! empty( $get_movie_tags ) ) {
			foreach ( $get_movie_tags as $movie_tags_value ) {
				$movie_tags[] = $movie_tags_value->name;
			}
		}
		return $movie_tags;
	}
}
