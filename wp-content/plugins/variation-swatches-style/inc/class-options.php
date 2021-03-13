<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('ATA_WC_Variation_Swatches_Options' ) ):

class ATA_WC_Variation_Swatches_Options {
	/**
	 * The single instance of the class
	 *
	 * @var ATA_WC_Variation_Swatches_Admin
	 */
	protected static $instance = null;
	
    private $settings_api;

	/**
	 * Main instance
	 *
	 * @return ATA_WC_Variation_Swatches_Admin
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	/**
	 * Class constructor.
	 */
    function __construct() {
		require_once 'class.settings-api.php';
        $this->settings_api = new WeDevs_Settings_API_Swatches;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
       // add_options_page( 'Settings API', 'Settings API', 'woocommerce', 'settings_api_test', array($this, 'plugin_page') );
		   add_submenu_page( 'woocommerce', 'Variation Swatches ', 'Smart Swatches', 'manage_options', 'ata-variation-swatches', array($this, 'plugin_page') ); 
    }

    function get_settings_sections() {
		
        $sections = array(
			array(
                'id'    => 'general_settings',
                'title' => __( 'General Settings', 'smart-variation-swatches' )
            ),
			
			 array(
                'id'    => 'atawc_label',
                'title' => __( 'Label Swatches  Settings', 'smart-variation-swatches' )
            ),
            array(
                'id'    => 'atawc_color',
                'title' => __( 'Color Swatches  Settings', 'smart-variation-swatches' )
            ),
            array(
                'id'    => 'atawc_images',
                'title' => __( 'Images Swatches Settings', 'smart-variation-swatches' )
            ),
			array(
                'id'    => 'archive_settings',
                'title' => __( 'Shop / Archive', 'smart-variation-swatches' )
            ),
			
			array(
                'id'    => 'atawc_tutorials',
                'title' => __( 'Tutorials', 'smart-variation-swatches' )
            ),
            
			 
        );
        return $sections;
    }
	

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
		 
		 
		'atawc_tutorials' => array(
			
			
		),
		 'archive_settings' => array(
				
		
				
				array(
                    'name'    => '__swatches_display_on_archive',
                    'label'   => __( 'Enable Swatches', 'smart-variation-swatches' ),
                    'type'    => 'checkbox',
                   
					'desc'    => __( 'Show Swatches on archive / shop page', 'smart-variation-swatches' ),
                ),
				
				array(
                    'name'    => '__swatches_archive_behavior',
                    'label'   => __( 'Swatches behavior', 'wedevs' ),
                    'desc'    => __( 'Swatches behavior on archive / shop page ', 'wedevs' ),
                    'type'    => 'radio',
					'default' => 'add_to_cart',
                    'options' => array(
                        'add_to_cart' =>  __( 'Add to Cart', 'smart-variation-swatches' ),
                        'product_filter_by'  =>  __( 'Product filter by attribute ', 'smart-variation-swatches' ),
                    )
                ),
				
				array(
                    'name'    => '__swatches_archive_label',
                    'label'   => __( 'Display Label', 'smart-variation-swatches' ),
                    'type'    => 'checkbox',
                    'default' => 'on',
					'desc'    => __( 'Show Swatches Label or title on archive / shop page', 'smart-variation-swatches' ),
                ),
				array(
                    'name'    => '__swatches_display_position_on_arch',
                   'label'   => __( 'Display Position', 'smart-variation-swatches' ),
                    'type'    => 'radio',
                    'default' => 'before_add_to_cart',
                    'options' => array(
                        'before_add_to_cart' => __( 'Before add to cart ', 'smart-variation-swatches' ),
                        'after_add_to_cart'  => __( 'After add to cart', 'smart-variation-swatches' ),
                    )
                ),
				
				array(
                    'name'    => '__swatches_archive_tooltip',
                    'label'   => __( 'Enable Tooltip', 'smart-variation-swatches' ),
                    'type'    => 'checkbox',
                    
					'desc'    => __( 'Enable Archive page tooltips', 'smart-variation-swatches' ),
                ),
				
				 array(
                    'name'              => '__swatches_archive_width',
                    'label'             => __( 'Swatches width ', 'smart-variation-swatches' ),
                    'default' 			=> 40,
                    'type'              => 'number',
                    'sanitize_callback' => 'number'
                ),
				array(
                    'name'              => '__swatches_archive_height',
                    'label'             => __( 'Swatches Height', 'smart-variation-swatches' ),
                    'default' 			=> 40,
                    'type'              => 'number',
                    'sanitize_callback' => 'number'
                ),
				
				array(
                    'name'    => '__archive_variation_style',
                    'label'   => __( 'Swatches Style', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'round',
                    'options' => array(
                        'square' => __( 'Square', 'smart-variation-swatches' ),
                        'round'  => __( 'Circle', 'smart-variation-swatches' ),
						'round_corner'  => __( 'Round corner', 'smart-variation-swatches' ),
                    ),
					'desc'    => __( ' Swatches Style on page Shop / Archive', 'smart-variation-swatches' ),
                ),
				
				
			),
			
			
		 'general_settings' => array(
				array(
					'name'    => '__price_update_on',
					'label'   => __( 'Variable Price range Show', 'smart-variation-swatches' ),
					'type'    => 'text',
					'default' => 'price',
					'desc'    => __( 'Replace the Variable Price range by the chosen css class', 'smart-variation-swatches' ),
				),
				
				array(
                    'name'    => '__swatches_tooltip',
                    'label'   => __( 'Tooltip Color', 'smart-variation-swatches' ),
                    'type'    => 'color',
                    'default' => '#000'
                ),
				array(
                    'name'    => '__swatches_bg',
                    'label'   => __( 'Tooltip Background', 'smart-variation-swatches' ),
                    'type'    => 'color',
                    'default' => '#fff'
                ),
				
				array(
                    'name'    => '__swatches_tick_sing_color',
                    'label'   => __( 'Tick sign Color', 'smart-variation-swatches' ),
                    'type'    => 'color',
                    'default' => '#000'
                ),
				
				
				
			),
			
			
            'atawc_label' => array(
				array(
                    'name'    => 'lebel_variation_style',
                    'label'   => __( 'Swatches Type', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'square',
                    'options' => array(
                        'square' => __( 'Square', 'smart-variation-swatches' ),
                        'round'  => __( 'Circle', 'smart-variation-swatches' ),
						'round_corner'  => __( 'Round corner', 'smart-variation-swatches' ),
                    )
                ),
                array(
                    'name'              => 'lebel_variation_width',
                    'label'             => __( 'Button Width', 'smart-variation-swatches' ),
                    'default' 			=> 40,
                    'type'              => 'number',
                    'sanitize_callback' => 'number'
                ),
				array(
                    'name'              => 'lebel_variation_height',
                    'label'             => __( 'Button Height', 'smart-variation-swatches' ),
                    'default' 			=> 40,
                    'type'              => 'number',
                    'sanitize_callback' => 'number'
                ),
				array(
                    'name'              => 'lebel_variation_size',
                    'label'             => __( 'Font Size', 'smart-variation-swatches' ),
                    'default' 			=> 13,
                    'type'              => 'number',
                    'sanitize_callback' => 'number',
					'desc'    => __( 'PX', 'smart-variation-swatches' ),
                ),
				
				
               	array(
                    'name'    => 'lebel_variation_color',
                    'label'   => __( 'Button Color', 'smart-variation-swatches' ),
                    'type'    => 'color',
                    'default' => '#fff'
                ),
				array(
                    'name'    => 'lebel_variation_background',
                    'label'   => __( 'Button Background', 'smart-variation-swatches' ),
                    'type'    => 'color',
                    'default' => '#000'
                ),
				array(
                    'name'    => 'lebel_variation_border',
                    'label'   => __( 'border Color', 'smart-variation-swatches' ),
                    'type'    => 'color',
                    'default' => '#000'
                ),
				
				array(
                    'name'    => 'swatches_hover_settings',
                    'label'   =>'',
                    'type'    => 'html',
                  
                ),
				array(
                    'name'    => 'lebel_variation_color_hover',
                    'label'   => __( 'Hover Color', 'smart-variation-swatches' ),
                    'type'    => 'color',
                    'default' => '#000'
                ),
				
				array(
                    'name'    => 'lebel_variation_background_hover',
                    'label'   => __( 'Hover Background', 'smart-variation-swatches' ),
                    'type'    => 'color',
                    'default' => '#c8c8c8'
                ),
				
				
				array(
                    'name'    => 'lebel_variation_border_hover',
                    'label'   => __( 'Hover border', 'smart-variation-swatches' ),
                    'type'    => 'color',
                    'default' => '#c8c8c8'
                ),
				array(
                    'name'    => 'swatches_hover_settings_2',
                    'label'   =>'',
                    'type'    => 'html',
                  
                ),
				array(
                    'name'    => 'lebel_variation_tooltip',
                    'label'   => __( 'Color Swatches tooltip', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => __( 'Yes', 'smart-variation-swatches' ),
                        'no'  => __( 'No', 'smart-variation-swatches' ),
                    )
                ),
				array(
                    'name'    => 'lebel_variation_ingredient',
                   'label'   => __( 'Active / Selected item ingredient', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'opacity',
                    'options' => array(
                        'tick_sign' => __( 'Tick sign', 'smart-variation-swatches' ),
                        'opacity'  => __( 'Opacity', 'smart-variation-swatches' ),
						'zoom_up'  => __( 'Zoom Up', 'smart-variation-swatches' ),
						'zoom_down'  => __( 'Zoom Down', 'smart-variation-swatches' ),
                    )
                ),
            ),
            'atawc_color' => array(
               array(
                    'name'    => 'color_variation_style',
                    'label'   => __( 'Swatches Type', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'round',
                    'options' => array(
                        'square' => __( 'Square', 'smart-variation-swatches' ),
                        'round'  => __( 'Circle', 'smart-variation-swatches' ),
						'round_corner'  => __( 'Round corner', 'smart-variation-swatches' ),
                    )
                ),
                array(
                    'name'              => 'color_variation_width',
                    'label'             => __( 'Color Swatches Width', 'smart-variation-swatches' ),
                    'default' 			=> 40,
                    'type'              => 'number',
                    'sanitize_callback' => 'number'
                ),
				array(
                    'name'              => 'color_variation_height',
                    'label'             => __( 'Color Swatches Height', 'smart-variation-swatches' ),
                    'default' 			=> 40,
                    'type'              => 'number',
                    'sanitize_callback' => 'number'
                ),
				
				array(
                    'name'    => 'color_variation_tooltip',
                    'label'   => __( 'Color Swatches tooltip', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => __( 'Yes', 'smart-variation-swatches' ),
                        'no'  => __( 'No', 'smart-variation-swatches' ),
                    )
                ),
				array(
                    'name'    => 'color_variation_ingredient',
                    'label'   => __( 'Active / Selected item ingredient', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'tick_sign',
                    'options' => array(
                        'tick_sign' => __( 'Tick sign', 'smart-variation-swatches' ),
                        'opacity'  => __( 'Opacity', 'smart-variation-swatches' ),
						'zoom_up'  => __( 'Zoom Up', 'smart-variation-swatches' ),
						'zoom_down'  => __( 'Zoom Down', 'smart-variation-swatches' ),
                    )
                ),
				
            ),
            'atawc_images' => array(
               array(
                    'name'    => 'image_variation_style',
                    'label'   => __( 'Image Swatches Style', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'round_corner',
                    'options' => array(
                        'square' => __( 'Square', 'smart-variation-swatches' ),
                        'round'  => __( 'Circle', 'smart-variation-swatches' ),
						'round_corner'  => __( 'Round corner', 'smart-variation-swatches' ),
                    )
                ),
                array(
                    'name'              => 'image_variation_width',
                    'label'             => __( 'Image Swatches Width', 'smart-variation-swatches' ),
                    'default' 			=> 44,
                    'type'              => 'number',
                    'sanitize_callback' => 'number'
                ),
				array(
                    'name'              => 'image_variation_height',
                    'label'             => __( 'Image Swatches Height', 'smart-variation-swatches' ),
                    'default' 			=> 44,
                    'type'              => 'number',
                    'sanitize_callback' => 'number'
                ),
				
				array(
                    'name'    => 'image_variation_tooltip',
                    'label'   => __( 'Image Swatches tooltip', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'yes',
                    'options' => array(
                        'yes' => __( 'Yes', 'smart-variation-swatches' ),
                        'no'  => __( 'No', 'smart-variation-swatches' ),
                    )
                ),
				
				array(
                    'name'    => 'image_variation_ingredient',
                    'label'   => __( 'Active / Selected item ingredient', 'smart-variation-swatches' ),
                    'type'    => 'select',
                    'default' => 'tick_sign',
                    'options' => array(
                        'tick_sign' => __( 'Tick sign', 'smart-variation-swatches' ),
                        'opacity'  => __( 'Opacity', 'smart-variation-swatches' ),
						'zoom_up'  => __( 'Zoom Up', 'smart-variation-swatches' ),
						'zoom_down'  => __( 'Zoom Down', 'smart-variation-swatches' ),
                    )
                ),
				
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '</div>';
    }


}


endif;
