<?php
/**
 * The template for displaying service posts on the front page
 *
 * @package Zubin
 */

$number     = get_theme_mod( 'zubin_service_number', 4 );
$post_list  = array();
$no_of_post = 0;

$args = array(
	'post_type'           => 'post',
	'ignore_sticky_posts' => 1, // ignore sticky posts.
);

// Get valid number of posts.
$args['post_type'] = 'ect-service';

for ( $i = 1; $i <= $number; $i++ ) {
	$zubin_post_id = '';

	$zubin_post_id = get_theme_mod( 'zubin_service_cpt_' . $i );

	if ( $zubin_post_id ) {
		$post_list = array_merge( $post_list, array( $zubin_post_id ) );

		$no_of_post++;
	}
}

$args['post__in'] = $post_list;
$args['orderby']  = 'post__in';

$args['posts_per_page'] = $no_of_post;

if ( ! $no_of_post ) {
	return;
}

$loop = new WP_Query( $args );

while ( $loop->have_posts() ) :

	$loop->the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="hentry-inner">
			<?php 

			if ( $media_id = get_post_meta( $post->ID, 'ect-alt-featured-image', true ) ) {
					$title_attribute = the_title_attribute( 'echo=0' ); 
					// Get alternate thumbnail from CPT meta.
					?> <div class="post-thumbnail">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php echo wp_get_attachment_image( $media_id, array(100,100), false,  array( 'title' => $title_attribute, 'alt' => $title_attribute ) ); ?> 
							</a>
						</div> <?php
				} elseif ( has_post_thumbnail() ) { 
			   		zubin_post_thumbnail( array(100,100), 'html', true, false );
				}

			?>

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
