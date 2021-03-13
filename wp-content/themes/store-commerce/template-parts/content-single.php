<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package shopstore
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array( 'main-post','store-commerce-loop-post' )); ?>>

	<?php
    /**
    * Hook - shopstore_posts_formats_thumbnail.
    *
    * @hooked shopstore_posts_formats_thumbnail - 10
    */
    do_action( 'shopstore_posts_formats_thumbnail' );
    ?>

<div class="content-post store-commerce-blog <?php echo ( !has_post_thumbnail() ) ? 'mt-0': '' ;?>">
   
   <?PHP
    if ( is_singular() ) :
        the_title( '<h3 class="title-post">', '</h1>' );
    else :
        the_title( '<h3 class="title-post"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    endif;
    ?>
    <?php
		if ( 'post' === get_post_type() ) :
			?>
			<ul class="entry-meta meta-post">
				<?php
				shopstore_posted_meta();
				//shopstore_posted_by();
				?>
			</ul><!-- .entry-meta -->
		<?php endif; ?>

    <div class="entry-post entry-content">
     <?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'store-commerce' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'store-commerce' ),
			'after'  => '</div>',
		) );
		?>
    </div>
</div>

</article><!-- #post-<?php the_ID(); ?> -->
