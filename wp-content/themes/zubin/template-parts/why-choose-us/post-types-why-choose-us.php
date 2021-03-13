<?php
/**
 * The template for displaying why_choose_us items
 *
 * @package Zubin
 */
?>

<?php
$number = get_theme_mod( 'zubin_why_choose_us_number', 4 );

if ( ! $number ) {
	// If number is 0, then this section is disabled
	return;
}

$args = array(
	'ignore_sticky_posts' => 1 // ignore sticky posts
);

$post_list  = array();// list of valid post/page ids

$no_of_post = 0; // for number of posts

$args['post_type'] = 'page';

for ( $i = 1; $i <= $number; $i++ ) {
	$zubin_post_id = '';

	$zubin_post_id = get_theme_mod( 'zubin_why_choose_us_page_' . $i );	

	if ( $zubin_post_id && '' !== $zubin_post_id ) {
		// Polylang Support.
		if ( class_exists( 'Polylang' ) ) {
			$zubin_post_id = pll_get_post( $zubin_post_id, pll_current_language() );
		}

		$post_list = array_merge( $post_list, array( $zubin_post_id ) );

		$no_of_post++;
	}
}

$args['post__in'] = $post_list;
$args['orderby'] = 'post__in';

if ( 0 === $no_of_post ) {
	return;
}

$args['posts_per_page'] = $no_of_post;
$loop     = new WP_Query( $args );


if ( $loop -> have_posts() ) :
	while ( $loop -> have_posts() ) :
		$loop -> the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="hentry-inner">
				<?php zubin_post_thumbnail( 'post-thumbnail', 'html', true, true ); ?>

				<div class="entry-container">
					<header class="entry-header">
						<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' ); ?>
					</header>

					<?php zubin_content_display( 'excerpt' ); ?>
				</div><!-- .entry-container -->
			</div> <!-- .hentry-inner -->
		</article> <!-- .article -->
	<?php
	endwhile;
	wp_reset_postdata();
endif;
