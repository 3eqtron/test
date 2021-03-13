<?php
/**
 * The template for displaying service content
 *
 * @package Zubin
 */
?>

<?php
$enable_content = get_theme_mod( 'zubin_service_option', 'disabled' );

if ( ! zubin_check_section( $enable_content ) ) {
	// Bail if service content is disabled.
	return;
}

$zubin_title       = get_option( 'ect_service_title', esc_html__( 'Services', 'zubin' ) );
$zubin_description = get_option( 'ect_service_content' );
$zubin_subtitle    = get_theme_mod( 'zubin_service_subtitle' );

if ( ! $zubin_title && ! $zubin_description && ! $zubin_subtitle ) {
	$classes[] = 'no-section-heading';
}
?>

<div id="service-section" class="service-section section text-align-left modern-style">
	<div class="wrapper">
		<?php if (  $zubin_title || $zubin_description || $zubin_subtitle ) : ?>
			<div class="section-heading-wrapper">

				<?php if( $zubin_subtitle ) : ?>
					<div class="section-subtitle">
						<?php echo esc_html( $zubin_subtitle ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $zubin_title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $zubin_title ); ?></h2>
					</div><!-- .page-title-wrapper -->
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

		<div class="section-content-wrapper service-content-wrapper layout-two">
			<?php			
				get_template_part( 'template-parts/service/content-service' );
			?>
		</div><!-- .service-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #service-section -->
