<?php
/**
 * Primary Menu Template
 *
 * @package Zubin
 */

if ( has_nav_menu( 'social-primary' ) ) :  ?>
	<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Menu', 'zubin' ); ?>">
		<?php
			wp_nav_menu( array(
				'theme_location' 	=> 'social-primary',
				'menu_class'     	=> 'social-links-menu',
				'container'			=> '',
				'depth'          	=> 1,
				'link_before'    	=> '<span class="screen-reader-text">',
			) );
		?>
	</nav><!-- .social-navigation -->
<?php endif; ?>
