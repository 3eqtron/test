<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WC_EX_Product_Data_Tab_Swatches {
	/**
	 * The single instance of the class
	 *
	 * @var ATA_WC_Variation_Swatches
	 */
	protected static $instance = null;

	/**
	 * Main instance
	 *
	 * @return ATA_WC_Variation_Swatches
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	public $meta_name = '__ed_woo_meta_settings';
	
	
	public function __construct() {
			add_filter( 'woocommerce_product_data_tabs', array( $this, 'eds_add_my_custom_product_data_tab' ), 99 , 1 );
			add_action( 'woocommerce_product_data_panels', array( $this, 'product_data_panel_wrap' ) );
			add_action( 'woocommerce_process_product_meta', array( $this, 'process_meta_box' ),1 ,2 );
		}
		
	public function eds_add_my_custom_product_data_tab( $product_data_tabs ) {
		$product_data_tabs['woo-variations-style'] = array(
			'label' => __( 'Variation Swatches', 'smart-variation-swatches' ),
			'target' => 'woo_variations_style',
			'class' => array( 'show_if_variable' )
		);
   		 return $product_data_tabs;
	}
	public function product_data_panel_wrap() {
	?>
        <div id="woo_variations_style" class="panel woocommerce_options_panel hidden">
            <?php $this->render_product_tab_content(); ?>
        </div>
	<?php
	}	
	public function render_product_tab_content() {
		
		global $post;
		global $_wp_additional_image_sizes;
		
		/* default Value Added */
		$current_type = 'default';
		
		add_filter( 'woocommerce_variation_is_visible', array($this, 'return_true') );

		$post_id = $post->ID;
        $product = wc_get_product( $post->ID );
		
		/* Product Options */
		$swatch_type_options = $product->get_meta('_swatch_type_options', true);
		
		$product_type_array = array('variable', 'variable-subscription');

		if ( !in_array( $product->get_type(), $product_type_array ) ) {
			return;
		}
		
		echo '<div class="options_group">';
		?>

		<div class="fields_header ata_wcvs_heading">
			<table class="wcsap widefat">
				<thead>
				<th class="attribute_swatch_label">
					<?php _e( 'Product Attribute Name', 'smart-variation-swatches' ); ?>
				</th>
				<th class="attribute_swatch_type">
					<span><?php _e( 'Attribute Control Type', 'smart-variation-swatches' ); ?></span>
				</th>
				</thead>
			</table>
		</div>
		<div class="fields ">

			<?php
			$woocommerce_taxonomies = wc_get_attribute_taxonomies();
			$woocommerce_taxonomy_infos = array();
			foreach ( $woocommerce_taxonomies as $tax ) {
				$woocommerce_taxonomy_infos[wc_attribute_taxonomy_name( $tax->attribute_name )] = $tax;
			}
			$tax = null;

			$attributes = $product->get_variation_attributes(); //Attributes configured on this product already.

			if ( $attributes && count( $attributes ) > 0 ) :
				$attribute_names = array_keys( $attributes );
				foreach ( $attribute_names as $name ) :
				
					$key = md5( sanitize_title( $name ) );
					
					if ( isset( $swatch_type_options[$key] ) ) {
							$options = $swatch_type_options[$key];
							$current_type = $options['type'];
					}
					
					$current_is_taxonomy = taxonomy_exists( $name );
				
					$current_label = 'Unknown';
					$attribute_terms = array();
					
					if ( taxonomy_exists( $name ) ) :
						$tax = get_taxonomy( $name );
						$woocommerce_taxonomy = $woocommerce_taxonomy_infos[$name];
						$current_label = isset( $woocommerce_taxonomy->attribute_label ) && !empty( $woocommerce_taxonomy->attribute_label ) ? $woocommerce_taxonomy->attribute_label : $woocommerce_taxonomy->attribute_name;
						$terms = get_terms( $name, array('hide_empty' => false) );
						$selected_terms = isset( $attributes[$name] ) ? $attributes[$name] : array();
						foreach ( $terms as $term ) {
							if ( in_array( $term->slug, $selected_terms ) ) {
								$attribute_terms[] = array('id' => md5( $term->slug ), 'label' => $term->name, 'old_id' => $term->slug);
							}
						}
					else :
						$current_label = esc_html( $name );
						foreach ( $attributes[$name] as $term ) {
							
							$attribute_terms[] = array('id' => ( md5( sanitize_title( strtolower( $term ) ) ) ), 'label' => esc_html( $term ), 'old_id' => esc_attr( sanitize_title( $term ) ));
						}
					endif;
					?>
					<div class="field ata_wcvs_meta_wrp">
						<div class="wcsap_field_meta ata_wcvs_sub_heading">
							<table class="wcsap widefat">
								<tbody>
									<tr>
										<td class="attribute_swatch_label">
											<strong><a class="wcsap_edit_field row-title" href="javascript:;"><?php echo $current_label; ?></a></strong>
										</td>
										<td class="attribute_swatch_type">
                                            <select class="_swatch_type_options_type" id="_swatch_type_options_<?php echo $key_attr; ?>_type" name="_swatch_type_options[<?php echo $key; ?>][type]">
                                                <option <?php selected( $current_type, 'default' ); ?> value="default"><?php _e( 'None', 'smart-variation-swatches' ); ?></option>
                                                <?php if ( $current_is_taxonomy ) : ?>
                                                    <option <?php selected( $current_type, 'term_options' ); ?> value="term_options"><?php _e( 'Taxonomy Lebel, Colors and Images', 'smart-variation-swatches' ); ?></option>
                                                <?php endif; ?>
                                                <option <?php selected( $current_type, 'product_color' ); ?> value="product_color"><?php _e( 'Custom Colors', 'smart-variation-swatches' ); ?></option>
                                                  <option <?php selected( $current_type, 'product_image' ); ?> value="product_image"><?php _e( 'Custom Images', 'smart-variation-swatches' ); ?></option>
                                                    <option <?php selected( $current_type, 'product_label' ); ?> value="product_label"><?php _e( 'Custom Lebel', 'smart-variation-swatches' ); ?></option>
                                              
                                            
                                            </select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
                        
                            <div class="fields">
                                <?php 
								$image = WC()->plugin_url() . '/assets/images/placeholder.png';
								foreach ( $attribute_terms as $attribute_term ) :
								
								 ?>
                                  
                                  
                                    <div class="sub_field field">
                                    
                                        <div class="wcsap_field_meta ata_wcvs_meta">
                                    
                                    
                                       
                                                <table class="wcsap_input widefat">
                                                    <tbody>
                                                   	<?php
														$active_color = ( isset (  $current_type ) && $current_type != "product_color" ) ? 'hidden':'';
													$color = ( isset (  $swatch_type_options[ $key ] ) && $swatch_type_options[ $key ][ $attribute_term['id'] ]['color'] != "" ) ? $swatch_type_options[ $key ][ $attribute_term['id'] ]['color'] :'';
													
													?>   
                                                        <tr class="field_option field_option_color <?php echo $active_color;?>">
                                                            <td class="label" width="25%">
                                                               <?php echo esc_html( $attribute_term['label'] ); ?> 
                                                            </td>
                                                            <td class="section-color-swatch">
                                                          <input type="text" class="atawc_color_picker" name="_swatch_type_options[<?php echo $key; ?>][<?php echo esc_attr( $attribute_term['id'] ); ?>][color]" value="<?php echo esc_attr( $color ); ?>">
                                                                
                                                            </td>
                                                        </tr>
                                                        
                                                        
                                             	<?php
													$active_image = ( isset (  $current_type ) && $current_type != "product_image" ) ? 'hidden':'';
													$image_array = ( isset (  $swatch_type_options[ $key ] ) && $swatch_type_options[ $key ][ $attribute_term['id'] ]['image'] != "" ) ? wp_get_attachment_image_src( $swatch_type_options[ $key ][ $attribute_term['id'] ]['image'] ) : '';		
													
													$image_preview = is_array($image_array) ? $image_array[0] : $image;		
													
													$img_id = ( isset (  $swatch_type_options[ $key ] ) && $swatch_type_options[ $key ][ $attribute_term['id'] ]['image'] != "" ) ? $swatch_type_options[ $key ][ $attribute_term['id'] ]['image'] : '';	
													?>            
                                                        <tr class="field_option field_option_image <?php echo $active_image;?>">
                                                            <td class="label" width="25%">
                                                                <?php echo esc_html( $attribute_term['label'] ); ?> 
                                                            </td>
                                                            <td class="attribute_woo_var_style_img_row">
                                                       
    	
                                                <img src="<?php echo esc_url( $image_preview ) ?>" width="60px" height="60px" />
                                              
                                                <input type="hidden" class="atawc-term-image" name="_swatch_type_options[<?php echo $key; ?>][<?php echo esc_attr( $attribute_term['id'] ); ?>][image]" value="<?php echo esc_attr( $img_id ) ?>" />
                                                
                                                
                                                
                                                <a href="javascript:void(0)" class="button ata_woo_meta_uploader" data-uploader-title="Add image(s) to  <?php echo esc_attr( $attribute_term['label'] ); ?>" data-uploader-button-text="Add image(s)  <?php echo esc_attr( $attribute_term['label'] ); ?> "> <?php _e( 'Upload/Add image', 'smart-variation-swatches' ); ?></a>
                                                <a ref="javascript:void(0)" class="remove_ata_woo_meta_img button "><?php _e( 'Remove image', 'smart-variation-swatches' ); ?></a>
                                                
                                                </td>
                                                        </tr>
                                                        
                                               <?php
													$active_label = ( isset (  $current_type ) && $current_type != "product_lebel" ) ? 'hidden':'';
													?>          
                                                        <tr class="field_option field_option_label <?php echo $active_label;?> ">
                                                            <td class="label" width="25%">
                                                              <?php echo esc_html( $attribute_term['label'] ); ?> 
                                                            </td>
                                                            <td class="section-color-swatch">
                                                       
														<?php
                                                       
                                                        $options = atawcvs_get_option('atawc_label');
                                                        $width = ( isset( $options['lebel_variation_width'] ) && $options['lebel_variation_width'] != "" ) ? $options['lebel_variation_width'] : 44 ;
                                                        $height = ( isset( $options['lebel_variation_height'] ) && $options['lebel_variation_height'] != "" ) ? $options['lebel_variation_height'] : 44 ;
                                                        $style = ( isset( $options['lebel_variation_style'] ) && $options['lebel_variation_style'] != "" ) ? $options['lebel_variation_style'] : 'square' ;
														
                                                        
                                                        printf( '<div class="swatch-preview swatch-label %4$s" style="width:%2$spx; height:%2$spx ; line-height:%2$spx">%s</div>', esc_html( $attribute_term['label'] ), $width, $height, $style );
                                                        ?>
                                                                
                                                            </td>
                                                        </tr>
                                    
                                                       
                                                    </tbody>
                                                </table>
                                            
                                        </div>
                                    
                                    </div>
                            
                                    
                                <?php endforeach; ?>
                            </div>
						
					</div>
					<?php
				endforeach;
			else :
				echo '<p>' . __( 'Add a at least one attribute / variation combination to this product that has been configured with color swatches or photos. After you add the attributes from the "Attributes" tab and create a variation, save the product and you will see the option to configure the swatch or photo picker here.', 'smart-variation-swatches' ) . '</p>';
			endif;
			?>


		</div>

		<?php
		echo '</div>';

	

		remove_filter( 'woocommerce_variation_is_visible', array($this, 'return_true') );
 	   
    }
	public function process_meta_box( $post_id, $post ) {
	
        $product = wc_get_product($post_id);

		$swatch_type_options = isset( $_POST['_swatch_type_options'] ) ? $_POST['_swatch_type_options'] : false;
		$swatch_type = 'default';

		if ( $swatch_type_options && is_array( $swatch_type_options ) ) {
			foreach ( $swatch_type_options as $options ) {
				if ( isset( $options['type'] ) && $options['type'] != 'default' && $options['type'] != 'radio' ) {
					$swatch_type = 'pickers';
					break;
				}
			}

			$product->update_meta_data('_swatch_type_options', $swatch_type_options );
		}

		$product->update_meta_data('_swatch_type', $swatch_type );
		$product->save_meta_data();
	}
	public function return_true() {
		return true;
	}
	
	

}


