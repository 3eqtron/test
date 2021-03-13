<?php
/**
 * The template for displaying featured content
 *
 * @package Zubin
 */
?>

<?php
$enable_content = get_theme_mod( 'zubin_featured_content_option', 'disabled' );

if ( ! zubin_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$zubin_title       = get_option( 'featured_content_title', esc_html__( 'Contents', 'zubin' ) );
$zubin_description = get_option( 'featured_content_content' );
$zubin_subtitle    = get_theme_mod( 'zubin_featured_content_subtitle');

$classes[] = 'section featured-content-section';

if( ! $zubin_title && ! $zubin_description && ! $zubin_subtitle ) {
	$classes[] = 'no-section-heading';
}
?>

<div id="featured-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( $zubin_title || $zubin_description || $zubin_subtitle ) : ?>
			<div class="section-heading-wrapper">
				<?php if ( $zubin_subtitle ) : ?>
					<div class="section-subtitle">
						<?php echo esc_html( $zubin_subtitle); ?>
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
			</div><!-- .section-heading-wrap -->
		<?php endif; ?>

		<div class="section-content-wrapper layout-three">
			<?php
				get_template_part( 'template-parts/featured-content/content-featured' );
			?>
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div><!-- #featured-content-section -->
