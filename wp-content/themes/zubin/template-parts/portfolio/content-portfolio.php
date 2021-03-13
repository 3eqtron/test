<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Zubin
 */

// If not thumbnail, use 920x920 for no thumb image, so this is default.
$thumbnail = array( 920, 920 );

if ( has_post_thumbnail() ) {
	$thumbnail =  'zubin-flexible';
}
?>

<article id="portfolio-post-<?php the_ID(); ?>" <?php post_class( 'grid-item' ); ?>>
	<div class="hentry-inner">
		<?php zubin_post_thumbnail( $thumbnail, 'html', true, true ); ?>

		<div class="entry-container caption">
			<div class="entry-container-inner-wrap">
				<header class="entry-header">
					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
				</header>
			</div><!-- .entry-container-inner-wrap -->
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article>
