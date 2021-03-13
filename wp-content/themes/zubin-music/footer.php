<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Zubin
 */
?>
	</div><!-- .wrapper -->
</div><!-- #content -->

<footer id="colophon" class="site-footer">

	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<div id="site-generator">
		<?php get_template_part('template-parts/footer/site-info'); ?>
	</div><!-- #site-generator -->
</footer><!-- #colophon -->

<?php get_template_part( 'template-parts/sticky-playlist/content-playlist' ); ?>
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
