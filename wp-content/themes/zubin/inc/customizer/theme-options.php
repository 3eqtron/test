<?php
/**
 * Theme Options
 *
 * @package Zubin
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zubin_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'zubin_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'zubin' ),
		'priority' => 130,
	) );

	// Layout Options
	$wp_customize->add_section( 'zubin_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'zubin' ),
		'panel' => 'zubin_theme_options',
		)
	);

	/* Default Layout */
	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_default_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'zubin_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'zubin' ),
			'section'           => 'zubin_layout_options',
			'type'              => 'select',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'zubin' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'zubin' ),
			),
		)
	);

	/* Homepage Layout */
	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_homepage_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'zubin_sanitize_select',
			'label'             => esc_html__( 'Homepage Layout', 'zubin' ),
			'section'           => 'zubin_layout_options',
			'type'              => 'select',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'zubin' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'zubin' ),
			),
		)
	);

	/* Archive Layout */
	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_archive_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'zubin_sanitize_select',
			'label'             => esc_html__( 'Blog/Archive Layout', 'zubin' ),
			'section'           => 'zubin_layout_options',
			'type'              => 'select',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'zubin' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'zubin' ),
			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'zubin_excerpt_options', array(
		'panel'     => 'zubin_theme_options',
		'title'     => esc_html__( 'Excerpt Options', 'zubin' ),
	) );

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_excerpt_length',
			'default'           => '20',
			'sanitize_callback' => 'absint',
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'zubin' ),
			'section'  => 'zubin_excerpt_options',
			'type'     => 'number',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading', 'zubin' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'zubin' ),
			'section'           => 'zubin_excerpt_options',
			'type'              => 'text',
		)
	);

	// Search Options.
	$wp_customize->add_section( 'zubin_search_options', array(
		'panel'     => 'zubin_theme_options',
		'title'     => esc_html__( 'Search Options', 'zubin' ),
	) );

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_search_text',
			'default'           => esc_html__( 'Search', 'zubin' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Search Text', 'zubin' ),
			'section'           => 'zubin_search_options',
			'type'              => 'text',
		)
	);

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'zubin_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'zubin' ),
		'panel'       => 'zubin_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'zubin' ),
	) );


	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_recent_posts_title',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'From Our Blog', 'zubin' ),
			'label'             => esc_html__( 'Recent Posts Title', 'zubin' ),
			'section'           => 'zubin_homepage_options',
		)
	);

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_front_page_category',
			'sanitize_callback' => 'zubin_sanitize_category_list',
			'custom_control'    => 'Zubin_Multi_Cat',
			'label'             => esc_html__( 'Categories', 'zubin' ),
			'section'           => 'zubin_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);

	// Pagination Options.
	$pagination_type = get_theme_mod( 'zubin_pagination_type', 'default' );

	$nav_desc = '';

	/**
	* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
	*/
	$nav_desc = sprintf(
		wp_kses(
			__( 'For infinite scrolling, use %1$sCatch Infinite Scroll Plugin%2$s with Infinite Scroll module Enabled.', 'zubin' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
				'br'=> array()
			)
		),
		'<a target="_blank" href="https://wordpress.org/plugins/catch-infinite-scroll/">',
		'</a>'
	);

	$wp_customize->add_section( 'zubin_pagination_options', array(
		'description'     => $nav_desc,
		'panel'           => 'zubin_theme_options',
		'title'           => esc_html__( 'Pagination Options', 'zubin' ),
		'active_callback' => 'zubin_scroll_plugins_inactive'
	) );

	zubin_register_option( $wp_customize, array(
			'name'              => 'zubin_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'zubin_sanitize_select',
			'choices'           => zubin_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'zubin' ),
			'section'           => 'zubin_pagination_options',
			'type'              => 'select',
		)
	);

	/* Scrollup Options */
	$wp_customize->add_section( 'zubin_scrollup', array(
		'panel'    => 'zubin_theme_options',
		'title'    => esc_html__( 'Scrollup Options', 'zubin' ),
	) );

	$action = 'install-plugin';
	$slug   = 'to-top';

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

	// Add note to Scroll up Section
    zubin_register_option( $wp_customize, array(
            'name'              => 'zubin_to_top_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Zubin_Note_Control',
            'active_callback'   => 'zubin_is_to_top_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Scroll Up, install %1$sTo Top%2$s Plugin', 'zubin' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'zubin_scrollup',
            'type'              => 'description',
            'priority'          => 1,
        )
    );
}
add_action( 'customize_register', 'zubin_theme_options' );


/** Active Callback Functions */
if ( ! function_exists( 'zubin_scroll_plugins_inactive' ) ) :
	/**
	* Return true if infinite scroll functionality exists
	*
	* @since 1.0
	*/
	function zubin_scroll_plugins_inactive( $control ) {
		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
			// Support infinite scroll plugins.
			return false;
		}

		return true;
	}
endif;

if ( ! function_exists( 'zubin_is_to_top_inactive' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Simclick 0.1
    */
    function zubin_is_to_top_inactive( $control ) {
        return ! ( class_exists( 'To_Top' ) );
    }
endif;
