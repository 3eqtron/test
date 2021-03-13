<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Zubin
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>
	<div class="post-wrapper hentry-inner">
		<div class="post-thumbnail">
			<?php if( has_post_thumbnail() ) : ?>
				<?php if ( is_sticky() ) { ?>
					<span class="sticky-post">
						<span><?php esc_html_e( 'Featured', 'zubin' ); ?></span>
					</span>				
				<?php }

				zubin_posted_on(); 
			?>

			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_post_thumbnail(); ?>
			</a>
			<?php endif; ?>
		</div>

		<div class="entry-container">
			<header class="entry-header">
				<?php if( ! has_post_thumbnail() ) { ?>
					<?php if ( is_sticky() ) { ?>
						<span class="sticky-post">
							<span><?php esc_html_e( 'Featured', 'zubin' ); ?></span>
						</span>
					<?php } ?>
				<?php } ?>
								
				<div class="entry-meta">
					<?php zubin_cat_list(); ?>
				</div><!-- .entry-meta -->

				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;?>

				<?php if ( ! has_post_thumbnail() ) : ?>
				<div class="entry-meta">
					<?php 
						zubin_by_line();
					?>					
					<?php 
						if( ! has_post_thumbnail() ) {
							zubin_posted_on(); 
						}
					?>					 	
				</div><!-- .entry-meta -->
				<?php
				endif; ?>
			</header><!-- .entry-header -->

			<div class="entry-summary">
				<?php
					the_excerpt();
				?>
			</div><!-- .entry-summary -->
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article><!-- #post-<?php the_ID(); ?> -->
