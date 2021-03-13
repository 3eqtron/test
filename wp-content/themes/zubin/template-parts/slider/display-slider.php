<?php
/**
 * The template used for displaying slider
 *
 * @package Zubin
 */
?>
<?php
$enable_slider = get_theme_mod( 'zubin_slider_option', 'disabled' );

if ( ! zubin_check_section( $enable_slider ) ) {
	return;
}
?>

<div id="featured-slider-section" class="featured-slider-section section content-position-right text-align-right style1">
	<div class="wrapper section-content-wrapper feature-slider-wrapper">
		<div class="main-slider owl-carousel">
			<?php
			// Select Slider
				get_template_part( 'template-parts/slider/post-type-slider' );
			?>
		</div><!-- .main-slider -->

		<div class="nav-controls-container">
			<div class="nav-controls">
				<div id='slider-dots' class='owl-dots'>
				</div>

				<div id='slider-nav' class='owl-nav'>
				</div>
			</div><!-- .nav-controls -->
		</div>

		<a href="#" class="scroll-down"><span class="scroll-icon"></span></a>
	</div><!-- .wrapper -->
</div><!-- #feature-slider -->

