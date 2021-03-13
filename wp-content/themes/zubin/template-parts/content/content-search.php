<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Zubin
 */				
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-wrapper hentry-inner">
		<div class="post-thumbnail">
			<?php if( has_post_thumbnail() ) {
				zubin_posted_on(); 
			 } ?>
			 <a href="<?php the_permalink(); ?>" rel="bookmark">
			 	<?php the_post_thumbnail(); ?>
			 </a>
		</div>

		<div class="entry-container">
			<header class="entry-header">
<!-- 				<?php if ( 'post' === get_post_type() ) : ?> -->
					<div class="entry-meta">
						<?php zubin_posted_on(); ?>
					</div><!-- .entry-meta -->
				<!-- <?php endif; ?> -->
				
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<div class="entry-meta">
					<?php zubin_by_line(); ?>					
					<?php 
						if( ! has_post_thumbnail() ) {
							zubin_posted_on(); 
						}
					?>					 	
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->

			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article><!-- #post-<?php the_ID(); ?> -->
