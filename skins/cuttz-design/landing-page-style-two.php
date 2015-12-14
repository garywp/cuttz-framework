<?php

/**
* Template Name: Landing Page Style Two
* Description: Cuttz design landing page design variant two
*/


//* add a body class 

add_filter( 'body_class', 'landing_page_style_two_class' );

function landing_page_style_two_class($classes) {
	$classes[] = 'cuttz-style-two';
	$classes[] = 'pagewidth';
	foreach($classes as $key => $value) {
			if ($value == 'fullwidth') unset($classes[$key]);
	}
	return $classes;
}

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove breadcrumbs

remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );
 


genesis();
