<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Zubin
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<div class="archive-posts-wrapper">
		<?php if ( have_posts() ) :
			$zubin_blog_title = get_theme_mod( 'zubin_recent_posts_title', esc_html__( 'From Our Blog', 'zubin' ) );

			if ( $zubin_blog_title ) : ?>
				<div class="section-heading-wrapper">
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo esc_html( $zubin_blog_title ); ?></h2>
					</div><!-- .section-title-wrapper -->
				</div><!-- .section-heading-wrap -->
			<?php endif; ?>

			<?php
			$classes[] = 'layout-one';
			$classes[] = 'boxed-post';

			?>

			<div class="section-content-wrapper <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<div id="infinite-post-wrap" class="archive-post-wrap">
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content/content', get_post_format() );

					endwhile;
					?>
				</div><!-- .archive-post-wrap -->
			</div><!-- .section-content-wrap -->

			<?php zubin_content_nav(); ?>

			<?php
			else :

				get_template_part( 'template-parts/content/content', 'none' );

			endif; ?>
		</div><!-- .archive-post-wrapper -->
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); 
get_footer();
