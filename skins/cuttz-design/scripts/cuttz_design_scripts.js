jQuery(document).ready(function() {
	
	/* Fade effects */
	
	jQuery(window).fadeThis({
		offset: -200
	});
	
	/* Add clearfix after payment box on Checkout page */
	
	jQuery( '<div class="clear"></div>' ).insertAfter( '.woocommerce-checkout #payment' );
	
	/* Eliminate the separator in the product categories on single product */
	
	jQuery('.woocommerce.single .posted_in:contains(",")').each(function(){
		jQuery(this).html(jQuery(this).html().split(',').join(''));
	});
	
});	