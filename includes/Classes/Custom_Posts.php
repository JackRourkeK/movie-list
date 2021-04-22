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
		add_filter( 'single_template', array( self::class, 'single_page_content_filter' ) );

	}

	/**
	 * Returns custom styles listed here which is used in front for Single Page.
	 *
	 * @param string $classes ().
	 */
	public static function get_custom_css_single_page( $classes ) {
		$classes = '.entry-header , .featured-media-inner, .post-thumbnail{ display: none !important; };';
		return $classes;
	}


	/**
	 * Change only content for single page post.
	 */
	public static function single_page_content_filter() {
		add_filter( 'wp_get_custom_css', array( self::class, 'get_custom_css_single_page' ) );
		add_filter( 'the_content', array( self::class, 'single_page_post_html' ) );
	}

	/**
	 * Function to Generate Custom Post Type
	 */
	public static function generate_custom_posts() {
		$labels = array(
			'name'               => _x( 'Movies List', 'Post Type General Name', 'movie-list' ),
			'singular_name'      => _x( 'Movie List', 'Post Type Singular Name', 'movie-list' ),
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
	public static function single_page_post_html( $single ) {
		global $post;

		$movie_list = get_post( $post->ID );
		if ( empty( $movie_list ) ) {
			return false;
		}

		$result_html = '';

		$rating_value    = '';
		$movie_price     = '';
		$movie_tags_list = '';

		$get_rating_value = get_post_meta( $post->ID, 'movie_rating', true );
		$get_movie_price  = get_post_meta( $post->ID, 'movie_price', true );
		$get_movie_tags   = get_the_terms( $post->ID, 'movie_type' );

		$movie_tags = array();
		if ( ! empty( $get_movie_tags ) ) {
			foreach ( $get_movie_tags as $movie_tags_value ) {
				$movie_tags[] = $movie_tags_value->name;
			}
		}

		$get_movie_tags_name = implode( ', ', $movie_tags );

		if ( $get_rating_value > 0 ) {
			$rating_value .= '<br />';
			$rating_value .= '<div class="wrapper-star">';
			for ( $i = 1; $i <= $get_rating_value; $i++ ) {
				$rating_value .= '<label for="r1">&#10038;</label>';
			}
			$rating_value .= '<br /></div><br />';
		}
		if ( $get_movie_price > 0 ) {
			$movie_price .= '<h3>' . esc_html__( 'Movie Price', 'movie-list' ) . ': NRS. <u>' . $get_movie_price . '</u></h3>';
		}
		if ( ! empty( $get_movie_tags ) ) {
			$movie_tags_list .= '<strong> ' . esc_html__( 'Movie Tags', 'movie-list' ) . ': </strong>' . $get_movie_tags_name . '';
		}
		$result_html .= '<div class="entry-content"><h1>'
			. $movie_list->post_title
			. '</h1>'
			. $movie_price
			. get_the_post_thumbnail(
				$movie_list->ID,
				'post-thumbnail',
				array(
					'class' => 'movie-img',
					'style' => 'width:100px; height:100px;',
				)
			)
			. $rating_value
			. $movie_tags_list
			. ( ( ! empty( $movie_list->post_content ) ) ? '<h3>' . esc_html__( 'Movie Details', 'movie-list' ) . ': </h3>' : '' ) . $movie_list->post_content;

		$result_html .= '<span class="nav-previous">' . previous_post_link( '%link', ' <span class = "meta-nav"> ' . esc_html__( '&larr;', 'movie-list' ) . ' </span> %title' )
		. '</span><span class="nav-next"' . next_post_link(
			'%link',
			' %title <span class = "meta-nav"> ' . esc_html__( '&rarr;', 'movie-list' )
			. ' </span> '
		) . '</span>';
		$result_html .= '</div>';

		return $result_html;
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
