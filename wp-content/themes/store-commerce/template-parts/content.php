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

	<?php
    if ( 'post' === get_post_type() ) :
    ?>
    <ul class="entry-meta meta-post">
        <?php
        store_commerce_posted_meta();
        ?>
    </ul><!-- .entry-meta -->
    <?php endif; ?>
        
   <?PHP
    if ( is_singular() ) :
        the_title( '<h3 class="title-post">', '</h1>' );
    else :
        the_title( '<h3 class="title-post"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    endif;
    ?>
   		

    <div class="entry-post entry-content">
      <?php 
		/**
		* Hook - shopstore_blog_loop_content_type.
		*
		* @hooked shopstore_blog_loop_content_type - 10
		*/
		do_action( 'shopstore_blog_loop_content_type' );
	  
	  ?>
      
    </div>
</div>

</article><!-- #post-<?php the_ID(); ?> -->
