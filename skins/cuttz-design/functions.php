<?php

/**
 * Cuttz µFramework Core Skin
 * Skin Name: Cuttz Design
 * Highlights: Flat UI design, beautiful typography, multiple landing page styles
 */

/**
 * Setting up the skin defaults for Cuttz design
 * @return array
 * @since 1.0
 */

add_filter( 'cuttz_skin_defaults', 'cuttzd_skin_defaults' );
function cuttzd_skin_defaults( $defaults ) {
	
	$defaults['skin-version'] = 'false';
	$defaults['layout']         = 'fullwidth';
	$defaults['col-spacing']         = '50';
	$defaults['column-content-1col'] = '925';
	$defaults['column-content-2col'] = '600';
	$defaults['sidebar-one-2col']    = '275';
	$defaults['column-content-3col'] = '425';
	$defaults['sidebar-one-3col']    = '200';
	$defaults['sidebar-two-3col']    = '200';
	$defaults['body-font-family']					= 'roboto';
	$defaults['body-font-weight']					= '300';
	$defaults['body-font-size'] = '15';
	$defaults['form-font-size'] = '14';
	$defaults['site-background-color'] = '#ffffff';
	$defaults['page-background-color'] = '#ffffff';
	$defaults['primary-text-color']    = '#333333';
	$defaults['primary-link-color']    = '#00aaff';
	$defaults['primary-link-hover-color']    = '#00aaff';
	$defaults['form-font-family']					= 'roboto';
	$defaults['form-text-color']       = '#757575';
	$defaults['site-title-font-color']  = '#ffffff';
	$defaults['site-title-font-size']   = '54';
	$defaults['site-title-font-family']				= 'tangerine';
	$defaults['site-title-font-weight']				= '700';	
	$defaults['site-description-font-color']  = '#ffffff';
	$defaults['site-description-font-size']   = '13';
	$defaults['site-description-font-family']		= 'raleway';
	$defaults['site-description-font-weight']  		= 'regular';
	$defaults['headline-font-family']				= 'roboto';
	$defaults['headline-font-weight']				= '500';
	$defaults['headline-font-color']  = '#404040';
	$defaults['headline-font-size']   = '32';	
	$defaults['headline-subhead-font-color']  = '#404040';
	$defaults['headline-subhead-font-family']		= 'roboto';
	$defaults['headline-subhead-font-weight']		= '500';
	$defaults['nav-menu-font-family']				= 'roboto';
	$defaults['nav-menu-font-weight']				= '300';
	$defaults['nav-menu-font-size']                      = '14';
	$defaults['nav-menu-link-text-color']                = '#757575';
	$defaults['nav-menu-link-text-hover-color']          = '#00aaff';
	$defaults['nav-menu-current-link-text-color']        = '#00aaff';
	$defaults['nav-menu-current-parent-link-text-color'] = '#00aaff';
	$defaults['nav-menu-link-bg-color']                  = '#eeeeee';
	$defaults['nav-menu-hover-bg-color']                 = '#eeeeee';
	$defaults['nav-menu-current-bg-color']               = '#eeeeee';
	$defaults['nav-menu-current-parent-bg-color']        = '#eeeeee';
	$defaults['nav-menu-border-width']                   = '0';
	$defaults['nav-menu-border-color']                   = '#dddddd';
	$defaults['nav-menu-submenu-width']                  = '250';	
	$defaults['subnav-menu-font-family']			= 'roboto';
	$defaults['subnav-menu-font-weight']			= 'regular';
	$defaults['subnav-menu-font-size']                      = '13';
	$defaults['subnav-menu-link-text-color']                = '#ffffff';
	$defaults['subnav-menu-link-text-hover-color']          = '#00aaff';
	$defaults['subnav-menu-current-link-text-color']        = '#00aaff';
	$defaults['subnav-menu-current-parent-link-text-color'] = '#00aaff';
	$defaults['subnav-menu-link-bg-color']                  = '#282a2b';
	$defaults['subnav-menu-hover-bg-color']                 = '#282a2b';
	$defaults['subnav-menu-current-bg-color']               = '#282a2b';
	$defaults['subnav-menu-current-parent-bg-color']        = '#282a2b';
	$defaults['subnav-menu-border-width']                   = '0';
	$defaults['subnav-menu-border-color']                   = '#eee';
	$defaults['subnav-menu-submenu-width']                  = '200';	
	$defaults['byline-font-family']					= 'roboto';
	$defaults['byline-font-weight']					= '300';	
	$defaults['byline-font-color']  = '#404040';
	$defaults['byline-font-size']   = '13';
	$defaults['sidebar-font-family']				= 'roboto';
	$defaults['sidebar-font-weight']				= '300';
	$defaults['sidebar-font-color']          = '#404040';
	$defaults['sidebar-font-size']           = '14';
	$defaults['sidebar-heading-font-family']		= 'roboto';
	$defaults['sidebar-heading-font-weight']		= '500';
	$defaults['sidebar-heading-font-size']   = '16';
	$defaults['sidebar-heading-font-color']  = '#757575';	
	$defaults['footer-widgets-font-family']			= 'roboto';
	$defaults['footer-widgets-font-weight']			= '300';
	$defaults['footer-widgets-font-color']          = '#aaaaaa';
	$defaults['footer-widgets-font-size']           = '14';	
	$defaults['footer-widgets-heading-font-family']	= 'roboto';
	$defaults['footer-widgets-heading-font-weight']	= '500';
	$defaults['footer-widgets-heading-font-size']   = '16';
	$defaults['footer-widgets-heading-font-color']  = '#cccccc';	
	$defaults['footer-font-family']					= 'roboto';
	$defaults['footer-font-weight']					= 'regular';
	$defaults['footer-font-color']  = '#999999';
	$defaults['footer-font-size']   = '13';
	$defaults['cuttz-web-fonts'] = 'Roboto:300|Tangerine:700|Roboto|Tangerine:700|Raleway:regular|Roboto:500|Roboto:500|Roboto:300|Roboto:regular|Roboto:300|Roboto:300|Roboto:500|Roboto:300|Roboto:500|Roboto:regular';
	
    return $defaults;
	
}

