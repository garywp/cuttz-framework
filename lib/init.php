<?php
$theme = wp_get_theme();
//define( 'CHILD_DOMAIN', $theme->get( 'TextDomain' ) );
define( 'CHILD_THEME_VERSION', $theme->Version );
define( 'CHILD_THEME_NAME', $theme->Name );
define( 'CHILD_THEME_NAME_WS', preg_replace( "/[\/_| -]+/u", '-', strtolower( trim( preg_replace( "/[^a-zA-Z0-9\/_| -]/u", '', CHILD_THEME_NAME ), '-' ) ) ) );
define( 'CHILD_SETTINGS_FIELD', CHILD_THEME_NAME_WS . '-settings' );
define( 'CHILD_SETTINGS_FIELD_EXTRAS', CHILD_THEME_NAME_WS . '-admin' );
define( 'CHILD_SETTINGS_FIELD_BRANDING', CHILD_THEME_NAME_WS . '-branding' );
define( 'CHILD_THEME_URL', $theme->get( 'ThemeURI' ) );
define( 'CHILD_DEVELOPER', $theme->Author );
define( 'CHILD_DEVELOPER_URL', $theme->{'Author URI'} );
define( 'CHILD_LIB_DIR', CHILD_DIR . '/lib' );
define( 'CHILD_IMAGES_DIR', CHILD_DIR . '/images' );
define( 'CHILD_ADMIN_DIR', CHILD_LIB_DIR . '/admin' );
define( 'CHILD_JS_DIR', CHILD_LIB_DIR . '/js' );
define( 'CHILD_CSS_DIR', CHILD_LIB_DIR . '/css' );
define( 'CHILD_LIB', CHILD_URL . '/lib' );
define( 'CHILD_IMAGES', CHILD_URL . '/images' );
define( 'CHILD_ADMIN', CHILD_LIB . '/admin' );
define( 'CHILD_JS', CHILD_LIB . '/js' );
define( 'CHILD_CSS', CHILD_LIB . '/css' );
define( 'CUTTZ_CORE_SKINS', CHILD_DIR . '/skins' );
define( 'CUTTZ_CORE_SKINS_URL', CHILD_URL . '/skins' );
define( 'CUTTZ_USER_SKINS', WP_CONTENT_DIR . '/uploads/cuttz-user/skins' );
define( 'CUTTZ_USER_SKINS_URL', WP_CONTENT_URL . '/uploads/cuttz-user/skins' );

require_once( CHILD_DIR . '/lib/admin/cuttz-admin.php' );
require_once( CHILD_DIR . '/lib/admin/cuttz-design-settings.php' );
require_once( CHILD_DIR . '/lib/admin/cuttz-branding-admin.php' );
require_once( CHILD_DIR . '/lib/functions/misc.php' );
require_once( CHILD_DIR . '/lib/functions/init.php' );
require_once( CHILD_DIR . '/lib/functions/css-gen.php' );
require_once( 'lib_scssphp/scss.inc.php' );

add_action( 'admin_init', 'cuttz_hide_notices' );
add_action( 'after_setup_theme', 'cuttz_global_vars' );
add_action( 'after_switch_theme', 'cuttz_generate_css' );
add_action( 'update_option_' . CHILD_SETTINGS_FIELD_EXTRAS, 'cuttz_generate_skin_css' );
add_action( 'wp_enqueue_scripts', 'cuttz_semantic_ui', 5 );
add_action( 'wp_enqueue_scripts', 'cuttz_settings_css' );
add_action( 'wp_enqueue_scripts', 'cuttz_customizations_css' );
add_action( 'wp_enqueue_scripts', 'cuttz_user_css' );

add_filter( 'body_class', 'cuttz_body_classes' );
add_filter( 'admin_body_class', 'cuttz_admin_body_classes' );
add_filter( 'genesis_attr_entry-image', 'cuttz_attributes_entry_image', 999 ); // adds cuttz-alignnone class to content archives featured image if alignment is set as none
add_filter( 'http_request_args', 'cuttz_dont_update_theme', 5, 2 );

add_action( 'get_header', 'cuttz_scss_compile' );
add_action( 'admin_head', 'cuttz_scss_compile' );

/* Add Cuttz framework theme settings menu */
add_action( 'genesis_admin_menu', 'cuttz_extras_menu' );
add_action( 'genesis_admin_menu', 'cuttz_design_settings_menu' );
add_action( 'genesis_admin_menu', 'cuttz_favicon_settings_menu' );

add_action( 'admin_init', 'cuttz_redir_settings', 999 );

function cuttz_generate_skin_css(){
	cuttz_generate_css(get_option(cuttz_get_skin_page_id()));
}

