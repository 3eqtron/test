<?php
/**
 * Display Header Media
 *
 * @package Zubin
 */
?>

<?php
	$header_image = zubin_featured_overall_image();

	if ( 'disable' === $header_image ) {
		// Bail if all header media are disabled.
		return;
	}
?>
<div class="custom-header header-media">
	<div class="wrapper">
		<?php if ( ( is_header_video_active() && has_header_video() ) || 'disable' !== $header_image ) : ?>
		<div class="custom-header-media">
			<?php
			if ( is_header_video_active() && has_header_video() ) {
				the_custom_header_markup();
			} elseif ( $header_image ) {
				echo '<div id="wp-custom-header" class="wp-custom-header"><img src="' . esc_url( $header_image ) . '"/></div>	';
			}
			?>

			<?php zubin_header_media_text(); ?>
		</div>
		<?php endif; ?>

		<?php if( get_theme_mod( 'zubin_header_media_scroll_down', 1 ) &&  is_front_page() ) : ?>
			<a href="#" class="scroll-down"><span class="scroll-icon"></span></a>
		<?php endif; ?>
	</div><!-- .wrapper -->
</div><!-- .custom-header -->
