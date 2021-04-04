jQuery(document).ready( function($) {
	
	var wpcf7Error = $('.wpcf7-validation-errors');
	
	// getHAM to see if is wccpf
	var getHAM = $('.wccpf.ham');
	var isHAM = getHAM.length;
	// getNonVariationProduct to place submit btn in form, if not a variable product and just a simple product
    var isNonVariationProduct = $('.single_add_to_cart_button').length;
    if(isNonVariationProduct && isHAM) {
	    var prodForm = $('form.cart');
	    var quantity = $('.quantity:first');
	    var checkoutBtn = $('.single_add_to_cart_button');
	    prodForm.append(quantity, checkoutBtn);
    }
    if(isHAM) {
	    console.log('HAM here ' + isHAM + ' time');
	    var prodForm = $('form.cart');
	    var cf7Inputs = $('form.cart .wccpf input[type=text]');
	    var prodFormSubmitBtn = $('form.cart .single_add_to_cart_button');
	    prodForm.addClass('ham-security');
	    // find cf7 fields that are invalid
	    var getCf7NotValid = $('.wpcf7-not-valid');
	    var isCf7NotValid = getCf7NotValid.length;
	    var preventAddToCart = true;
	    var errors = [];
	    var wccpfFieldVals = [];
	    
	    function wpcf7ErrorContent() {
		    var theErrorMessage = wpcf7Error.html();
		    if(theErrorMessage != null && theErrorMessage.length) {
			    $('.summary').prepend('<h2 class="ham-error-notif" style="color:red;">'+theErrorMessage+'</h2>');
			    prodFormSubmitBtn.addClass('disabled wc-variation-selection-needed');
			}
	    } 
	    wpcf7ErrorContent();
	    
	    
	    // Validation should be handled by adding wccpf to $product->get_available_variations() array
	    /* $product = wc_get_product( $product_id );
			$product_variations = $product->get_available_variations();
			echo var_dump($product_variations); // Displaying the array
		*/
	    function fieldValidation() {
			    var isValid = isCf7NotValid < 1;				
				var all = cf7Inputs.map(function() {
					var cf7Input = $(this).val();
					if(cf7Input == '') {
						event.preventDefault();
						preventAddToCart = true;
						errors.push(1);
					} else { 
						preventAddToCart = false;
						wccpfFieldVals.push(cf7Input);
					}
				    return this.innerHTML;
				}).get();
				// console.log(all.join());
	    }
	    fieldValidation();
	    
	    cf7Inputs.on('keyup', function(event) {
		    //clear error array
		    errors.length = 0;
		    // clear form data from array
		    wccpfFieldVals.length = 0;
			// check fields
			fieldValidation();
			if(errors.length) {
				preventAddToCart = true;
				prodFormSubmitBtn.addClass('disabled wc-variation-selection-needed');
				wpcf7Error.css('display', 'block');
			} else {
				preventAddToCart = false;
				prodFormSubmitBtn.removeClass('disabled wc-variation-selection-needed');
				wpcf7Error.css('display', 'none');
			}
	    });
	    
		prodFormSubmitBtn.click(function(event) {
		    //clear error array
		    errors.length = 0;
		    // clear form data from array
		    wccpfFieldVals.length = 0;
			// check fields
			fieldValidation();
			if(errors.length) {
				event.preventDefault();
				preventAddToCart = true;
				$('.variations select').val('null');
				$('.wpcf7-submit').click();
				wpcf7ErrorContent();
			} else {
				preventAddToCart = false;
				// prodFormSubmitBtn.click();
			}
	    });
	    
    }
	
	$(document.body).on('checkout_error', function () {
	    var error_count = $('.woocommerce-error li').length;
	      
    });
	
});