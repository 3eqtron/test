<?php

/**
 * Class ATA_WC_Variation_Swatches_Frontend
 */
class ATA_WC_Variation_Swatches_Frontend_Arachive {
	/**
	 * The single instance of the class
	 *
	 * @var ATA_WC_Variation_Swatches_Frontend
	 */
	protected static $instance = null;
	
	
	 protected $options = array();	
	

	/**
	 * Class constructor.
	 */
	public function __construct() {
		
		$this->options = atawcvs_get_option('archive_settings');
		//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		if( $this->options['__swatches_display_on_archive'] == "off" ){ return; }
		
		//if( is_product_category() || is_shop() ) return ;
		
		
		/*if( $this->options['__swatches_archive_behavior'] == "add_to_cart" ){
			
			add_action('woocommerce_after_shop_loop_item',  array( $this, 'woo_display_variation_dropdown_on_shop_page' ), 999);
			add_filter('woocommerce_loop_add_to_cart_link',  array( $this, 'smart_loop_add_to_cart_link' ));
			
		 }else{
			
			 if( $this->options['__swatches_display_position_on_arch'] == "before_add_to_cart" ){
				  add_action('woocommerce_after_shop_loop_item',  array( $this, 'archive_product_filter_by_attribute' ), 5);
			 }else {
				 add_action('woocommerce_after_shop_loop_item_title',  array( $this, 'archive_product_filter_by_attribute' ), 999);
			 }
			 
		 }*/

		 add_action('woocommerce_after_shop_loop_item',  array( $this, 'woo_display_variation_dropdown_on_shop_page' ), 999);
			add_filter('woocommerce_loop_add_to_cart_link',  array( $this, 'smart_loop_add_to_cart_link' ));
	}
	
	public function archive_product_filter_by_attribute( $args ){
		global $product;

		if( $product->is_type( 'variable' )) {
		
		
				$raw_url = get_the_permalink( wc_get_page_id( 'shop' ) );
				
				if ( preg_match("/\?/", $raw_url ) ) {
					
					$url = esc_url ( get_site_url().'/?post_type=product' );
					
				}else{
					
					$url = esc_url( get_the_permalink( wc_get_page_id( 'shop' ) ) );
					
				}
						
		
			$attributes = $product->get_variation_attributes();
			
			//echo $attribute->attribute_name;
			if( !empty ( $attributes )  ) :
			
			foreach ( $attributes as $attribute_name => $options ) : 
			
				echo '<div class="atawc-swatches" data-attribute_name="attribute_pa_size">';
				
				
				$url = add_query_arg( 'smart_taxonomy', $attribute_name, $url );
				
				$atrr = ATA_WCVS()->get_tax_attribute( $attribute_name );
				if( empty( $atrr ) ) return ;
				$selected = $product->get_variation_default_attribute( $attribute_name );
				
				if( $this->options['__swatches_archive_label'] =="on" ){
					echo '<span class="archive_swatches_name">'.esc_html( $atrr->attribute_name ).'</span>';
				}
				
				foreach( get_terms(  $attribute_name ) as $term){
					
					$url = add_query_arg( 'slug_terms', $term->slug, $url );
					$selected  = ( $selected ==  $term->slug ) ?  'selected':'';
					
					$value = get_term_meta( $term->term_id, $atrr->attribute_type, true );
					$meta_value = get_term_meta( $term->term_id, $atrr->attribute_type);
					
					echo $this->archive_swatches(  $atrr->attribute_type, $url, $selected = NULL, $term->name, $meta_value);
				}
				
				echo '</div>';
				
			endforeach;
			endif;
			
		
		}
	}
	public function archive_swatches( $type, $url, $selected = NULL, $label, $meta_value = NULL ){
		
		$options		 = atawcvs_get_option('archive_settings');
		
		$height 		 = !empty( $options['__swatches_archive_height'] ) ? $options['__swatches_archive_height'] : 30;
		$width 			 = !empty( $options['__swatches_archive_width'] )  ? $options['__swatches_archive_width']  : 30;
		$tick_sign		 = ( isset( $options['__archive_variation_style'] ) && $options['__archive_variation_style'] != "" ) ? $options['__archive_variation_style'] : 'round' ;
		$tooltip		 = $options['__swatches_archive_tooltip'] == 'on' ?  'masterTooltip' : '';
		$meta_value		 = !empty( $meta_value ) ? $meta_value[0] : '';
		$html			 = '';
		
		switch ( $type ) {
				
			case 'color':
				$html = sprintf(
						'<a href="%1$s" class="swatch swatch-color %2$s %3$s %4$s" title="%5$s" style="background-color:%6$s; width:%7$spx; height:%8$spx;"></a>',
						esc_url( $url ),
						$tick_sign,
						$tooltip,
						$selected,//4
						$label,
						$meta_value,
						$width,
						$height
						
					);
			break;
			case 'label':
				
				$html = sprintf(
						'<a href="%1$s" class="swatch swatch-label %2$s %3$s %4$s" title="%5$s" style="width:%6$spx; height:%7$spx;">%8$s</a>',
						esc_url( $url ),
						$tick_sign,
						$tooltip,
						$selected,//4
						$label,
						$width,
						$height,
						$label
					);
			
			break;
			case 'image':
			
			$image = absint( $meta_value )  ? wp_get_attachment_image_src( absint( $meta_value)  ,'thumbnail'  ) : '';
				
			$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				   
			$html = sprintf(
						'<a href="%1$s" class="swatch %2$s %3$s %4$s" title="%5$s"><img src="%8$s" alt="%9$s" style="width:%6$spx; height:%7$spx;" /> </a>',
						esc_url( $url ),
						$tick_sign,
						$tooltip,
						$selected,//4
						$label,
						$width,
						$height,
						$image,
						$label
					);
			break;
			
			default:
				
		}
		
		
					
					
		return $html;	
		
	}
	public function smart_loop_add_to_cart_link( $args ){
			global $product;

		if( $product->is_type( 'variable' )) return;
		
		return $args;
	}
	public function woo_display_variation_dropdown_on_shop_page() {
		
	 	if( is_product_category() || is_shop() ) { 
	 
	 	 remove_action('woocommerce_single_variation','woocommerce_single_variation',10);
		 //remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	  	}
	 
	 
 	global $product;

	if( $product->is_type( 'variable' )) {
	
	wp_enqueue_script( 'wc-add-to-cart-variation' );
	//$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
	
	$attributes = $product->get_variation_attributes();
	
	$variations_json = wp_json_encode( $product->get_available_variations() );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
	
	do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $attributes ) && false !== $attributes ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php $i=0; foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
                    	<?php if( $this->options['__swatches_archive_label'] =="on" ){ ?>
						<td class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></td>
                        <?php }?>
						<td class="value">
							<?php
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									)
								);
								$i++;
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="single_variation_wrap smart-swatches-archive-box">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );


	
	 }
	 
}


/**
	 * Main instance
	 *
	 * @return ATA_WC_Variation_Swatches_Frontend
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	
}