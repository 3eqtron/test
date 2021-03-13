<?php
/**
 * The template used for displaying slider
 *
 * @package Zubin
 */

$quantity      = get_theme_mod( 'zubin_slider_number', 2 );
$no_of_post    = 0; // for number of posts
$post_list     = array(); // list of valid post/page ids

$args = array(
	'post_type'           => 'any',
	'ignore_sticky_posts' => 1, // ignore sticky posts
);
//Get valid number of posts
for ( $i = 1; $i <= $quantity; $i++ ) {
	$zubin_post_id = '';

	$zubin_post_id = get_theme_mod( 'zubin_slider_page_' . $i );

	if ( $zubin_post_id && '' !== $zubin_post_id ) {
		$post_list = array_merge( $post_list, array( $zubin_post_id ) );

		$no_of_post++;
	}
}

$args['post__in'] = $post_list;
$args['orderby'] = 'post__in';

if ( ! $no_of_post ) {
	return;
}

$args['posts_per_page'] = $no_of_post;

$loop = new WP_Query( $args );

while ( $loop->have_posts() ) :
	$loop->the_post();

	?>
	<article class="<?php echo esc_attr( 'post post-' . get_the_ID() . ' hentry slides' ); ?>">
		<div class="hentry-inner">
			<?php zubin_post_thumbnail( array(1920,1080), 'html', true, true ); ?>

			<div class="slider-content-wrapper">
				<div class="entry-container">
					<header class="entry-header">
						<?php
						$zubin_title_image = get_theme_mod( 'zubin_slider_title_image_' . ( $loop->current_post  + 1 ) );

						if ( $zubin_title_image ) : ?>
							<div class="slider-logo"><img src="<?php echo esc_url( $zubin_title_image ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>"/>
							</div>
						<?php endif; ?>

						<h2 class="entry-title">
							<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
					</header>

					<?php zubin_content_display( 'excerpt' ); ?>
				</div><!-- .entry-container -->
			</div><!-- .slider-content-wrapper -->
		</div><!-- .hentry-inner -->
	</article><!-- .slides -->
<?php
endwhile;

wp_reset_postdata();
