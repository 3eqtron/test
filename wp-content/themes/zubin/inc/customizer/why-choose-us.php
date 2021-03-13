<?php
/**
 * Why Choose Us options
 *
 * @package Zubin
 */

/**
 * Add why choose us content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zubin_why_choose_us_options( $wp_customize ) {

    $wp_customize->add_section( 'zubin_why_choose_us', array(
			'title' => esc_html__( 'Why Choose Us', 'zubin' ),
			'panel' => 'zubin_theme_options',
		)
	);

	// Add color scheme setting and control.
	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_why_choose_us_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'zubin_sanitize_select',
			'choices'           => zubin_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'zubin' ),
			'section'           => 'zubin_why_choose_us',
			'type'              => 'select',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_why_choose_us_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'zubin_is_why_choose_us_active',
			'label'             => esc_html__( 'Tagline', 'zubin' ),
			'section'           => 'zubin_why_choose_us',
			'type'              => 'text',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_why_choose_us_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'zubin_is_why_choose_us_active',
			'label'             => esc_html__( 'Title', 'zubin' ),
			'section'           => 'zubin_why_choose_us',
			'type'              => 'text',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_why_choose_us_description',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'zubin_is_why_choose_us_active',
			'label'             => esc_html__( 'Description', 'zubin' ),
			'section'           => 'zubin_why_choose_us',
			'type'              => 'textarea',
		)
	);

    zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_why_choose_us_number',
			'default'           => 3,
			'sanitize_callback' => 'zubin_sanitize_number_range',
			'active_callback'   => 'zubin_is_why_choose_us_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Items is changed', 'zubin' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of Items', 'zubin' ),
			'section'           => 'zubin_why_choose_us',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	$number = get_theme_mod( 'zubin_why_choose_us_number', 3 );

	//loop for why choose us post content
	for ( $i = 1; $i <= $number ; $i++ ) {

		zubin_register_option( $wp_customize, array(
				'name'              => 'zubin_why_choose_us_page_' . $i,
				'sanitize_callback' => 'zubin_sanitize_post',
				'active_callback'   => 'zubin_is_why_choose_us_active',
				'label'             => esc_html__( 'Why Choose Us Page', 'zubin' ) . ' ' . $i ,
				'section'           => 'zubin_why_choose_us',
				'type'              => 'dropdown-pages',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'zubin_why_choose_us_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'zubin_is_why_choose_us_active' ) ) :
	/**
	* Return true if why choose us content is active
	*
	* @since 1.0
	*/
	function zubin_is_why_choose_us_active( $control ) {
		$enable = $control->manager->get_setting( 'zubin_why_choose_us_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( zubin_check_section( $enable ) );
	}
endif;
