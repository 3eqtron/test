<?php
/**
 * The template used for displaying playlist
 *
 * @package Zubin
 */

$zubin_id = get_theme_mod( 'zubin_sticky_playlist' );

if ( $zubin_id ) {
	$args['page_id'] = absint( $zubin_id );
}

// If $args is empty return false
if ( empty( $args ) ) {
	return;
}

// Create a new WP_Query using the argument previously created
$playlist_query = new WP_Query( $args );
if ( $playlist_query->have_posts() ) :
	while ( $playlist_query->have_posts() ) :
		$playlist_query->the_post();
		?>

		<div id="sticky-playlist-section" class="section">
			<div class="wrapper">
				<div class="section-content-wrapper playlist-wrapper">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-container">
							<div class="entry-content">
								<?php the_content(); ?>
							</div><!-- .entry-content -->
						</div><!-- .entry-container -->
					</article><!-- #post-## -->
				</div><!-- .wrapper -->
			</div><!-- .section-content -->
		</div><!-- #playlist-section -->
	<?php
	endwhile;

	wp_reset_postdata();
endif;
