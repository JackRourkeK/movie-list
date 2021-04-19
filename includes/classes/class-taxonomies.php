<?php
/**
 * Taxonomy Class
 *
 * @package MovieList/includes/classes/taxonomies.php
 */

namespace includes\classes;

defined( 'ABSPATH' ) || exit;

/**
 * Taxonomy Class to Generate Taxonomy for Movie Type
 */
class Taxonomies {

	/**
	 * Initialization of function to generate taxonomies.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'generate_movie_type_taxonomies' ), 0 );
	}
	/**
	 * Function to generate taxonomies
	 */
	public function generate_movie_type_taxonomies() {
		$labels = array(
			'name'               => _x( 'Movie Types', 'Taxonomy General Name', 'movie-type' ),
			'singular_name'      => _x( 'Movie Type', 'Taxonomy Singular Name', 'movie-type' ),
			'search_items'       => __( 'Search Movie Types', 'movie-type' ),
			'not_found'          => __( 'No Movie Types found' ),
			'not_found_in_trash' => __( 'No Movie Types found in the Trash' ),
			'all_items'          => __( 'All Movie Types', 'movie-type' ),
			'edit_item'          => __( 'Edit Movie Type', 'movie-type' ),
			'update_item'        => __( 'Update Movie Type' ),
			'add_new_item'       => __( 'Add New Movie Type' ),
			'new_item_name'      => __( 'New Movie Type' ),
			'menu_name'          => __( 'Movie Type' ),
		);
		$args   = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'show_ui'      => true,
			'show_in_rest' => true,
		);
		register_taxonomy( 'movie_type', 'movie-type', $args );
	}
}
