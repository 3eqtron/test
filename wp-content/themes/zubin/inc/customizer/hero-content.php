<?php
/**
 * Hero Content Options
 *
 * @package Zubin
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zubin_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'zubin_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'zubin' ),
			'panel' => 'zubin_theme_options',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'zubin_sanitize_select',
			'choices'           => zubin_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'zubin' ),
			'section'           => 'zubin_hero_content_options',
			'type'              => 'select',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_hero_content_subtitle',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'zubin_is_hero_content_active',
			'label'             => esc_html__( 'Subtitle', 'zubin' ),
			'section'           => 'zubin_hero_content_options',
			'type'              => 'text',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'zubin_sanitize_post',
			'active_callback'   => 'zubin_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'zubin' ),
			'section'           => 'zubin_hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_hero_content_description',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'zubin_is_hero_content_active',
			'label'             => esc_html__( 'Description', 'zubin' ),
			'section'           => 'zubin_hero_content_options',
			'type'              => 'textarea',
		)
	);
}
add_action( 'customize_register', 'zubin_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'zubin_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since 1.0
	*/
	function zubin_is_hero_content_active( $control ) {
		$enable = $control->manager->get_setting( 'zubin_hero_content_visibility' )->value();

		return zubin_check_section( $enable );
	}
endif;

