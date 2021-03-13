<?php
/**
 * The template for displaying why choose us content
 *
 * @package Zubin
 */
$enable = get_theme_mod( 'zubin_why_choose_us_option', 'disabled' );

if ( ! zubin_check_section( $enable ) ) {
	// Bail if why choose us content is disabled.
	return;
}

$zubin_subtitle		= get_theme_mod( 'zubin_why_choose_us_sub_title' );
$zubin_title    	= get_theme_mod( 'zubin_why_choose_us_title' );
$zubin_description 	= get_theme_mod( 'zubin_why_choose_us_description' );

$classes = array();
	
if( ! $zubin_title && ! $zubin_description && ! $zubin_subtitle ) {
 	$classes[] = 'no-section-heading';
}

$classes[] = 'modern-style';
$classes[] = 'text-align-left';

?>

<div class="why-choose-us-section section <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( $zubin_subtitle || $zubin_title || $zubin_description ) : ?>
			<div class="section-heading-wrapper">

				<?php if( $zubin_subtitle ) : ?>
					<div class="section-subtitle">
						<?php echo esc_html( $zubin_subtitle ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $zubin_title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"zubin_><?php echo wp_kses_post( $zubin_title ); ?></h2>
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

		<div class="section-content-wrapper">
			<div class="who-choose-us-slider owl-carousel">					
				<?php get_template_part( 'template-parts/why-choose-us/post-types', 'why-choose-us' ); ?>
			</div> <!-- .why-choose-us-slider -->
		</div><!-- .section-content-wrapper -->

		<div id='why-choose-us-dots' class='owl-dots'>
			<?php
				echo '<button class="owl-dot"><span></span></button> ';
			?>
		</div>
	</div><!-- .wrapper -->
</div><!-- #why-choose-us-section -->
