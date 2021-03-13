<?php
/**
 * The template for displaying portfolio items
 *
 * @package Zubin
 */
?>

<?php
$enable = get_theme_mod( 'zubin_portfolio_option', 'disabled' );

if ( ! zubin_check_section( $enable ) ) {
	// Bail if portfolio section is disabled.
	return;
}

$zubin_subtitle    = get_theme_mod( 'zubin_portfolio_subtitle' );
$zubin_title       = get_option( 'jetpack_portfolio_title', esc_html__( 'Projects', 'zubin' ) );
$zubin_description = get_option( 'jetpack_portfolio_content' );

if ( ! $zubin_title && ! $zubin_description && ! $zubin_subtitle  ) {
	$classes[] = 'no-section-heading';
}
$classes[] = 'section portfolio-section';
$classes[] = 'section-boxed';

?>

<div id="portfolio-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( '' != $zubin_title || $zubin_description || $zubin_subtitle ) : ?>
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

		<div class="section-content-wrapper layout-two">
			<div class="grid">
				<?php
					get_template_part( 'template-parts/portfolio/post-types', 'portfolio' );
				?>
			</div>
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div><!-- #portfolio-section -->
