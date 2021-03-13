<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package Zubin
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zubin_testimonial_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_jetpack_testimonial_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'Zubin_Note_Control',
			'label'             => sprintf( esc_html__( 'For Testimonial Options for Zubin Theme, go %1$shere%2$s', 'zubin' ),
				'<a href="javascript:wp.customize.section( \'zubin_testimonials\' ).focus();">',
				 '</a>'
			),
		   'section'            => 'jetpack_testimonials',
			'type'              => 'description',
			'priority'          => 1,
		)
	);

	$wp_customize->add_section( 'zubin_testimonials', array(
			'panel'    => 'zubin_theme_options',
			'title'    => esc_html__( 'Testimonials', 'zubin' ),
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
            'name'              => 'zubin_testimonial_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Zubin_Note_Control',
            'active_callback'   => 'zubin_is_ect_testimonial_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with testimonial Type Enabled', 'zubin' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'zubin_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );


	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_testimonial_option',
			'default'           => 'disabled',
			'active_callback'   => 'zubin_is_ect_testimonial_active',
			'sanitize_callback' => 'zubin_sanitize_select',
			'choices'           => zubin_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'zubin' ),
			'section'           => 'zubin_testimonials',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_testimonial_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'Zubin_Note_Control',
			'active_callback'   => 'zubin_is_testimonial_active',
			/* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'zubin' ),
				'<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
				'</a>'
			),
			'section'           => 'zubin_testimonials',
			'type'              => 'description',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_testimonial_subtitle',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Tagline', 'zubin' ),
			'active_callback'   => 'zubin_is_testimonial_active',
			'section'           => 'zubin_testimonials',
			'type'              => 'text',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_testimonial_number',
			'default'           => '4',
			'sanitize_callback' => 'zubin_sanitize_number_range',
			'active_callback'   => 'zubin_is_testimonial_active',
			'label'             => esc_html__( 'Number of items', 'zubin' ),
			'section'           => 'zubin_testimonials',
			'type'              => 'number',
			'input_attrs'       => array(
				'style'             => 'width: 100px;',
				'min'               => 0,
			),
		)
	);

	$number = get_theme_mod( 'zubin_testimonial_number', 4 );

	for ( $i = 1; $i <= $number ; $i++ ) {

		//for CPT
		zubin_register_option( $wp_customize, array(
				'name'              => 'zubin_testimonial_cpt_' . $i,
				'sanitize_callback' => 'zubin_sanitize_post',
				'active_callback'   => 'zubin_is_testimonial_active',
				'label'             => esc_html__( 'Testimonial', 'zubin' ) . ' ' . $i ,
				'section'           => 'zubin_testimonials',
				'type'              => 'select',
				'choices'           => zubin_generate_post_array( 'jetpack-testimonial' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'zubin_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'zubin_is_testimonial_active' ) ) :
	/**
	* Return true if testimonial is active
	*
	* @since Zubin 1.0
	*/
	function zubin_is_testimonial_active( $control ) {
		$enable = $control->manager->get_setting( 'zubin_testimonial_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( zubin_is_ect_testimonial_active( $control ) && zubin_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'zubin_is_ect_testimonial_inactive' ) ) :
    /**
    *
    * @since Zubin 1.0
    */
    function zubin_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;

if ( ! function_exists( 'zubin_is_ect_testimonial_active' ) ) :
    /**
    *
    * @since Zubin 1.0
    */
    function zubin_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;
