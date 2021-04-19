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
					$get_rating_value = get_post_meta( $movie_list->ID, 'movie_rating', true );
					$rating_value     = '';
					$rating_value    .= '<div class="wrapper-star">
					<input type="radio" id="r1" name="rg1"><label for="r1">&#10038;</label>
					<input type="radio" id="r2" name="rg1"><label for="r2">&#10038;</label>
					<input type="radio" id="r3" name="rg1"><label for="r3">&#10038;</label>
					<input type="radio" id="r4" name="rg1"><label for="r4">&#10038;</label>
					<input type="radio" id="r5" name="rg1"><label for="r5">&#10038;</label></div>';
					// $rating_value .= '<input type="radio" id="rating-' . get_post_meta( $movie_list->ID, 'movie_rating', true ) . '" name="rating" value="' . get_post_meta( $movie_list->ID, 'movie_rating', true ) . '" /><label for="rating-' . get_post_meta( $movie_list->ID, 'movie_rating', true ) . '">' . get_post_meta( $movie_list->ID, 'movie_rating', true ) . '</label>';
					$result_html .= '<div class="entry-content"><h1><a href="' . get_permalink( $movie_list->ID ) . '">'
					. $movie_list->post_title
					. '</h1></a>'
					. '<h3> Movie Price: NRs. <u>'
					. get_post_meta( $movie_list->ID, 'movie_price', true ) . '</u></h3>'
					. $rating_value . '<br>'
					. get_the_post_thumbnail(
						$movie_list->ID,
						'post-thumbnail',
						array(
							'class' => 'movie-img',
							'style' => 'width:100px; height:100px;',
						)
					)
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
