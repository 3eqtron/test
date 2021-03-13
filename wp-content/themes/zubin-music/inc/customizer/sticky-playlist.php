<?php
/**
 * Playlist Options
 *
 * @package Zubin_Music
 */

/**
 * Add sticky_playlist options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zubin_music_sticky_playlist( $wp_customize ) {
	$wp_customize->add_section( 'zubin_sticky_playlist', array(
			'title' => esc_html__( 'Sticky Playlist', 'zubin-music' ),
			'panel' => 'zubin_theme_options',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_sticky_playlist_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'zubin_sanitize_select',
			'choices'           => zubin_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'zubin-music' ),
			'section'           => 'zubin_sticky_playlist',
			'type'              => 'select',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_sticky_playlist',
			'default'           => '0',
			'sanitize_callback' => 'zubin_sanitize_post',
			'active_callback'   => 'zubin_music_is_sticky_playlist_active',
			'label'             => esc_html__( 'Page', 'zubin-music' ),
			'section'           => 'zubin_sticky_playlist',
			'type'              => 'dropdown-pages',
		)
	);
}
add_action( 'customize_register', 'zubin_music_sticky_playlist', 12 );

/** Active Callback Functions **/
if ( ! function_exists( 'zubin_music_is_sticky_playlist_active' ) ) :
	/**
	* Return true if sticky_playlist is active
	*
	* @since 1.0
	*/
	function zubin_music_is_sticky_playlist_active( $control ) {
		$enable = $control->manager->get_setting( 'zubin_sticky_playlist_visibility' )->value();

		return zubin_check_section( $enable );
	}
endif;