/**
 * Defining Cuttz design skin styles dependent on skin settings
 * @param $css 
 * @param $settings 
 * @param $widths 
 * @return array
 * @since 1.0
 */

add_filter( 'cuttz_settings_css', 'cuttzd_design_css', 10, 3 );

function cuttzd_design_css($css, $settings, $widths) {
	$css = $css . '.nav-primary { background-color:'.$settings['nav-menu-link-bg-color'].'; }';
	$css = $css . '.nav-secondary { background-color:'.$settings['subnav-menu-link-bg-color'].'; }';
	$css = $css . '.author-box-title { font-weight:'.$settings['headline-font-weight'].'; }';
	return $css;
}

/**
 * Dynamic media queries
 * @param $resp_css 
 * @param $widths 
 * @param $settings
 * @return array
 * @since 1.0
 */

add_filter( 'cuttz_media_queries', 'cuttzd_design_responsive', 10, 3 );

function cuttzd_design_responsive($resp_css, $widths, $settings) {
	$resp_css['min-width'] = $resp_css['min-width']. 'body.cuttz-design .nav-secondary .menu-secondary {float: none; display: block;}';
	$resp_css['min-width'] = $resp_css['min-width']. 'body.cuttz-design .nav-secondary .menu > li:last-child a {margin-right: 0;}';
	$resp_css['min-width'] = $resp_css['min-width']. '.cuttz-design .genesis-nav-menu .sub-menu a {border-left: none;}';
	$resp_css['min-width'] = $resp_css['min-width']. '.cuttz-design .sub-menu-toggle {padding: 0.9em}';
	$resp_css['min-width'] = $resp_css['min-width']. 'body.cuttz-design .nav-primary .menu > li:first-child a {margin-left: 0;}';
	return $resp_css;
}


/**
 * Define new image size for sidebar images
 * @since 1.0
 */

add_image_size( 'sb-thumb', 300, 150, true );


/**
 * Enqueue Cuttz design skin specific scripts
 * @since 1.0
 */

add_action( 'wp_enqueue_scripts', 'cuttzd_design_scripts' );

function cuttzd_design_scripts() {
	wp_enqueue_script( 'pace-script', SKIN_URL . '/scripts/pace.min.js', array(), false, true );
	wp_enqueue_script( 'cuttz-design-scripts', SKIN_URL . '/scripts/cuttz_design_scripts.js', array(), false, false );
	wp_enqueue_script( 'cuttz-easing', SKIN_URL . '/scripts/jquery.easing.js', array(), false, false );
	wp_enqueue_script( 'cuttz-fade-this', SKIN_URL . '/scripts/jquery.fadethis.min.js', array(), false, true );
}


/**
 * Enable post navigation for single posts
 * @since 1.0
 */

add_action( 'genesis_entry_footer', 'cuttzd_prev_next_post_nav' );

function cuttzd_prev_next_post_nav() {
	if ( ! is_singular( 'post' ) )
		return;

	genesis_markup( array(
		'html5'   => '<div %s>',
		'xhtml'   => '<div class="navigation">',
		'context' => 'adjacent-entry-pagination',
	) );
	echo '<div class="pagination-previous">';
	previous_post_link( '%link', _x( '&laquo; %title', 'cuttz-framework' ));
	echo '</div>';
	echo '<div class="pagination-next">';
	next_post_link('%link', _x( '%title &raquo;', 'cuttz-framework' ));
	echo '</div>';
	echo '</div>';
}


/**
 * Execute WooCommerce specific filters
 * Verify if WooCommerce is installed and active before filters are called
 * @since 1.0
 **/
 
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	add_filter( 'loop_shop_columns', 'cuttzd_shop_page_display_columns' );
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	add_action( 'wp_head', 'cuttzd_wooc_pages_customization' );
}


/**
 * WooCommerce Shop page customization
 * Callback to show 3 columns grid
 */

function cuttzd_shop_page_display_columns() {
	return 3;
}


/**
 * Page specific customizations for WooCommerce pages
 */

function cuttzd_wooc_pages_customization() {
	if( is_cart() ) {
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
	}
}