/*
   Document   : frontend.js
   Author: Saiful
   Author e-mail: e2getway@gmail.com
   Version: 1.0.0
*/
;(function ( $ ) {
	'use strict';

	/**
	 * @TODO Code a function the calculate available combination instead of use WC hooks
	 */
	$.fn.atawc_variation_swatches_form = function () {
		return this.each( function() {
			var $form = $( this ),
				clicked = null,
				selected = [];

			$form
				.addClass( 'swatches-support' )
				.on( 'click', '.swatch,.swatch_radio', function ( e ) {
					e.preventDefault();
					var $el = $( this ),
						$select = $el.closest( '.value' ).find( 'select' ),
						attribute_name = $select.data( 'attribute_name' ) || $select.attr( 'name' ),
						value = $el.data( 'value' );

					$select.trigger( 'focusin' );
					$select.hide();
					// Check if this combination is available
					if ( ! $select.find( 'option[value="' + value + '"]' ).length ) {
						$el.siblings( '.swatch' ).removeClass( 'selected' );
						$select.val( '' ).change();
						$form.trigger( 'atawc_no_matching_variations', [$el] );
						return;
					}

					clicked = attribute_name;

					if ( selected.indexOf( attribute_name ) === -1 ) {
						selected.push(attribute_name);
					}
					
					if ( $el.hasClass( 'selected' ) ) {
						$select.val( '' );
						$el.removeClass( 'selected' );

						delete selected[selected.indexOf(attribute_name)];
					} else {
						$el.addClass( 'selected' ).siblings( '.selected' ).removeClass( 'selected' );
						$select.val( value );
					}
					 if( $(this).parents('li.product').length ){
						/*alert( $(this).data('variations_id') );
						$(this).parents('li.product').find('.variation_id').val('siaul');*/
					 }

					$select.change();
				} )
				.on( 'click', '.reset_variations', function () {
					$( this ).closest( '.variations_form' ).find( '.swatch.selected' ).removeClass( 'selected' );
					selected = [];
				} )
				.on( 'atawc_no_matching_variations', function() {
					window.alert( wc_add_to_cart_variation_params.i18n_no_matching_variations_text );
				} );
		} );
	};

	$( function () {
		
		$( '.variations_form' ).atawc_variation_swatches_form();
		
		$( document.body ).trigger( 'atawc_initialized' );
		
		if( $('.masterTooltip').length ){
			$('.masterTooltip').hover(function(){
					// Hover over code
					var title = $(this).attr('title');
					if(title != ""){
					$(this).data('tipText', title).removeAttr('title');
					$('<span class="ed-tooltip"></span>')
					.text(title)
					.appendTo('body')
					//.appendTo($(this).parents('.ed_woo_variations_wrp'))
					.fadeIn('slow');
					}
					
			}, function() {
					// Hover out code
					$(this).attr('title', $(this).data('tipText'));
				   $('.ed-tooltip').remove();
			}).mousemove(function(e) {
					var mousex = e.pageX ; //Get X coordinates
					var mousey = e.pageY -50; //Get Y coordinates
					$('.ed-tooltip')
					.css({ top: mousey, left: mousex })
			});
		}
		
		/*--------------------------------------*/
		/*--------------------------------------*/
		  var price_element 	= '',
		  	  product_attr      = jQuery.parseJSON( $(".variations_form").attr("data-product_variations") ),
			  variation_id 		= '';
		
		 $('input.variation_id').change( function(){
			
			
			 if( $(smart_variable.__price_update_on).length ){
				 price_element = smart_variable.__price_update_on;
				 
			 }else{
				 price_element = '.' + smart_variable.__price_update_on;
				 
			 }
			
			 if( $(this).parents('li.product').length ){
				
				 price_element   = $(this).parents('li.product').find( price_element );
				 product_attr    =   jQuery.parseJSON( $(this).parents('li.product').find(".variations_form").attr("data-product_variations") );
				 
				 variation_id  =  $(this).parents('li.product').find('input.variation_id').val() ;
				 
			 }else{
				 variation_id   = $('input.variation_id').val(); 
			 }
			 
			 // Get Variations
			jQuery.each( product_attr, function( index, loop_value ) {
			
				
				if( variation_id == loop_value.variation_id && typeof loop_value.price_html != "undefined" ){
					 
				 	$(price_element).html( loop_value.price_html + loop_value.availability_html);
					 
				}
				
			});
			
			 
        
        });
		
		/*--------------------------------------*/
		/*--------------------------------------*/
	} );
})( jQuery );