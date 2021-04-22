<?php
/**
 * Template Name: Single Page
 *
 * @package MovieList/public/templates/single-movie-list.php
 */

?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
		<a href="<?php echo esc_attr( esc_url( home_url( '/' ) ) ); ?>"><?php echo esc_html__( 'Home Page', 'movie-list' ); ?></a>
			<?php
			while ( have_posts() ) :
				the_post();

				// Details of Single Pages.

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
					$rating_value .= '<br /></div><br /><br />';
				}
				if ( $get_movie_price > 0 ) {
					$movie_price .= '<h3> ' . esc_html__( 'Movie Price', 'movie-list' ) . ' : NRS. <u>' . $get_movie_price . '</u></h3>';
				}
				if ( ! empty( $get_movie_tags ) ) {
					$movie_tags_list .= '<br><strong> ' . esc_html__( 'Movie Tags', 'movie-list' ) . ' : </strong>' . $get_movie_tags_name . '<br />';
				}

				echo wp_kses_post( $movie_price );
				echo wp_kses_post( $movie_tags_list );
				echo wp_kses_post( $rating_value );

				get_template_part( 'content', get_post_format() );

				?>

				<nav class="nav-single">
					<h3 class="assistive-text"><?php esc_html__( 'Post navigation', 'movie-list' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'movie-list' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'movie-list' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // End of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
