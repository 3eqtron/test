<?php
/**
 * Services options
 *
 * @package Zubin
 */

/**
 * Add service content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zubin_service_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
    zubin_register_option( $wp_customize, array(
            'name'              => 'zubin_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Zubin_Note_Control',
            'label'             => sprintf( esc_html__( 'For all Services Options, go %1$shere%2$s', 'zubin' ),
                '<a href="javascript:wp.customize.section( \'zubin_service\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'zubin_service', array(
			'title' => esc_html__( 'Services', 'zubin' ),
			'panel' => 'zubin_theme_options',
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
            'name'              => 'zubin_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Zubin_Note_Control',
            'active_callback'   => 'zubin_is_ect_services_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Service Type Enabled', 'zubin' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'zubin_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	// Add color scheme setting and control.
	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_service_option',
			'default'           => 'disabled',
			'active_callback'   => 'zubin_is_ect_services_active',
			'sanitize_callback' => 'zubin_sanitize_select',
			'choices'           => zubin_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'zubin' ),
			'section'           => 'zubin_service',
			'type'              => 'select',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_service_number',
			'default'           => 4,
			'sanitize_callback' => 'zubin_sanitize_number_range',
			'active_callback'   => 'zubin_is_service_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Services is changed (Max no of Services is 20)', 'zubin' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of items', 'zubin' ),
			'section'           => 'zubin_service',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_service_subtitle',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'zubin_is_service_active',
			'label'             => esc_html__( 'Tagline', 'zubin' ),
			'section'           => 'zubin_service',
			'type'              => 'text',
		)
	);

    zubin_register_option( $wp_customize, array(
            'name'              => 'zubin_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Zubin_Note_Control',
            'active_callback'   => 'zubin_is_service_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'zubin' ),
                 '<a href="javascript:wp.customize.control( \'ect_service_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'zubin_service',
            'type'              => 'description',
        )
    );

	$number = get_theme_mod( 'zubin_service_number', 4 );

	//loop for service post content
	for ( $i = 1; $i <= $number ; $i++ ) {

		zubin_register_option( $wp_customize, array(
				'name'              => 'zubin_service_cpt_' . $i,
				'sanitize_callback' => 'zubin_sanitize_post',
				'active_callback'   => 'zubin_is_service_active',
				'label'             => esc_html__( 'Services', 'zubin' ) . ' ' . $i ,
				'section'           => 'zubin_service',
				'type'              => 'select',
                'choices'           => zubin_generate_post_array( 'ect-service' ),
			)
		);
		
	} // End for().
}
add_action( 'customize_register', 'zubin_service_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'zubin_is_service_active' ) ) :
	/**
	* Return true if service content is active
	*
	* @since Zubin 1.0
	*/
	function zubin_is_service_active( $control ) {
		$enable = $control->manager->get_setting( 'zubin_service_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( zubin_is_ect_services_active( $control ) && zubin_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'zubin_is_ect_services_inactive' ) ) :
    /**
    * Return true if service is active
    *
    * @since Zubin 1.0
    */
    function zubin_is_ect_services_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'zubin_is_ect_services_active' ) ) :
    /**
    * Return true if service is active
    *
    * @since Zubin 1.0
    */
    function zubin_is_ect_services_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;
