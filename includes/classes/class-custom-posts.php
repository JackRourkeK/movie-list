<?php
/**
 * Custom Post Type Class
 *
 * @package MovieList/includes/classes/custom-post-type.php
 */

namespace includes\classes;

use includes\classes\Custom_Metabox as Custom_MetaBoxes;

defined( 'ABSPATH' ) || exit;

/**
 * Custom Post Type Class
 */
class Custom_Posts {

	/**
	 * Initialization of function to generate custom post.
	 */
	public function __construct() {
		$custom_metabox = new Custom_MetaBoxes();
		add_action( 'init', array( $custom_metabox, 'generate_metaboxes' ) );
		add_action( 'init', array( $this, 'generate_custom_posts' ) );
		add_filter( 'single_template', array( $this, 'single_page_posts' ) );

	}

	/**
	 * Function to Generate Custom Post Type
	 */
	public function generate_custom_posts() {
		$labels = array(
			'name'               => _x( 'Movies List', 'Post Type General Name', 'movies-list' ),
			'singular_name'      => _x( 'Movie', 'Post Type Singular Name', 'movies-list' ),
			'add_new'            => __( 'Add New', 'movie' ),
			'add_new_item'       => __( 'Add New Movie', 'movie-list' ),
			'edit_item'          => __( 'Edit Movie', 'movie-list' ),
			'new_item'           => __( 'New Movie' ),
			'all_items'          => __( 'All Movies' ),
			'view_item'          => __( 'View Movies' ),
			'search_items'       => __( 'Search Movies' ),
			'not_found'          => __( 'No Movies found' ),
			'not_found_in_trash' => __( 'No Movies found in the Trash' ),
			'parent_item_colon'  => __( 'Add Movie' ),
			'menu_name'          => __( 'Movies' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => 'Holds our Movies and Movie specific data',
			'public'             => true,
			'menu_position'      => 5,
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
	public function single_page_posts( $single ) {
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
