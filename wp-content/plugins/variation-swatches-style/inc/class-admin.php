<?php

/**
 * Class ATA_WC_Variation_Swatches_Admin
 */
class ATA_WC_Variation_Swatches_Admin {
	/**
	 * The single instance of the class
	 *
	 * @var ATA_WC_Variation_Swatches_Admin
	 */
	protected static $instance = null;

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
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init_attribute_hooks' ) );
		add_action( 'admin_print_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'woocommerce_product_option_terms', array( $this, 'product_option_terms' ), 10, 2 );

		// Display attribute fields
		add_action( 'atawc_product_attribute_field', array( $this, 'attribute_fields' ), 10, 3 );

		
	}

	/**
	 * Init hooks for adding fields to attribute screen
	 * Save new term meta
	 * Add thumbnail column for attribute term
	 */
	public function init_attribute_hooks() {
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( empty( $attribute_taxonomies ) ) {
			return;
		}

		foreach ( $attribute_taxonomies as $tax ) {
			add_action( 'pa_' . $tax->attribute_name . '_add_form_fields', array( $this, 'add_attribute_fields' ) );
			add_action( 'pa_' . $tax->attribute_name . '_edit_form_fields', array( $this, 'edit_attribute_fields' ), 10, 2 );

			add_filter( 'manage_edit-pa_' . $tax->attribute_name . '_columns', array( $this, 'add_attribute_columns' ) );
			add_filter( 'manage_pa_' . $tax->attribute_name . '_custom_column', array( $this, 'add_attribute_column_content' ), 10, 3 );
		}

		add_action( 'created_term', array( $this, 'save_term_meta' ), 10, 2 );
		add_action( 'edit_term', array( $this, 'save_term_meta' ), 10, 2 );
		
		add_action( 'admin_head', array( $this, 'admin_head' ), 999 );
	}
	
	public function admin_head() {
		$options = atawcvs_get_option('atawc_label');
	?>
	<style type="text/css">
		.swatch-preview.round{
			border-radius:50%;
			-webkit-border-radius:50%;
			-moz-border-radius:50%;
		}
		.swatch-preview.round_corner{
			border-radius:5px;
			-webkit-border-radius:5px;
			-moz-border-radius:5px;
		}
		<?php if ( isset($options) && is_array( $options )):?> 
		.swatch-preview.swatch-label{
			font-size:<?php echo ( isset( $options ['lebel_variation_size'] ) ) ? $options ['lebel_variation_size'] : 12;?>px;
			color:<?php echo ( isset( $options ['lebel_variation_color'] ) ) ? $options ['lebel_variation_color'] : '#c8c8c8';?>;
			background:<?php echo ( isset( $options ['lebel_variation_background'] ) ) ? $options ['lebel_variation_background'] : '#fff';?>;
			border:1px solid <?php echo ( isset( $options ['lebel_variation_border'] ) ) ? $options ['lebel_variation_border'] : '#000';?>;
			
		}
		.swatch-preview.swatch-label:hover{
			color:<?php echo ( isset( $options ['lebel_variation_color_hover'] ) ) ? $options ['lebel_variation_color_hover'] : '#000';?>;
			background:<?php echo ( isset( $options ['lebel_variation_background_hover'] ) ) ? $options ['lebel_variation_background_hover'] : '#c8c8c8';?>;
			border:1px solid <?php echo ( isset( $options ['lebel_variation_border_hover'] ) ) ? $options ['lebel_variation_border_hover'] : '#c8c8c8';?>;
		}
		<?php endif;?>
		
	</style>
	<?php
	}
	/**
	 * Load stylesheet and scripts in edit product attribute screen
	 */
	public function enqueue_scripts() {
		$screen = get_current_screen();
		
		if ( strpos( $screen->id, 'edit-pa_' ) === false && strpos( $screen->id, 'product' ) === false && strpos( $screen->id, 'woocommerce_page_ata-variation-swatches' ) === false  ) {
			return;
		}

		wp_enqueue_media();

		wp_enqueue_style( 'atawc-admin', plugins_url( '/assets/css/admin.css', dirname( __FILE__ ) ), array( 'wp-color-picker' ), '20160615' );
		wp_enqueue_script( 'atawc-admin', plugins_url( '/assets/js/admin.js', dirname( __FILE__ ) ), array( 'jquery', 'wp-color-picker', 'wp-util' ), '20170113', true );

		wp_localize_script(
			'atawc-admin',
			'atawc',
			array(
				'i18n'        => array(
					'mediaTitle'  => esc_html__( 'Choose an image', 'smart-variation-swatches' ),
					'mediaButton' => esc_html__( 'Use image', 'smart-variation-swatches' ),
				),
				'placeholder' => WC()->plugin_url() . '/assets/images/placeholder.png'
			)
		);
	}

