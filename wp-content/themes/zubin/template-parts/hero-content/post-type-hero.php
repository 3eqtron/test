<?php
/**
 * The template used for displaying hero content
 *
 * @package Zubin
 */

$zubin_id = get_theme_mod( 'zubin_hero_content' );
$args['page_id'] = absint( $zubin_id );
// If $args is empty return false
if ( empty( $args ) ) {
	return;
}

// Create a new WP_Query using the argument previously created
$hero_query = new WP_Query( $args );
if ( $hero_query->have_posts() ) :
	while ( $hero_query->have_posts() ) :
		$hero_query->the_post();
		?>
		<div id="hero-section" class="hero-section section style1 content-position-right text-align-left">
			<div class="wrapper">
				<div class="section-content-wrapper hero-content-wrapper">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="hentry-inner">
						<?php
						$post_thumbnail = zubin_post_thumbnail( array(666,999), 'html', false );

						if ( $post_thumbnail ) :
							echo $post_thumbnail;
							?>
							<div class="entry-container">
						<?php else : ?>
							<div class="entry-container full-width">
						<?php endif; ?>
							<?php
							$zubin_description = get_theme_mod( 'zubin_hero_content_description' );
							$zubin_subtitle	   = get_theme_mod( 'zubin_hero_content_subtitle' );

							if( $zubin_subtitle ) : ?>
								<div class="section-subtitle">
									<?php echo esc_html( $zubin_subtitle ); ?>
								</div>
							<?php endif; ?>

							<header class="entry-header">
								<h2 class="section-title entry-title">
									<?php the_title(); ?>
								</h2>
							</header><!-- .entry-header -->

							<?php if ( $zubin_description ) : ?>
								<div class="section-description">
									<p>
										<?php
											echo wp_kses_post( $zubin_description );
										?>
									</p>
								</div><!-- .section-description-wrapper -->
							<?php endif; ?>


							<?php zubin_content_display( 'full-content' ); ?>

							<?php if ( get_edit_post_link() ) : ?>
								<footer class="entry-footer">
									<div class="entry-meta">
										<?php
											edit_post_link(
												sprintf(
													/* translators: %s: Name of current post */
													esc_html__( 'Edit %s', 'zubin' ),
													the_title( '<span class="screen-reader-text">"', '"</span>', false )
												),
												'<span class="edit-link">',
												'</span>'
											);
										?>
									</div>	<!-- .entry-meta -->
								</footer><!-- .entry-footer -->
							<?php endif; ?>
						</div><!-- .hentry-inner -->
					</article>
				</div><!-- .section-content-wrapper -->
			</div><!-- .wrapper -->
		</div><!-- .section -->
	<?php
	endwhile;

	wp_reset_postdata();
endif;
