<?php

if ( function_exists( 'is_bbPress' ) && !class_exists( 'BBP_Genesis' ) ) {
	require_once CHILD_DIR . '/lib/functions/bbpress-ready.php';
}
require_once( CHILD_DIR . '/lib/functions/fonts.php' );
require_once( CHILD_DIR . '/lib/functions/cuttz-mobile-detection.php' );
require_once( CHILD_DIR . '/lib/functions/schema-mgt.php' );
require_once( CHILD_DIR . '/lib/functions/menu-mgt.php' );
require_once( CHILD_DIR . '/lib/functions/landing-sections-mgt.php' );
require_once( CHILD_DIR . '/lib/functions/landing-page-settings.php' );
require_once( CHILD_DIR . '/lib/functions/mobile-template-settings.php' );
require_once( CHILD_DIR . '/lib/functions/cuttz-custom-layout-style.php' );
/*
require_if_theme_supports( 'cuttz-schema', CHILD_DIR . '/lib/functions/schema-mgt.php' );
require_if_theme_supports( 'cuttz-custom-menus', CHILD_DIR . '/lib/functions/menu-mgt.php' );
require_if_theme_supports( 'cuttz-landing-sections', CHILD_DIR . '/lib/functions/landing-sections-mgt.php' );
require_if_theme_supports( 'cuttz-landing-page-experience', CHILD_DIR . '/lib/functions/landing-page-settings.php' );
require_if_theme_supports( 'cuttz-mobile-landing-page-experience', CHILD_DIR . '/lib/functions/mobile-template-settings.php' );
require_if_theme_supports( 'cuttz-layout-style', CHILD_DIR . '/lib/functions/cuttz-custom-layout-style.php' );
*/
require_once( CHILD_DIR . '/lib/functions/cuttz-custom-template-box.php' );
require_once( CHILD_DIR . '/lib/functions/shortcodes.php' );
require_once( CHILD_DIR . '/lib/functions/I18n.php' );

// Extended WooCommerce Control
if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) ) {
	require_once( CHILD_DIR . '/lib/functions/cuttz-woocommerce.php' );
}

/* Theme supports */
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'  ) );
add_theme_support( 'genesis-connect-woocommerce' );
add_theme_support( 'genesis-after-entry-widget-area' );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'post-formats', array(
	'aside',
	'audio',
	'chat',
	'gallery',
	'image',
	'link',
	'quote',
	'status',
	'video'
) );
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'menu-primary',
	'menu-secondary',
	'cuttz-nav-above',
	'cuttz-nav-below',
	'cuttz-nav-footer',
	'inner',
	'after-header-first',
	'after-header-second',
	'after-header-third',
	'before-footer-first',
	'before-footer-second',
	'before-footer-third',
	'footer-widgets',
	'footer'
) );
add_theme_support( 'genesis-menus', array(
	'primary' => 'Primary Navigation Menu',
	'secondary' => 'Secondary Navigation Menu',
	'footer_menu' => 'Footer Menu'
) );
add_theme_support( 'genesis-accessibility', array(
	'404-page',
	'headings',
	'search-form',
) );

/* Post type supports */
add_action( 'init', 'cuttz_post_type_supports', 15 );

function cuttz_post_type_supports() {
	add_post_type_support( 'page', 'cuttz-schema' );
	add_post_type_support( 'page', 'cuttz-landing-page-experience' );
	add_post_type_support( 'page', 'cuttz-mobile-experience' );
	add_post_type_support( 'page', 'cuttz-custom-menu-locations' );
	add_post_type_support( 'page', 'cuttz-landing-sections' );
	add_post_type_support( 'page', 'cuttz-custom-layout-styles' );
	add_post_type_support( 'post', 'cuttz-schema' );
	add_post_type_support( 'post', 'cuttz-landing-page-experience' );
	add_post_type_support( 'post', 'cuttz-mobile-experience' );
	add_post_type_support( 'post', 'cuttz-custom-menu-locations' );
	add_post_type_support( 'post', 'cuttz-landing-sections' );
	add_post_type_support( 'post', 'cuttz-custom-layout-styles' );
}

add_editor_style( 'editor-style.css' );

remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav', 2 );
add_action( 'genesis_footer', 'cuttz_do_nav_footer', 5 );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_content_sidebar_wrap', 'cuttz_do_breadcrumbs' );
add_action( 'wp_enqueue_scripts', 'cuttz_enqueue_jquery' );
add_action( 'wp_enqueue_scripts', 'cuttz_res_menu_output' );
add_action( 'wp_enqueue_scripts', 'cuttz_retina_script' );
add_action( 'wp_enqueue_scripts', 'cuttz_scripts' );
remove_action( 'wp_head', '_ak_framework_meta_tags' );
add_action( 'wp_head', 'cuttz_logo' );
add_action( 'widgets_init', 'cuttz_register_sidebars' );
add_action( 'wp_head', 'cuttz_widgetize', 5 );

add_filter( 'genesis_seo_title', 'cuttz_title', 10, 3 );
add_filter( 'genesis_seo_description', 'cuttz_desc', 10, 3 );
add_filter( 'wp_nav_menu', 'cuttz_nav_trim', 10, 2 ); // Remove spaces between html markup to support inline-block style.
add_filter( 'edit_post_link', 'cuttz_post_edit_link' );
add_filter( 'genesis_attr_cuttz-nav-above', 'genesis_attributes_nav' );
add_filter( 'genesis_attr_cuttz-nav-below', 'genesis_attributes_nav' );
add_filter( 'genesis_attr_cuttz-nav-footer', 'genesis_attributes_nav' );
add_filter( 'post_class', 'cuttz_post_classes' );
add_action( 'genesis_entry_content', 'show_read_more_on_excerpt' );
add_filter( 'genesis_prev_link_text', 'cuttz_previous_page_link' );
add_filter( 'genesis_next_link_text', 'cuttz_next_page_link' );
add_filter( 'genesis_post_date_shortcode', 'cuttz_post_date_shortcode' );
add_filter( 'genesis_footer_genesis_link_shortcode', 'cuttz_genesis_link_output', 10, 2 );
add_filter( 'genesis_footer_creds_text', 'cuttz_footer_creds' );
add_filter( 'genesis_footer_output', 'cuttz_footer_output', 10, 3 );
add_filter( 'widget_text', 'do_shortcode' ); // Enable shortcodes support in widgets

unregister_sidebar( 'header-right' );

add_action( 'admin_menu', 'cuttz_menus', 999 );

/**
 * Output the custom widget areas on the front-end
 * @return none
 */
function cuttz_widgetize() {
	add_action( 'genesis_before_header', 'cuttz_sidebar_before_header' );
	add_action( 'genesis_after_header', 'cuttz_sidebar_after_header' );
	add_action( 'genesis_before_footer', 'cuttz_sidebar_above_footer', 5 );
}