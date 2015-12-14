<?php

/**
 * @package Cuttz Framework
 *
 * @author Shivanand Sharma
 */

 
define( 'GENESIS_LIB_DIR', get_template_directory() . '/lib/genesis/lib' );
define( 'PARENT_THEME_NAME', 'Cuttz Framework' );
define( 'PARENT_URL', get_template_directory_uri() . '/lib/genesis' );

require_once( GENESIS_LIB_DIR . '/init.php' );

require_once get_template_directory() . '/lib/init.php';
//require_once get_stylesheet_directory() . '/lib/init.php';

remove_theme_support( 'genesis-auto-updates' );