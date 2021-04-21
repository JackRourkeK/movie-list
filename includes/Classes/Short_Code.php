<?php
/**
 * ShortCode Class, Creates ShortCode
 *
 * @package MovieList/includes/classes/class-short-code.php
 */

namespace MovieList\Classes;

defined( 'ABSPATH' ) || exit;

/**
 * Short_Code Class
 */
class Short_Code {

	/**
	 * Function to Generate Shortcode which can be used in pages.
	 *
	 * @param mixed $shortcode_parameters for mixed value.
	 */
	public static function generate_shortcode( $shortcode_parameters = null ) {
		add_shortcode(
			'bu_movie_list',
			function ( $shortcode_parameters ) {
				$shortcode_parameters = shortcode_atts( array( 'per_page' => 5 ), $shortcode_parameters );
				$paged                = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$movie_list_args      = array(
					'post_type'      => 'movie-list',
					'posts_per_page' => $shortcode_parameters['per_page'],
					'paged'          => $paged,
				);

				$get_movie_list = get_posts( $movie_list_args );

				$get_movie_count = count( get_posts( array( 'post_type' => 'movie-list' ) ) );

				$result_html = '';

				foreach ( $get_movie_list as $movie_list ) {
					$get_rating_value = get_post_meta( $movie_list->ID, 'movie_rating', true );
					$get_movie_price  = get_post_meta( $movie_list->ID, 'movie_price', true );
					$get_movie_tags   = get_the_terms( $movie_list->ID, 'movie_type' );

					$get_movie_tags_name = implode( ', ', self::get_movie_tags( $get_movie_tags ) );

					$rating_value = '';
					$movie_price  = '';
					$movie_tags   = '';

					if ( $get_rating_value > 0 ) {
						$rating_value .= '<br/>';
						$rating_value .= '<div class="wrapper-star">';
						for ( $i = 1; $i <= $get_rating_value; $i++ ) {
							$rating_value .= '<label for="r1">&#10038;</label>';
						}
						$rating_value .= '<br/></div>';
					}
					if ( $get_movie_price > 0 ) {
						$movie_price .= '<h3> Movie Price: NRs. <u>' . $get_movie_price . '</u></h3>';
					}
					if ( ! empty( $get_movie_tags ) ) {
						$movie_tags .= '<br><strong> Movie Tags: </strong>' . $get_movie_tags_name;
					}
					$result_html .= '<div class="entry-content"><h1><a href="' . get_permalink( $movie_list->ID ) . '">'
					. $movie_list->post_title
					. '</h1></a>'
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
					. $movie_tags
					. ( ( ! empty( $movie_list->post_content ) ) ? '<h3>Movie Details: </h3>' : '' ) . $movie_list->post_content
					. '</p></div>';

				}
				// Code to Paginate the Movie Lists.
				$max_pages_count = ceil( ( $get_movie_count / $shortcode_parameters['per_page'] ) );

				$big = 9999999999; // need an unlikely integer.

				$result_html .= paginate_links(
					array(
						'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'current' => max( 1, $paged ),
						'total'   => $max_pages_count,
					)
				);
				return $result_html;
			}
		);
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
