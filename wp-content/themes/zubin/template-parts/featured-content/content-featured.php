<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package Zubin
 */
$number        = get_theme_mod( 'zubin_featured_content_number', 3 );
$post_list     = array();
$no_of_post    = 0;

$args = array(
	'post_type'           => 'post',
	'ignore_sticky_posts' => 1, // ignore sticky posts.
);

// Get valid number of posts.
$args['post_type'] = 'featured-content';

for ( $i = 1; $i <= $number; $i++ ) {
	$zubin_post_id = '';

	$zubin_post_id = get_theme_mod( 'zubin_featured_content_cpt_' . $i );

	if ( $zubin_post_id && '' !== $zubin_post_id ) {
		$post_list = array_merge( $post_list, array( $zubin_post_id ) );

		$no_of_post++;
	}
}

$args['post__in'] = $post_list;
$args['orderby']  = 'post__in';

if ( ! $no_of_post ) {
	return;
}

$args['posts_per_page'] = $no_of_post;

$loop = new WP_Query( $args );

while ( $loop->have_posts() ) :

	$loop->the_post();

	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="hentry-inner">
			<?php
			zubin_post_thumbnail( array(666,500) );
			?>

			<div class="entry-container">
				<header class="entry-header">
					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' ); ?>

					<div class="entry-meta">
						<?php 
							zubin_by_line();					
							zubin_posted_on();
						?>					 	
					</div><!-- .entry-meta -->
				</header>
				<?php zubin_content_display( 'excerpt' ); ?>
			</div><!-- .entry-container -->
		</div><!-- .hentry-inner -->
	</article>
<?php
endwhile;

wp_reset_postdata();
