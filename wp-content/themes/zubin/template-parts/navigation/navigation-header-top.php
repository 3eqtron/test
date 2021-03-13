<?php
/**
 * Displays Header Top Navigation
 *
 * @package Zubin
 */
?>

<?php if ( has_nav_menu( 'menu-3' ) ) : ?>
	<nav id="site-top-navigation" class="top-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'zubin' ); ?>">
		<?php wp_nav_menu( array(
				'container'      => '',
				'theme_location' => 'menu-3',
				'menu_id'        => 'header-top',
				'menu_class'     => 'top-menu',
			)
		);?>
	</nav><!-- #site-top-navigation -->
<?php endif;
