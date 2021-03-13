/*
   Document   : admin.js
   Author: Saiful
   Author e-mail: e2getway@gmail.com
   Version: 1.0.0
*/
var frame,
	atawc = atawc || {};

jQuery( document ).ready( function ( $ ) {
'use strict';


	var wp = window.wp,
	$document = $(document);
	var frame,file_frame;
	
	$( '#term-color,.atawc_color_picker' ).wpColorPicker();

	
	
	
	

	if($('.ata_woo_meta_uploader')){
		$(document).on('click', '.ata_woo_meta_uploader', function(e) {
			
			e.preventDefault();
			var that = $(this);
			
			if (file_frame) file_frame.close();
		
			file_frame = wp.media.frames.file_frame = wp.media({
			  title: $(this).data('uploader-title'),
			  button: {
				text: $(this).data('uploader-button-text'),
			  },
			  multiple: true
			});
		
			file_frame.on('select', function() {
			 var attachment = file_frame.state().get( 'selection' ).first().toJSON();
			 
			
				that.parents('.attribute_woo_var_style_img_row').find('input[type=hidden]').val( attachment.id );
				
				that.parents('.attribute_woo_var_style_img_row').find('img').attr( 'src', attachment.url );
				
				
			});
		
			file_frame.open();
		
		  }).on( 'click', '.remove_ata_woo_meta_img', function (e) {
			e.preventDefault();
			var that = $(this);
			
			that.parents('.attribute_woo_var_style_img_row').find('input[type=hidden]').val( '' );
			that.parents('.attribute_woo_var_style_img_row').find('img').attr( 'src', atawc.placeholder );
			
		} );
	
	}
	
	if( $('._swatch_type_options_type').length ){
	$document.on('change', '._swatch_type_options_type', function(e) {
		$(this).parents('.ata_wcvs_meta_wrp').find('.field_option').hide();
		if( $(this).val() === 'product_color' ){
			$(this).parents('.ata_wcvs_meta_wrp').find('.field_option_color').show()
		}else if( $(this).val() === 'product_image' ){
			$(this).parents('.ata_wcvs_meta_wrp').find('.field_option_image').show()
		}else if( $(this).val() === 'product_lebel' ){
			$(this).parents('.ata_wcvs_meta_wrp').find('.field_option_label').show()
		}
	});
	}
	
	if( $('.nav-tab').length ){
		$document.on('click', '.nav-tab', function(e) {
			var target = $(this).attr('href');
			
			if( target.match(/atawc_tutorials/g) ){	
				// location.replace( bcf_url.home + target);
				 window.open("https://athemeart.com/docs/smart-variation-swatches-plugins-documentation/installation/"); 
			}
		});
	
	}
	 

} );

