<?php
/**
 * Header Media Options
 *
 * @package Zubin
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zubin_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'zubin' );

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'zubin_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'zubin' ),
				'entire-site'            => esc_html__( 'Entire Site', 'zubin' ),
				'disable'                => esc_html__( 'Disabled', 'zubin' ),
			),
			'label'             => esc_html__( 'Enable on', 'zubin' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	/*Overlay Option for Header Media*/
	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_image_content_max_width',
			'default'           => '480',
			'sanitize_callback' => 'zubin_sanitize_number_range',
			'label'             => esc_html__( 'Container Max-width (480px-1000px)', 'zubin' ),
			'section'           => 'header_image',

			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 65px;',
				'min'   => 480,
				'max'   => 1000,
			),
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_scroll_down',
			'sanitize_callback' => 'zubin_sanitize_checkbox',
			'default'           => 1,
			'label'             => esc_html__( 'Scroll Down Button', 'zubin' ),
			'section'           => 'header_image',
			'custom_control'    => 'Zubin_Toggle_Control',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_logo',
			'sanitize_callback' => 'esc_url_raw',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Header Media Logo', 'zubin' ),
			'section'           => 'header_image',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_logo_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'zubin_sanitize_select',
			'active_callback'   => 'zubin_is_header_media_logo_active',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'zubin' ),
				'entire-site'            => esc_html__( 'Entire Site', 'zubin' ) ),
			'label'             => esc_html__( 'Enable Header Media logo on', 'zubin' ),
			'section'           => 'header_image',
			'type'              => 'select',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_before_subtitle',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Subtitle before Title', 'zubin' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'zubin' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_after_subtitle',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Subtitle after Title', 'zubin' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Site Header Text', 'zubin' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_url',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'zubin' ),
			'section'           => 'header_image',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_media_url_text',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'zubin' ),
			'section'           => 'header_image',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_header_url_target',
			'sanitize_callback' => 'zubin_sanitize_checkbox',
			'label'             => esc_html__( 'Open in New Window/Tab', 'zubin' ),
			'section'           => 'header_image',
			'custom_control'    => 'Zubin_Toggle_Control',
		)
	);
}
add_action( 'customize_register', 'zubin_header_media_options' );

/** Active Callback Functions */

if ( ! function_exists( 'zubin_is_header_media_logo_active' ) ) :
	/**
	* Return true if header logo is active
	*
	* @since 1.0
	*/
	function zubin_is_header_media_logo_active( $control ) {
		$logo = $control->manager->get_setting( 'zubin_header_media_logo' )->value();
		if ( '' != $logo ) {
			return true;
		} else {
			return false;
		}
	}
endif;