	/**
	 * Create hook to add fields to add attribute term screen
	 *
	 * @param string $taxonomy
	 */
	public function add_attribute_fields( $taxonomy ) {
		$attr = ATA_WCVS()->get_tax_attribute( $taxonomy );

		do_action( 'atawc_product_attribute_field', $attr->attribute_type, '', 'add' );
	}

	/**
	 * Create hook to fields to edit attribute term screen
	 *
	 * @param object $term
	 * @param string $taxonomy
	 */
	public function edit_attribute_fields( $term, $taxonomy ) {
		$attr  = ATA_WCVS()->get_tax_attribute( $taxonomy );
		$value = get_term_meta( $term->term_id, $attr->attribute_type, true );

		do_action( 'atawc_product_attribute_field', $attr->attribute_type, $value, 'edit' );
	}

	/**
	 * Print HTML of custom fields on attribute term screens
	 *
	 * @param $type
	 * @param $value
	 * @param $form
	 */
	public function attribute_fields( $type, $value, $form ) {
		// Return if this is a default attribute type
		if ( in_array( $type, array( 'select', 'text' ) ) ) {
			return;
		}

		// Print the open tag of field container
		printf(
			'<%s class="form-field">%s<label for="term-%s">%s</label>%s',
			'edit' == $form ? 'tr' : 'div',
			'edit' == $form ? '<th>' : '',
			esc_attr( $type ),
			( $type == 'image' || $type == 'color') ? ATA_WCVS()->types[$type] : '',
			'edit' == $form ? '</th><td>' : ''
		);

		switch ( $type ) {
			case 'image':
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				?>
               
                
                
<div class="attribute_woo_var_style_img_row">                
<img src="<?php echo esc_url( $image ) ?>" width="60px" height="60px" />

<input type="hidden" class="atawc-term-image" name="image" value="<?php echo esc_attr( $value ) ?>" />



<a href="javascript:void(0)" class="button ata_woo_meta_uploader" data-uploader-title="<?php _e( 'Add image to Attribute ', 'smart-variation-swatches' ); ?>" data-uploader-button-text="<?php _e( 'Add image to Attribute ', 'smart-variation-swatches' ); ?>  "> <?php _e( 'Upload/Add image', 'smart-variation-swatches' ); ?></a>
<a ref="javascript:void(0)" class="remove_ata_woo_meta_img button "><?php _e( 'Remove image', 'smart-variation-swatches' ); ?></a>
</div>
<div style="clear:both"></div>
				<?php
				break;
				
			case 'color':
			
				?>
				<input type="text" id="term-<?php echo esc_attr( $type ) ?>" name="<?php echo esc_attr( $type ) ?>" value="<?php echo esc_attr( $value ) ?>" />
				<?php
				break;
			default:
				?>
				
				<?php
				break;
		}

		// Print the close tag of field container
		echo 'edit' == $form ? '</td></tr>' : '</div>';
	}

	/**
	 * Save term meta
	 *
	 * @param int $term_id
	 * @param int $tt_id
	 */
	public function save_term_meta( $term_id, $tt_id ) {
		foreach ( ATA_WCVS()->types as $type => $label ) {
			if ( isset( $_POST[$type] ) ) {
				update_term_meta( $term_id, $type, $_POST[$type] );
			}
		}
	}

