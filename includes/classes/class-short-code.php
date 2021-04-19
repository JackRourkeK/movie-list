<?php
/**
 * ShortCode Class, Creates ShortCode
 *
 * @package MovieList/includes/classes/class-short-code.php
 */

namespace includes\classes;

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

				$get_movie_list  = get_posts( $movie_list_args );
				$get_movie_count = count( get_posts( array( 'post_type' => 'movie-list' ) ) );

				$result_html = '';

				foreach ( $get_movie_list as $movie_list ) {
					$result_html .= '<div class="entry-content"><h1><a href="' . get_permalink( $movie_list->ID ) . '">'
					. $movie_list->post_title
					. '</h1>'
					. $movie_list->post_name
					. '</a><p>'
					. $movie_list->post_content
					. '</p></div>';

				}
				// Code to Paginate the Movie Lists.
				$max_pages_count = ceil( ( $get_movie_count / $shortcode_parameters['per_page'] ) );

				$big = 9999999999; // need an unlikely integer.

				$result_html .= paginate_links(
					array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => 'pages/%#%',
						'current'   => max( 1, $paged ),
						'total'     => $max_pages_count,
						'prev_next' => __( '« Prev' ),
						'next_text' => __( 'Next »' ),
					)
				);
				return $result_html;
			}
		);
	}
}
