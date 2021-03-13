<?php
/**
 * Featured Slider Options
 *
 * @package Zubin
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zubin_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'zubin_featured_slider', array(
			'panel' => 'zubin_theme_options',
			'title' => esc_html__( 'Featured Slider', 'zubin' ),
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'zubin_sanitize_select',
			'choices'           => zubin_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'zubin' ),
			'section'           => 'zubin_featured_slider',
			'type'              => 'select',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_slider_number',
			'default'           => '2',
			'sanitize_callback' => 'zubin_sanitize_number_range',

			'active_callback'   => 'zubin_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'zubin' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Slides', 'zubin' ),
			'section'           => 'zubin_featured_slider',
			'type'              => 'number',
		)
	);

	$slider_number = get_theme_mod( 'zubin_slider_number', 2 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {
		zubin_register_option( $wp_customize, array(
				'name'              => 'zubin_slider_note_' . $i,
				'sanitize_callback' => 'sanitize_text_field',
				'custom_control'    => 'Zubin_Note_Control',
				'active_callback'   => 'zubin_is_slider_active',
				'label'             => esc_html__( 'Slide #', 'zubin' ) . $i,
				'section'           => 'zubin_featured_slider',
				'type'              => 'description',
			)
		);

		// Page Sliders
		zubin_register_option( $wp_customize, array(
				'name'              => 'zubin_slider_page_' . $i,
				'sanitize_callback' => 'zubin_sanitize_post',
				'active_callback'   => 'zubin_is_slider_active',
				'label'             => esc_html__( 'Page', 'zubin' ) . ' # ' . $i,
				'section'           => 'zubin_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);

		zubin_register_option( $wp_customize, array(
		        'name'              => 'zubin_slider_title_image_' . $i,
		        'sanitize_callback' => 'zubin_sanitize_image',
		        'custom_control'    => 'WP_Customize_Image_Control',
		        'active_callback'   => 'zubin_is_slider_active',
		        'label'             => esc_html__( 'Title Image', 'zubin' ),
		        'section'           => 'zubin_featured_slider',
		    )
		);
	} // End for().
}
add_action( 'customize_register', 'zubin_slider_options' );

/** Active Callback Functions */

if ( ! function_exists( 'zubin_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since 1.0
	*/
	function zubin_is_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'zubin_slider_option' )->value();

		//return true only if previwed page on customizer matches the type option selected
		return zubin_check_section( $enable );
	}
endif;
