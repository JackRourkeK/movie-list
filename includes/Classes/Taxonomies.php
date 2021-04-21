<?php
/**
 * Taxonomy Class
 *
 * @package MovieList/includes/classes/taxonomies.php
 */

namespace MovieList\CLasses;

defined( 'ABSPATH' ) || exit;

/**
 * Taxonomy Class to Generate Taxonomy for Movie Type
 */
class Taxonomies {

	/**
	 * Initialization of function to generate taxonomies.
	 */
	public static function init() {
		add_action( 'init', array( self::class, 'generate_movie_type_taxonomies' ), 0 );
	}
	/**
	 * Function to generate taxonomies
	 */
	public static function generate_movie_type_taxonomies() {
		$labels = array(
			'name'               => _x( 'Movie Types', 'Taxonomy General Name', 'movie-list' ),
			'singular_name'      => _x( 'Movie Type', 'Taxonomy Singular Name', 'movie-list' ),
			'search_items'       => esc_html__( 'Search Movie Types', 'movie-list' ),
			'not_found'          => esc_html__( 'No Movie Types found', 'movie-list' ),
			'not_found_in_trash' => esc_html__( 'No Movie Types found in the Trash', 'movie-list' ),
			'all_items'          => esc_html__( 'All Movie Types', 'movie-list' ),
			'edit_item'          => esc_html__( 'Edit Movie Type', 'movie-list' ),
			'update_item'        => esc_html__( 'Update Movie Type', 'movie-list' ),
			'add_new_item'       => esc_html__( 'Add New Movie Type', 'movie-list' ),
			'new_item_name'      => esc_html__( 'New Movie Type', 'movie-list' ),
			'menu_name'          => esc_html__( 'Movie Type', 'movie-list' ),
		);
		$args   = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'show_ui'      => true,
			'show_in_rest' => true,
		);
		register_taxonomy( 'movie_type', 'movie-list', $args );
	}
}
