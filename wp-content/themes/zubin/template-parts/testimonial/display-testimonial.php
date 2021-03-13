<?php
/**
 * The template for displaying testimonial items
 *
 * @package Zubin
 */
?>

<?php
$enable = get_theme_mod( 'zubin_testimonial_option', 'disabled' );

if ( ! zubin_check_section( $enable ) ) {
	// Bail if featured content is disabled
	return;
}

$zubin_subtitle = get_theme_mod( 'zubin_testimonial_subtitle' );

// Get Jetpack options for testimonial.
$jetpack_defaults = array(
	'page-title' => esc_html__( 'Testimonials', 'zubin' ),
);

// Get Jetpack options for testimonial.
$jetpack_options = get_theme_mod( 'jetpack_testimonials', $jetpack_defaults );

$zubin_title    = isset( $jetpack_options['page-title'] ) ? $jetpack_options['page-title'] : esc_html__( 'Testimonials', 'zubin' );
$zubin_description = isset( $jetpack_options['page-content'] ) ? $jetpack_options['page-content'] : '';


if ( ! $zubin_title && ! $zubin_description && ! $zubin_subtitle ) {
	$classes[] = 'no-section-heading';
}
?>

<div id="testimonial-content-section" class="section testimonial-content-section style1 layout-one">

	<div class="half-background"></div>
	<div class="wrapper">

			<?php if ( $zubin_title || $zubin_description || $zubin_subtitle ) : ?>
				<div class="section-heading-wrapper">

				<?php if( $zubin_subtitle ) : ?>
					<div class="section-subtitle">
						<?php echo esc_html( $zubin_subtitle ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $zubin_title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $zubin_title ); ?></h2>
					</div><!-- .section-title-wrapper -->
				<?php endif; ?>

				<?php if ( $zubin_description ) : ?>
					<div class="section-description">
						<p>
							<?php
								echo wp_kses_post( $zubin_description );
							?>
						</p>
					</div><!-- .section-description-wrapper -->
				<?php endif; ?>
				</div><!-- .section-heading-wrapper -->
			<?php endif; ?>

			<div class="section-content-wrapper testimonial-content-wrapper testimonial-slider owl-carousel">
				<?php get_template_part( 'template-parts/testimonial/post-types-testimonial' ); ?>
			</div><!-- .section-content-wrapper -->
	</div><!-- .wrapper -->
</div><!-- .testimonial-content-section -->
