<?php

if ( ! function_exists( 'atawcvs_get_default_theme_options' ) ) :

	/**
	 * Get default theme options
	 *
	 * @since 1.0.0
	 *
	 * @return array Default Plugins options.
	 */
	function atawcvs_get_default_theme_options() {

		$defaults = array();
		
		
		// Slider Section.
		$defaults['atawc_color'] = array(
			'color_variation_style' => 'round',
			'color_variation_width' => 40,
			'color_variation_height' => 40,
			'color_variation_tooltip' => 'yes',
		);
		
		$defaults['atawc_images'] = array(
			'image_variation_style' => 'round',
			'image_variation_width' => 40,
			'image_variation_height' => 40,
			'image_variation_tooltip' => 'yes',
		);
		
		$defaults['atawc_label'] = array(
			'lebel_variation_style' => 'square',
			'lebel_variation_width' => 40,
			'lebel_variation_height' => 30,
			'lebel_variation_size' => '13',
			'lebel_variation_color' => '#000',
			'lebel_variation_color_hover' => '#000',
			'lebel_variation_background' => '#c8c8c8',
			'lebel_variation_background_hover' => '#c8c8c8',
			'lebel_variation_border' => '#000',
			'lebel_variation_border_hover' => '#c8c8c8',
			'lebel_variation_ingredient' => 'opacity',
			'lebel_variation_tooltip' => 'yes',
			
		);
		
		$defaults['general_settings'] = array(
			'__price_update_on' => 'price',
			'__swatches_display_on_archive' => 40,
			'__swatches_tooltip' => '#000',
			'__swatches_bg' => '#fff',
			'__swatches_tick_sing_color' => '#000',
			
		);
		
		$defaults['archive_settings'] = array(
			'__swatches_display_on_archive' => 'on',
			'__swatches_archive_behavior' => 'product_filter_by',
			'__swatches_archive_label' => 'off',
			'__swatches_display_position_on_arch' => 'after_add_to_cart',
			'__swatches_archive_tooltip' => 'on',
			'__swatches_archive_width' => '35',
			'__archive_variation_style' => 'round',
			'__swatches_archive_height' => '35',
		);
		
		
	

		return $defaults;

	}

endif;



if ( ! function_exists( 'atawcvs_get_option' ) ) :

	/**
	 * Get theme option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function atawcvs_get_option( $key ) {

		if ( empty( $key ) ) {
			return;
		}

		$value = '';

		$default = atawcvs_get_default_theme_options();
		
		
		$value = get_option( $key );
		
		if( !empty($value )  ){
			return $value;
		}else {
			
			return $default[$key];
		}
		

		return $value;
	}

endif;