function cuttz_scss_compile() {
	if ( !current_user_can( 'update_themes' ) ) {
		return;
	}
	$scss = new scssc();
	$scss->setFormatter( 'scss_formatter' );
	if ( file_exists( CHILD_DIR . '/lib/stylesheet-core/style.scss' ) ) {
		if ( filemtime( CHILD_DIR . '/lib/stylesheet-core/style.scss' ) > filemtime( CHILD_DIR . '/style.css' ) ) {
			$css = "@charset \"UTF-8\"; \n\n/*S********************************************************************************\n******************** Make all your changes to themes/cuttz/lib/stylesheet-core/style.scss **************************\n**** This file will be overwritten by style.scss and your changes will be lost ****\n**********************************************************************************/\n\n";
			$css = '';
			$css .= $scss->compile( '@import "' . CHILD_DIR . '/lib/stylesheet-core/style.scss' . '"' );
			file_put_contents( CHILD_DIR . '/style.css', $css );
			if ( function_exists( 'w3tc_browsercache_flush' ) ) { //check if W3Total cache is installed and active
				w3tc_browsercache_flush(); //flush the w3tc browser cache to fetch the new css
			}
		}
	}

	if ( file_exists( cuttz_current_skin_path() . '/style.scss' ) ) {
		if ( filemtime( cuttz_current_skin_path() . '/style.scss' ) > @filemtime( cuttz_current_skin_path() . '/autogenerated.css' ) ) {
			$css = "@charset \"UTF-8\"; \n\n/*D*********************************************************************************\n******************** Make all your changes to style.scss **************************\n**** This file will be overwritten by style.scss and your changes will be lost ****\n**********************************************************************************/\n\n";
			$css .= $scss->compile( '@import "' . cuttz_current_skin_path() . '/style.scss' . '"' );
			file_put_contents( cuttz_current_skin_path() . '/autogenerated.css', $css );
			if ( function_exists( 'w3tc_browsercache_flush' ) ) { //check if W3Total cache is installed and active
				w3tc_browsercache_flush(); //flush the w3tc browser cache to fetch the new css
			}
		}
	}

	$user_dir = cuttz_get_res( 'dir' );

	if ( file_exists( $user_dir . 'style.scss' ) ) {
		if ( filemtime( $user_dir . 'style.scss' ) > @filemtime( $user_dir . 'autogenerated.css' ) ) {
			$css = "@charset \"UTF-8\"; \n\n/*U********************************************************************************\n******************** Make all your changes to style.scss **************************\n**** This file will be overwritten by style.scss and your changes will be lost ****\n**********************************************************************************/\n\n";
			$css .= $scss->compile( '@import "' . $user_dir . 'style.scss' . '"' );
			file_put_contents( $user_dir . 'autogenerated.css', $css );
			if ( function_exists( 'w3tc_browsercache_flush' ) ) { //check if W3Total cache is installed and active
				w3tc_browsercache_flush(); //flush the w3tc browser cache to fetch the new css
			}
		}
	}
}

class scss_formatter_ex extends \Leafo\ScssPhp\Formatter\Nested {
	public function __construct() {
		$this->indentLevel     = 0;
		$this->indentChar      = "\t";
		$this->break           = "\n";
		$this->open            = ' {';
		$this->close           = " }";
		$this->tagSeparator    = ",\n";
		$this->assignSeparator = ': ';
	}
}

function cuttz_current_skin() {
	$skin            = '';
	$available_skins = cuttz_customization_aggregator();
	$skin            = genesis_get_option( 'skin', CHILD_SETTINGS_FIELD_EXTRAS, false );
	if ( is_array( $available_skins ) && array_key_exists( $skin, $available_skins ) ) {
		return $available_skins[$skin];
	}
}

function cuttz_current_skin_path() {
	$skin = cuttz_current_skin();
	return $skin['dir'];
}

if ( genesis_get_option( 'current-skin-functions-enabled', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
	$customization      = '';
	$all_customizations = cuttz_customization_aggregator();
	$customization      = genesis_get_option( 'skin', CHILD_SETTINGS_FIELD_EXTRAS, false );
	if ( is_array( $all_customizations ) && array_key_exists( $customization, $all_customizations ) ) {
		$current_customization = $all_customizations[$customization];
		if ( is_array( $current_customization ) && array_key_exists( 'functions', $current_customization ) ) {
			include_once $current_customization['functions'];
		}
	}
}

if ( genesis_get_option( 'custom-functions-enabled', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
	@include_once cuttz_get_res( 'file', 'userphp' );
}


/* Helper function to allow users to disable the Cuttz notices */
function cuttz_hide_notices() {
	global $current_user;
	$user_id = $current_user->ID;
	/* If user clicks to ignore the notice, add it to his user meta */
	if ( isset($_GET['cuttz_hide_notice_activ']) && '0' == $_GET['cuttz_hide_notice_activ'] ) {
		 add_user_meta($user_id, 'cuttz_ignore_notice_activ', 'true', true);
		/* Gets where the user came from after they click Hide Notice */
		if ( wp_get_referer() ) {
			/* Redirects user to where they were before */
			wp_safe_redirect( wp_get_referer() );
		}
		else {
			/* This will never happen, I can almost guarantee it, but we should still have it, just in case*/
			wp_safe_redirect( home_url() );
		}
	}
	
	if ( isset($_GET['cuttz_hide_notice_invalid']) && '0' == $_GET['cuttz_hide_notice_invalid'] ) {
		 add_user_meta($user_id, 'cuttz_ignore_notice_invalid', 'true', true);
		/* Gets where the user came from after they click Hide Notice */
		if ( wp_get_referer() ) {
			/* Redirects user to where they were before */
			wp_safe_redirect( wp_get_referer() );
		}
		else {
			/* This will never happen, I can almost gurantee it, but we should still have it just in case*/
			wp_safe_redirect( home_url() );
		}
	}
	
	if ( isset($_GET['cuttz_hide_notice_subsc']) && '0' == $_GET['cuttz_hide_notice_subsc'] ) {
		 add_user_meta($user_id, 'cuttz_ignore_notice_subsc', 'true', true);
		/* Redirect the user to the page they came from */
		if ( wp_get_referer() ) {
			/* Redirects user to where they were before */
			wp_safe_redirect( wp_get_referer() );
		}
		else {
			/* fallback */
			wp_safe_redirect( home_url() );
		}
	}
}