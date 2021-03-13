<?php
/**
 * Add Portfolio Settings in Customizer
 *
 * @package Zubin
 */

/**
 * Add portfolio options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zubin_portfolio_options( $wp_customize ) {
	// Add note to Jetpack Portfolio Section
	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_jetpack_portfolio_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'Zubin_Note_Control',
			'label'             => sprintf( esc_html__( 'For Portfolio Options for Zubin Theme, go %1$shere%2$s', 'zubin' ),
				 '<a href="javascript:wp.customize.section( \'zubin_portfolio\' ).focus();">',
				 '</a>'
			),
			'section'           => 'jetpack_portfolio',
			'type'              => 'description',
			'priority'          => 1,
		)
	);

	$wp_customize->add_section( 'zubin_portfolio', array(
			'panel'    => 'zubin_theme_options',
			'title'    => esc_html__( 'Portfolio', 'zubin' ),
		)
	);

	$action = 'install-plugin';
    $slug   = 'essential-content-types';

    $install_url = wp_nonce_url(
        add_query_arg(
            array(
                'action' => $action,
                'plugin' => $slug
            ),
            admin_url( 'update.php' )
        ),
        $action . '_' . $slug
    );

    zubin_register_option( $wp_customize, array(
            'name'              => 'zubin_portfolio_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Zubin_Note_Control',
          	'active_callback'   => 'zubin_is_ect_portfolio_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Portfolio, install %1$sEssential Content Types%2$s Plugin with Portfolio Type Enabled', 'zubin' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'zubin_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_portfolio_option',
			'default'           => 'disabled',
			'active_callback'   => 'zubin_is_ect_portfolio_active',
			'sanitize_callback' => 'zubin_sanitize_select',
			'choices'           => zubin_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'zubin' ),
			'section'           => 'zubin_portfolio',
			'type'              => 'select',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_portfolio_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'Zubin_Note_Control',
			'active_callback'   => 'zubin_is_portfolio_active',
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'zubin' ),
				 '<a href="javascript:wp.customize.control( \'jetpack_portfolio_title\' ).focus();">',
				 '</a>'
			),
			'section'           => 'zubin_portfolio',
			'type'              => 'description',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_portfolio_subtitle',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Tagline', 'zubin' ),
			'active_callback'   => 'zubin_is_portfolio_active',
			'section'           => 'zubin_portfolio',
			'type'              => 'text',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_portfolio_number',
			'default'           => 6,
			'sanitize_callback' => 'zubin_sanitize_number_range',
			'active_callback'   => 'zubin_is_portfolio_active',
			'label'             => esc_html__( 'Number of items to show', 'zubin' ),
			'section'           => 'zubin_portfolio',
			'type'              => 'number',
			'input_attrs'       => array(
				'style'             => 'width: 100px;',
				'min'               => 0,
			),
		)
	);

	$number = get_theme_mod( 'zubin_portfolio_number', 6 );

	for ( $i = 1; $i <= $number ; $i++ ) {

		//for CPT
		zubin_register_option( $wp_customize, array(
				'name'              => 'zubin_portfolio_cpt_' . $i,
				'sanitize_callback' => 'zubin_sanitize_post',
				'active_callback'   => 'zubin_is_portfolio_active',
				'label'             => esc_html__( 'Portfolio', 'zubin' ) . ' ' . $i ,
				'section'           => 'zubin_portfolio',
				'type'              => 'select',
				'choices'           => zubin_generate_post_array( 'jetpack-portfolio' ),
			)
		);

	} // End for().

}
add_action( 'customize_register', 'zubin_portfolio_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'zubin_is_portfolio_active' ) ) :
	/**
	* Return true if portfolio is active
	*
	* @since Zubin 1.0
	*/
	function zubin_is_portfolio_active( $control ) {
		$enable = $control->manager->get_setting( 'zubin_portfolio_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( zubin_is_ect_portfolio_active( $control ) && zubin_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'zubin_is_ect_portfolio_inactive' ) ) :
    /**
    *
    * @since Zubin 1.0
    */
    function zubin_is_ect_portfolio_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'zubin_is_ect_portfolio_active' ) ) :
    /**
    *
    * @since Zubin 1.0
    */
    function zubin_is_ect_portfolio_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;