	/**
	 * Add selector for extra attribute types
	 *
	 * @param $taxonomy
	 * @param $index
	 */
	public function product_option_terms( $taxonomy, $index ) {
		if ( ! array_key_exists( $taxonomy->attribute_type, ATA_WCVS()->types ) ) {
			return;
		}

		$taxonomy_name = wc_attribute_taxonomy_name( $taxonomy->attribute_name );
		global $thepostid;
		?>

		<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'smart-variation-swatches' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo $index; ?>][]">
			<?php

			$all_terms = get_terms( $taxonomy_name, apply_filters( 'woocommerce_product_attribute_terms', array( 'orderby' => 'name', 'hide_empty' => false ) ) );
			if ( $all_terms ) {
				foreach ( $all_terms as $term ) {
					echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( has_term( absint( $term->term_id ), $taxonomy_name, $thepostid ), true, false ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
				}
			}
			?>
		</select>
		<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'smart-variation-swatches' ); ?></button>
		<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'smart-variation-swatches' ); ?></button>
		<button class="button fr plus atawc_add_new_attribute" data-type="<?php echo $taxonomy->attribute_type ?>"><?php esc_html_e( 'Add new', 'smart-variation-swatches' ); ?></button>

		<?php
	}

	/**
	 * Add thumbnail column to column list
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_attribute_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['thumb'] = '';
		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Render thumbnail HTML depend on attribute type
	 *
	 * @param $columns
	 * @param $column
	 * @param $term_id
	 */
	public function add_attribute_column_content( $columns, $column, $term_id ) {
		$attr  = ATA_WCVS()->get_tax_attribute( $_REQUEST['taxonomy'] );
		$value = get_term_meta( $term_id, $attr->attribute_type, true );

		switch ( $attr->attribute_type ) {
			case 'color':
				$options = atawcvs_get_option('atawc_color');
				$width = ( isset( $options['color_variation_width'] ) && $options['color_variation_width'] != "" ) ? $options['color_variation_width'] : 40 ;
				$height = ( isset( $options['color_variation_height'] ) && $options['color_variation_height'] != "" ) ? $options['color_variation_height'] : 40 ;
				$style = ( isset( $options['color_variation_style'] ) && $options['color_variation_style'] != "" ) ? $options['color_variation_style'] : 'round' ;
				
				printf( '<div class="swatch-preview swatch-color %4$s" style="background-color:%1$s; width:%2$spx; height:%3$spx"></div>', esc_attr( $value ),$width, $height, $style );
				break;

			case 'image':
				$options = atawcvs_get_option('atawc_images');
				$width = ( isset( $options['image_variation_width'] ) && $options['image_variation_width'] != "" ) ? $options['image_variation_width'] : 44 ;
				$height = ( isset( $options['image_variation_height'] ) && $options['image_variation_height'] != "" ) ? $options['image_variation_height'] : 44 ;
				$style = ( isset( $options['image_variation_style'] ) && $options['image_variation_style'] != "" ) ? $options['image_variation_style'] : 'round_corner' ;
				
				
				$image = $value ? wp_get_attachment_image_src( $value ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				printf( '<img class="swatch-preview swatch-image %4$s" src="%1$s" width="%2$spx" height="%3$spx" style="width:%2$spx; height:%2$spx">', esc_url( $image ), $width, $height, $style );
				break;

			case 'label':
				$term = get_term( $term_id ); 
				$options = atawcvs_get_option('atawc_label');
				$width = ( isset( $options['lebel_variation_width'] ) && $options['lebel_variation_width'] != "" ) ? $options['lebel_variation_width'] : 44 ;
				$height = ( isset( $options['lebel_variation_height'] ) && $options['lebel_variation_height'] != "" ) ? $options['lebel_variation_height'] : 44 ;
				$style = ( isset( $options['lebel_variation_style'] ) && $options['lebel_variation_style'] != "" ) ? $options['lebel_variation_style'] : 'square' ;
				
				printf( '<div class="swatch-preview swatch-label %4$s" style="width:%2$spx; height:%2$spx ; line-height:%2$spx">%s</div>', esc_html( $term->name ), $width, $height, $style );
				break;
			case 'radio':
				printf( '<input type="radio" name="radio[]" />');
				break;	
		}
	}

	

	
}
