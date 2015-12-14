<?php

/**
* Template Name: Landing Page
* Description: Femme Flora landing page template
*/


//* add a body class 

add_filter( 'body_class', 'femme_landing_page' );

function femme_landing_page($classes) {
	$classes[] = 'femme-landing-page';
	return $classes;
}

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove breadcrumbs

remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );

genesis();