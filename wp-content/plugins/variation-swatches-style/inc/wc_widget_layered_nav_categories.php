<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Check if the custom class exists
if ( ! class_exists( 'Smart_Filter_Widget' ) ) 
{
	// Create custom widget class extending WPH_Widget
	class Smart_Filter_Widget extends WPH_Widget
	{
	
		function __construct()
		{
		
			// Configure widget array
			$args = array( 
				// Widget Backend label
				'label' => __( '+ Smart Swatches Filter Products', 'multipurpose-shop' ), 
				// Widget Backend Description								
				'description' => __( 'Product Filter by Swatches ', 'multipurpose-shop' ), 		
			 );
		
			// Configure the widget fields
			// Example for: Title ( text ) and Amount of posts to show ( select box )
		
			// fields array
			$args['fields'] = array( 							
			
				// Title field
				array( 		
					// field name/label									
					'name' => __( 'Title', 'multipurpose-shop' ), 		
					// field description					
					'desc' => __( 'Filter Products by Widget Description.', 'multipurpose-shop' ), 
					// field id		
					'id' => 'title', 
					// field type ( text, checkbox, textarea, select, select-group )								
					'type'=>'text', 	
					// class, rows, cols								
					'class' => 'widefat', 	
					// default value						
					'std' => __( 'Filter Products by', 'multipurpose-shop' ), 
					'validate' => 'alpha_dash', 
					'filter' => 'strip_tags|esc_attr'	
				 ), 
				// Amount Field
				array( 
					'name' => __( 'Attribute' ), 							
					'desc' => __( 'Select the Attribute.', 'multipurpose-shop' ), 
					'id' => 'attribute_id', 							
					'type'=>'select', 				
					// selectbox fields			
					'fields' => $this->attribute_name_array(), 
				 ), 
				
				
			
				// add more fields
			
			 ); // fields array
			// create widget
			$this->create_widget( $args );
		}
		
		function attribute_name_array(){
			global $product;
			$array = array();
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			if( $attribute_taxonomies != "" ):
				$i = 0;
				foreach ( $attribute_taxonomies as $tax ) : $i++;
					$attribute = array();
					$array[$i]['name'] = $tax->attribute_label;
					
					$attribute['attribute_name'] = $tax->attribute_name;
					$attribute['attribute_type'] = $tax->attribute_type;
					
					$array[$i]['value'] = json_encode( $attribute );
					
					
				endforeach;
			endif;
			
			return $array;
			
		}
		
		// Custom validation for this widget 
		
		function my_custom_validation( $value )
		{
			if ( strlen( $value ) > 1 )
				return false;
			else
				return true;
		}
		function sprit( $title  ){
			if( $title != "" ):
				// Cut the title into two halves.
				$halves = explode(' ', $title, 2);
				// Add the remaining words if any.
				if (isset($halves[1]) ) {
					$title = '<span class="color_style">' . $halves[0] . '</span>';
					return $title . ' ' . $halves[1];
				}else{
					return $title;
				}
			endif;
	
		}
		
		
		
		function  smart_swatch_html( $type, $url, $selected = NULL, $label, $meta_value = NULL ) {
			$html = '';
			switch ( $type ) {
				
				case 'color':
				
					$options = atawcvs_get_option('atawc_color');
					
					$width = ( isset( $options['color_variation_width'] ) && $options['color_variation_width'] != "" ) ? $options['color_variation_width'] : 40 ;
					$height = ( isset( $options['color_variation_height'] ) && $options['color_variation_height'] != "" ) ? $options['color_variation_height'] : 40 ;
					
					$style = ( isset( $options['color_variation_style'] ) && $options['color_variation_style'] != "" ) ? $options['color_variation_style'] : 'round' ;
					
					$tick_sign = ( isset( $options['color_variation_ingredient'] ) && $options['color_variation_ingredient'] != "" ) ? $options['color_variation_ingredient'] : 'tick_sign' ;
					
					//masterTooltip 
					$tooltip = ( isset( $options['color_variation_tooltip'] ) && $options['color_variation_tooltip'] == "yes" ) ? 'masterTooltip' : '' ;
					
					    
					$html = sprintf(
						'<li><a href="%s" class="swatch swatch-color %s %s %s %s" title="%s" style="background-color:%s; width:%spx; height:%spx;">%s</a></li>',
						esc_url( $url ),
						$style,
						$tick_sign,
						$tooltip,
						$selected,
						$label,
						$meta_value,
						$width,
						$height,
						$label
					);
					
					break;
					
					case 'label':
				
				
					$options = atawcvs_get_option('atawc_label');
					$width = ( isset( $options['lebel_variation_width'] ) && $options['lebel_variation_width'] != "" ) ? $options['lebel_variation_width'] : 44 ;
					$height = ( isset( $options['lebel_variation_height'] ) && $options['lebel_variation_height'] != "" ) ? $options['lebel_variation_height'] : 44 ;
					$style = ( isset( $options['lebel_variation_style'] ) && $options['lebel_variation_style'] != "" ) ? $options['lebel_variation_style'] : 'square' ;
				
					$tick_sign = '';
					
					//masterTooltip 
					$tooltip = '';
					
					    
					$html = sprintf(
						'<li><a href="%s" class="swatch swatch-label %s %s %s %s" title="%s" style="line-height:%spx; width:%spx; height:%spx;">%s</a></li>',
						esc_url( $url ),
						$style,
						$tick_sign,
						$tooltip,
						$selected,
						$label,
						$height,
						$width,
						$height,
						$label
					);
					
					break;
					
					
					case 'image':
				
				
					$options = atawcvs_get_option('atawc_images');
				$width = ( isset( $options['image_variation_width'] ) && $options['image_variation_width'] != "" ) ? $options['image_variation_width'] : 44 ;
				$height = ( isset( $options['image_variation_height'] ) && $options['image_variation_height'] != "" ) ? $options['image_variation_height'] : 44 ;
				$style = ( isset( $options['image_variation_style'] ) && $options['image_variation_style'] != "" ) ? $options['image_variation_style'] : 'round_corner' ;
				$tick_sign = ( isset( $options['image_variation_ingredient'] ) && $options['image_variation_ingredient'] != "" ) ? $options['image_variation_ingredient'] : 'tick_sign' ;
				
				$tooltip = ( isset( $options['image_variation_tooltip'] ) && $options['image_variation_tooltip'] == "yes" ) ? 'masterTooltip' : '' ;
				
				
					$image = absint( $meta_value)  ? wp_get_attachment_image_src( absint( $meta_value)  ,'full'  ) : '';
				
				   $image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
					    
					$html = sprintf(
						'<li><a href="%s" class="swatch swatch-label %s %s %s %s" title="%s" style="width:%spx; height:%spx;"><img src="%s" alt="%s"></a></li>',
						esc_url( $url ),
						$style,
						$tick_sign,
						$tooltip,
						$selected,
						$label,
						$width,
						$height,
						$image,
						$label
					);
					
					break;
					
					
					
			}

		return $html;
	}
		
		// Output function
		function widget( $args, $instance )
		{
	
			// And here do whatever you want
			$out  = $args['before_widget'];
			$out .= $args['before_title'];
			$out .= esc_html( $instance['title'] );
			$out .= $args['after_title'];
			
			
			$attribute = json_decode( $instance['attribute_id'] );
			
			
			if( isset( $attribute->attribute_name ) &&  $attribute->attribute_name != ""  ):
			
				$raw_url = get_the_permalink( wc_get_page_id( 'shop' ) );
				
				if ( preg_match("/\?/", $raw_url ) ) {
					
					$url = esc_url ( get_site_url().'/?post_type=product' );
					
				}else{
					
					$url = esc_url( get_the_permalink( wc_get_page_id( 'shop' ) ) );
					
				}
		
			$out .= '<ul class="smart_attribute_as_widgets smart_attribute '.$attribute->attribute_type.'">';
			$i = 0; 
			foreach( get_terms( 'pa_'.$attribute->attribute_name ) as $term){ $i++;
				
				$meta_value = get_term_meta( $term->term_id, $attribute->attribute_type);
				
				$url = add_query_arg( 'smart_taxonomy', 'pa_'.$attribute->attribute_name, $url );
				$url = add_query_arg( 'slug_terms', $term->slug, $url );
				
				
				
				$out .= $this->smart_swatch_html( $attribute->attribute_type, $url, '', $term->name , isset( $meta_value[0] ) ? $meta_value[0] : '');
				
				if( $i == 3 ){
					$out .= '<a href="https://athemeart.com/downloads/smart-variation-swatches-woocommerce-pro/">Go Pro!</a> to display all';
					break;
				}
				
				
			}
			$out .= '</ul>';
			
			endif;	
			$out  .= $args['after_widget'];	
			echo $out;
			
		}
	
	} // class
	// Register widget
	if ( ! function_exists( 'smart_filter_register_widget' ) )
	{
		function smart_filter_register_widget()
		{
			register_widget( 'Smart_Filter_Widget' );
		}
		
		add_action( 'widgets_init', 'smart_filter_register_widget', 1 );
	}
}

add_action('pre_get_posts','shop_filter_cat');

 function shop_filter_cat($query) {
	if( isset( $_REQUEST['smart_taxonomy'] ) && $_REQUEST['smart_taxonomy'] != "" &&  isset( $_REQUEST['slug_terms'] ) && $_REQUEST['slug_terms'] != "") {
		
		if ( ! is_admin() && $query->is_main_query()  && ( is_product_category() || is_shop() ) ){	
		  $array =  array (
					'taxonomy' => esc_attr($_REQUEST['smart_taxonomy']),
					'field' => 'slug',
					'terms' => esc_attr($_REQUEST['slug_terms'])
				);
					
		    $query->set('tax_query', array( $array  ));   
		}
	}
	
	return $query;
 }
 
