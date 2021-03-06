<?php

/**
 *
 *	WooCommerce specific functions
 *	@since 1.0
 *
 */
 
 
/**
 * Register WooCommerce Sidebar(s)
 * The theme features different sidebars for WooCommerce pages
 * @since 1.0
 */

genesis_register_widget_area( array(          
	'name' => 'WooCommerce Primary SB',
	'id' => 'cuttz-woo-primary-sb',
	'description' => 'This is the primary sidebar for WooCommerce pages.'
) );

genesis_register_widget_area( array(          
	'name' => 'WooCommerce Secondary SB',
	'id' => 'cuttz-woo-secondary-sb',
	'description' => 'This is the secondary sidebar for WooCommerce pages.'
) );


/**
 * Display WooCommerce Sidebar(s) on WooCommerce pages
 * @since 1.0
 */
 
add_action( 'genesis_before', 'cuttz_woo_sidebars' );

function cuttz_woo_sidebars() {
	$use_woo_sb = apply_filters( 'cuttz_use_woo_sidebars', true );
	if( !$use_woo_sb )
		return;
	
	if( is_woocommerce() || is_cart() || is_checkout() ) {
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
		remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
		add_action( 'genesis_sidebar', 'cuttz_woo_do_sidebar' );
		add_action( 'genesis_sidebar_alt', 'cuttz_woo_do_sidebar_alt' );
	}
}

function cuttz_woo_do_sidebar() {
	if ( ! dynamic_sidebar( 'cuttz-woo-primary-sb' ) && current_user_can( 'edit_theme_options' )  ) {
		genesis_default_widget_area_content('WooCommerce Primary SB Widget Area' );
	}
}

function cuttz_woo_do_sidebar_alt() {
	if ( ! dynamic_sidebar( 'cuttz-woo-secondary-sb' ) && current_user_can( 'edit_theme_options' )  ) {
		genesis_default_widget_area_content( 'WooCommerce Secondary SB Widget Area' );
	}
}

/**
 * Force WooCommerce checkout page to use full-width-content layout
 * The theme features full width layout for checkout page
 * The layout for checkout page defaults to Full Width Content and can be updated by the user through Genesis in-post layout settings.
 * @since 1.0
 */
 
add_action( 'wp_head', 'cuttz_woo_pages_customization' );

function cuttz_woo_pages_customization() {
	if( is_product() || is_checkout() || is_account_page() ) {
		add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');
	}
	// Disable the custom widget areas on certain pages
	if( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) {
		remove_action( 'genesis_before_header', 'cuttz_sidebar_before_header' );
		remove_action( 'genesis_after_header', 'cuttz_sidebar_after_header' );
		remove_action( 'genesis_before_footer', 'cuttz_sidebar_above_footer', 5 );
	}
}

/**
 * Display Out Of Stock notice for products on the main shop page
 */

add_action( 'woocommerce_before_shop_loop_item', 'cuttz_woo_out_of_stock_shop_notice', 8 );

function cuttz_woo_out_of_stock_shop_notice() {
	global $product;
    if ( !$product->managing_stock() && !$product->is_in_stock() ) {
		$no_stock_message = __( 'Out of Stock', 'cuttz-framework' );
		echo '<div class="no-stock-notice"><p class="stock out-of-stock">' . apply_filters( 'cuttz_woo_no_stock_text', $no_stock_message ) . '</p></div>';
	}
}