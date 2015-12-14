<?php

/**
 * Generates and write or return CSS as per the design settings. Generates dynamic media queries.
 * @param array $settings (Design Settings)
 * @param bool $writecss 
 * @return string CSS or none
 * @since 1.0
 */
function cuttz_generate_css( $settings = array(), $writecss = true ) {
	
	$writecss = (bool) $writecss;
	
	if ( !is_array( $settings ) || $settings == false || empty( $settings ) ) {
		/* In case there is no settings passed which is the case when doing after_theme_switch, Cuttz should check for the skin that is set in the admin settings field. Get it's settings and use them instead of dumbing back to vanilla
		*/
		$skin = get_option( cuttz_get_skin_page_id() );	// try to get the settings of the current skin
		if( !$skin ) {	// If no settings exist/first-run then get the default settings.
			$skin = cuttz_skin_defaults();
		}
		$settings = cuttz_back_compat( $skin );
	}

	// Global $cuttz_skin_defaults;
	$layout                   = $settings['layout'];
	$padding                  = (int) $settings['col-spacing'];
	$content_w_1col           = (int) $settings['column-content-1col'];
	$content_w_2col           = (int) $settings['column-content-2col'];
	$sb1_w_2col               = (int) $settings['sidebar-one-2col'];
	$content_w_3col           = (int) $settings['column-content-3col'];
	$sb1_w_3col               = (int) $settings['sidebar-one-3col'];
	$sb2_w_3col               = (int) $settings['sidebar-two-3col'];
	$site_bg_color            = $settings['site-background-color'];
	$page_bg_color            = $settings['page-background-color'];
	$primary_text_color       = $settings['primary-text-color'];
	$form_text_color          = $settings['form-text-color'];
	$primary_link_color       = $settings['primary-link-color'];
	$primary_link_hover_color = $settings['primary-link-hover-color'];

	$form_font_family = $settings['form-font-family'];
	$form_font_family = cuttz_get_font_family( $form_font_family );

	$body_font_family = $settings['body-font-family'];
	$body_font_family = cuttz_get_font_family( $body_font_family );
	$body_font_weight = cuttz_get_font_weight( $settings['body-font-weight'] );
	$body_font_style  = $settings['body-font-weight'];


	$nav_menu_font_family = $settings['nav-menu-font-family'];
	$nav_menu_font_family = cuttz_get_font_family( $nav_menu_font_family );
	$nav_menu_font_weight = cuttz_get_font_weight( $settings['nav-menu-font-weight'] );
	$nav_menu_font_style  = cuttz_get_font_style( $settings['nav-menu-font-weight'] );

	$subnav_menu_font_family = $settings['subnav-menu-font-family'];
	$subnav_menu_font_family = cuttz_get_font_family( $subnav_menu_font_family );
	$subnav_menu_font_weight = cuttz_get_font_weight( $settings['subnav-menu-font-weight'] );
	$subnav_menu_font_style  = cuttz_get_font_style( $settings['subnav-menu-font-weight'] );

	$site_title_font_family = $settings['site-title-font-family'];
	$site_title_font_family = cuttz_get_font_family( $site_title_font_family );
	$site_title_font_weight = cuttz_get_font_weight( $settings['site-title-font-weight'] );
	$site_title_font_style  = cuttz_get_font_style( $settings['site-title-font-weight'] );

	$site_description_font_family = $settings['site-description-font-family'];
	$site_description_font_family = cuttz_get_font_family( $site_description_font_family );
	$site_description_font_weight = cuttz_get_font_weight( $settings['site-description-font-weight'] );
	$site_description_font_style  = cuttz_get_font_style( $settings['site-description-font-weight'] );

	$headline_font_family = $settings['headline-font-family'];
	$headline_font_family = cuttz_get_font_family( $headline_font_family );
	$headline_font_weight = cuttz_get_font_weight( $settings['headline-font-weight'] );
	$headline_font_style  = cuttz_get_font_style( $settings['headline-font-weight'] );

	$headline_subhead_font_family = $settings['headline-subhead-font-family'];
	$headline_subhead_font_family = cuttz_get_font_family( $headline_subhead_font_family );
	$headline_subhead_font_weight = cuttz_get_font_weight( $settings['headline-subhead-font-weight'] );
	$headline_subhead_font_style  = cuttz_get_font_style( $settings['headline-subhead-font-weight'] );

	$byline_font_family = $settings['byline-font-family'];
	$byline_font_family = cuttz_get_font_family( $byline_font_family );
	$byline_font_weight = cuttz_get_font_weight( $settings['byline-font-weight'] );
	$byline_font_style  = cuttz_get_font_style( $settings['byline-font-weight'] );

	$sidebar_heading_font_family = $settings['sidebar-heading-font-family'];
	$sidebar_heading_font_family = cuttz_get_font_family( $sidebar_heading_font_family );
	$sidebar_heading_font_weight = cuttz_get_font_weight( $settings['sidebar-heading-font-weight'] );
	$sidebar_heading_font_style  = cuttz_get_font_style( $settings['sidebar-heading-font-weight'] );

	$sidebar_font_family = $settings['sidebar-font-family'];
	$sidebar_font_family = cuttz_get_font_family( $sidebar_font_family );
	$sidebar_font_weight = cuttz_get_font_weight( $settings['sidebar-font-weight'] );
	$sidebar_font_style  = cuttz_get_font_style( $settings['sidebar-font-weight'] );


	$footer_widgets_font_family = $settings['footer-widgets-font-family'];
	$footer_widgets_font_family = cuttz_get_font_family( $footer_widgets_font_family );
	$footer_widgets_font_weight = cuttz_get_font_weight( $settings['footer-widgets-font-weight'] );
	$footer_widgets_font_style  = cuttz_get_font_style( $settings['footer-widgets-font-weight'] );

	$footer_widgets_heading_font_family = $settings['footer-widgets-heading-font-family'];
	$footer_widgets_heading_font_family = cuttz_get_font_family( $footer_widgets_heading_font_family );
	$footer_widgets_heading_font_weight = cuttz_get_font_weight( $settings['footer-widgets-heading-font-weight'] );
	$footer_widgets_heading_font_style  = cuttz_get_font_style( $settings['footer-widgets-heading-font-weight'] );

	$footer_font_family = $settings['footer-font-family'];
	$footer_font_family = cuttz_get_font_family( $footer_font_family );
	$footer_font_weight = cuttz_get_font_weight( $settings['footer-font-weight'] );
	$footer_font_style  = cuttz_get_font_style( $settings['footer-font-weight'] );

	$body_font_size                          = (int) $settings['body-font-size'];
	$form_font_size                          = (int) $settings['form-font-size'];
	$nav_menu_font_size                      = (int) $settings['nav-menu-font-size'];
	$nav_menu_link_text_color                = $settings['nav-menu-link-text-color'];
	$nav_menu_link_text_hover_color          = $settings['nav-menu-link-text-hover-color'];
	$nav_menu_current_link_text_color        = $settings['nav-menu-current-link-text-color'];
	$nav_menu_current_parent_link_text_color = $settings['nav-menu-current-parent-link-text-color'];
	$nav_menu_link_bg_color                  = $settings['nav-menu-link-bg-color'];
	$nav_menu_hover_bg_color                 = $settings['nav-menu-hover-bg-color'];
	$nav_menu_current_bg_color               = $settings['nav-menu-current-bg-color'];
	$nav_menu_current_parent_bg_color        = $settings['nav-menu-current-parent-bg-color'];
	$nav_menu_border_width                   = $settings['nav-menu-border-width'];
	$nav_menu_border_color                   = $settings['nav-menu-border-color'];
	$nav_menu_submenu_width                  = $settings['nav-menu-submenu-width'];

	$subnav_menu_font_size                      = (int) $settings['subnav-menu-font-size'];
	$subnav_menu_link_text_color                = $settings['subnav-menu-link-text-color'];
	$subnav_menu_link_text_hover_color          = $settings['subnav-menu-link-text-hover-color'];
	$subnav_menu_current_link_text_color        = $settings['subnav-menu-current-link-text-color'];
	$subnav_menu_current_parent_link_text_color = $settings['subnav-menu-current-parent-link-text-color'];
	$subnav_menu_link_bg_color                  = $settings['subnav-menu-link-bg-color'];
	$subnav_menu_hover_bg_color                 = $settings['subnav-menu-hover-bg-color'];
	$subnav_menu_current_bg_color               = $settings['subnav-menu-current-bg-color'];
	$subnav_menu_current_parent_bg_color        = $settings['subnav-menu-current-parent-bg-color'];
	$subnav_menu_border_width                   = $settings['subnav-menu-border-width'];
	$subnav_menu_border_color                   = $settings['subnav-menu-border-color'];
	$subnav_menu_submenu_width                  = $settings['subnav-menu-submenu-width'];

	$site_title_font_size        = (int) $settings['site-title-font-size'];
	$site_title_font_color       = $settings['site-title-font-color'];
	$site_description_font_size  = (int) $settings['site-description-font-size'];
	$site_description_font_color = $settings['site-description-font-color'];

	$headline_font_size  = (int) $settings['headline-font-size'];
	$headline_font_color = $settings['headline-font-color'];

	$headline_subhead_font_color = $settings['headline-subhead-font-color'];

	$byline_font_size  = (int) $settings['byline-font-size'];
	$byline_font_color = $settings['byline-font-color'];

	$sidebar_font_size  = (int) $settings['sidebar-font-size'];
	$sidebar_font_color = $settings['sidebar-font-color'];

	$sidebar_heading_font_size  = (int) $settings['sidebar-heading-font-size'];
	$sidebar_heading_font_color = $settings['sidebar-heading-font-color'];

	$footer_font_size  = (int) $settings['footer-font-size'];
	$footer_font_color = $settings['footer-font-color'];

	$footer_widgets_font_size  = (int) $settings['footer-widgets-font-size'];
	$footer_widgets_font_color = $settings['footer-widgets-font-color'];

	$footer_widgets_heading_font_size  = (int) $settings['footer-widgets-heading-font-size'];
	$footer_widgets_heading_font_color = $settings['footer-widgets-heading-font-color'];

	if ( $nav_menu_font_family == '0' ) {
		$nav_menu_font_family = $body_font_family;
	}
	if ( $site_title_font_family == '0' ) {
		$site_title_font_family = $body_font_family;
	}
	if ( $site_description_font_family == '0' ) {
		$site_description_font_family = $site_title_font_family;
	}
	if ( $headline_font_family == '0' ) {
		$headline_font_family = $body_font_family;
	}
	if ( $headline_subhead_font_family == '0' ) {
		$headline_subhead_font_family = $headline_font_family;
	}
	if ( $sidebar_font_family == '0' ) {
		$sidebar_font_family = $body_font_family;
	}
	if ( $sidebar_heading_font_family == '0' ) {
		$sidebar_heading_font_family = $sidebar_font_family;
	}
	if ( $footer_font_family == '0' ) {
		$footer_font_family = $body_font_family;
	}

	$widths['three-two']  = ( $content_w_3col + $sb1_w_3col + $sb2_w_3col + ( $padding * 4 ) ) - 1;
	$widths['three-one']  = ( $content_w_3col + $sb1_w_3col + $padding * 3 ) - 1;
	$widths['three-zero'] = ( $content_w_3col + $padding * 2 ) - 1;
	$widths['two-one']    = ( $content_w_2col + $sb1_w_2col + $padding * 3 ) - 1;
	$widths['two-zero']   = ( $content_w_2col + $padding * 2 ) - 1;
	$widths['one-zero']   = ( $content_w_1col + $padding * 2 ) - 1;
	$widths['min-width']  = min( $widths['three-zero'], $widths['two-zero'], $widths['one-zero'] );

	$site_container_css       = '.pagewidth .site-container {
	/* box-shadow:0 0 15px rgba(0,0,0,0.15); */
	margin:2.618em auto;
	}
	.fullwidth .site-container {
	margin:0 auto;
	}';
	$site_container_one_col   = ".pagewidth.full-width-content .site-container {
	width:" . ( $widths['one-zero'] + 1 ) . "px;
	} ";
	$site_container_two_col   = ".pagewidth.content-sidebar .site-container,
	.pagewidth.sidebar-content .site-container {
	width:" . ( $widths['two-one'] + 1 ) . "px;
	}";
	$site_container_three_col = ".pagewidth.content-sidebar-sidebar .site-container,
	.pagewidth.sidebar-sidebar-content .site-container,
	.pagewidth.sidebar-content-sidebar .site-container{
	width:" . ( $widths['three-two'] + 1 ) . "px;
	}";

	$site_container_three_two  = '
	.pagewidth.content-sidebar-sidebar .site-container,
	.pagewidth.sidebar-sidebar-content .site-container,
	.pagewidth.sidebar-content-sidebar .site-container {
	width:' . ( $widths['three-one'] + 1 ) . 'px;
	}';
	$site_container_three_one  = '.pagewidth.content-sidebar-sidebar .site-container,
	.pagewidth.sidebar-sidebar-content .site-container,
	.pagewidth.sidebar-content-sidebar .site-container {
	width:' . ( $widths['three-zero'] + 1 ) . 'px;
	}';
	$site_container_three_zero = '.pagewidth.content-sidebar-sidebar .site-container,
	.pagewidth.sidebar-sidebar-content .site-container,
	.pagewidth.sidebar-content-sidebar .site-container {
	width:auto;
	}';
	$site_container_two_one    = '.pagewidth.sidebar-content .site-container,
	.pagewidth.content-sidebar .site-container {
	width:' . ( $widths['two-zero'] + 1 ) . 'px;
	}';
	$site_container_two_zero   = '.pagewidth.sidebar-content .site-container,
	.pagewidth.content-sidebar .site-container {
	width:auto;
	}';
	$site_container_one_zero   = '.pagewidth.full-width-content .site-container {
	width:auto;
	}';

	$css = "
	input, select, textarea {
	color: " . $form_text_color . ";
	font-family:" . $form_font_family . ";
	font-size:" . $form_font_size . "px;
}

/*! Layout */
" . $site_container_css . "
/*! 1 COL WIDTHS */
" . ( $site_container_one_col ) . "

.full-width-content .wrap {
	padding-left:" . $padding . "px;
	padding-right:" . $padding . "px;
	width:" . ( $content_w_1col + $padding * 2 ) . "px;
}

.full-width-content .content-sidebar-wrap,
.full-width-content .content {
	float:none;
}

/*! 2 COL WIDTHS */

" . ( $site_container_two_col ) . "

.content-sidebar .wrap,
.sidebar-content .wrap {
	width:" . ( $content_w_2col + $sb1_w_2col + $padding * 3 ) . "px;
	padding-left:" . $padding . "px;
	padding-right:" . $padding . "px;
}

.content-sidebar .content,
.sidebar-content .content {
	width:" . ( $content_w_2col ) . "px;
}

.content-sidebar .sidebar-primary,
.sidebar-content .sidebar-primary {
	width:" . ( $sb1_w_2col ) . "px;
}

/*! 3 COL WIDTHS */

" . ( $site_container_three_col ) . "


.content-sidebar-sidebar .wrap,
.sidebar-sidebar-content .wrap,
.sidebar-content-sidebar .wrap {
	width:" . ( $padding * 4 + $content_w_3col + $sb1_w_3col + $sb2_w_3col ) . "px;
	padding-left:" . $padding . "px;
	padding-right:" . $padding . "px;
}

.content-sidebar-sidebar .content-sidebar-wrap,
.sidebar-sidebar-content .content-sidebar-wrap,
.sidebar-content-sidebar .content-sidebar-wrap {
	width:" . ( $content_w_3col + $sb1_w_3col + $padding ) . "px; /* padding for content + sidebar */
}

.content-sidebar-sidebar .content,
.sidebar-sidebar-content .content,
.sidebar-content-sidebar .content {
	width:" . ( $content_w_3col ) . "px; /* padding for content + sidebar */
}

.content-sidebar-sidebar .sidebar-primary,
.sidebar-sidebar-content .sidebar-primary,
.sidebar-content-sidebar .sidebar-primary {
	width:" . ( $sb1_w_3col ) . "px; /* padding for content + sidebar */
}

.content-sidebar-sidebar .sidebar-secondary,
.sidebar-sidebar-content .sidebar-secondary,
.sidebar-content-sidebar .sidebar-secondary {
	width:" . ( $sb2_w_3col ) . "px; /* padding for content + sidebar */
}

/*! BODY FONT-SZ */
body {
	background-color:" . $site_bg_color . ";
	font-family:" . $body_font_family . ";
	color:" . $primary_text_color . ";
	font-size:" . ( $body_font_size ) . "px;
	font-weight:" . $body_font_weight . ";
	font-style:" . $body_font_weight . ";
}

/*! PAGE BG */
.wrap {
	background-color:" . $page_bg_color . ";
}

/*! LINKS  */

a {
	color:" . $primary_link_color . ";
}

/*! Pagination */

.archive-pagination li a:hover, .archive-pagination li.active a, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current {
	background-color:" . $primary_link_color . ";
}

.widget-wrap > :not(.widget-title) a,
.comment-content a {
	text-decoration: underline;
}

.entry-content a:hover,
.landing-section a:hover,
.widget-wrap > :not(.widget-title) a:hover,
.comment-content a:hover {
	text-decoration: none;
}

a:hover,
.entry-title a:hover {
	color:" . $primary_link_hover_color . ";
}

.comment-content a {
	border-bottom: none;
}

/*! SITE TITLE */
.site-title {
	font-family:" . $site_title_font_family . ";
	font-size:" . ( $site_title_font_size ) . "px;
	font-weight:" . ( $site_title_font_weight ) . ";
	font-style:" . ( $site_title_font_style ) . ";
}

.site-title a {
	color:" . $site_title_font_color . ";
}

.site-description {
	font-family:" . $site_description_font_family . ";
	font-size:" . ( $site_description_font_size ) . "px;
	font-weight:" . ( $site_description_font_weight ) . ";
	font-style:" . ( $site_description_font_style ) . ";
	color:" . $site_description_font_color . ";
}

.entry-title,
.archive-title,
.woocommerce .page-title {
	font-family: " . $headline_font_family . ";
	font-size: " . ( $headline_font_size ) . "px;
	font-weight: " . ( $headline_font_weight ) . ";
	font-style: " . ( $headline_font_style ) . ";
	color:" . $headline_font_color . ";
 }

.entry-title a {
	color:" . $headline_font_color . ";
}

.entry-content h1,
.landing-section h1,
.entry-content h2,
.landing-section h2,
.entry-content h3,
.landing-section h3,
.entry-content h4,
.landing-section h4,
.entry-content h5,
.landing-section h5,
.entry-content h6,
.landing-section h6  {
	font-family:" . $headline_subhead_font_family . ";
	color:" . $headline_subhead_font_color . ";
	font-weight:" . $headline_subhead_font_weight . ";
	font-style:" . $headline_subhead_font_style . ";
}

/*! NAV */

.menu-primary {
	border-bottom:" . $nav_menu_border_width . "px solid " . $nav_menu_border_color . ";
	border-top:" . $nav_menu_border_width . "px solid " . $nav_menu_border_color . ";
}

.menu-primary .sub-menu {
	border-left:" . ( ( $nav_menu_border_width == 0 ) ? 0 : $nav_menu_border_width ) . "px solid " . $nav_menu_border_color . ";
	margin-left:-" . ( ( $nav_menu_border_width == 0 ) ? 0 : $nav_menu_border_width ) . "px;
	padding-bottom:" . ( ( $nav_menu_border_width == 0 ) ? 0 : $nav_menu_border_width ) . "px;
	border-top:" . $nav_menu_border_width . "px solid " . $nav_menu_border_color . ";
}

.rtl .menu-primary .sub-menu {
	border-right:" . ( ( $nav_menu_border_width == 0 ) ? 0 : $nav_menu_border_width ) . "px solid " . $nav_menu_border_color . ";
	border-left:0;
	margin-right:-" . ( ( $nav_menu_border_width == 0 ) ? 0 : $nav_menu_border_width ) . "px;
	margin-left:auto;
}

.menu-primary  li {
	font-size:" . $nav_menu_font_size . "px;
}

.menu-primary a,
.menu-toggle {
	font-family:" . $nav_menu_font_family . ";
	font-size:" . $nav_menu_font_size . "px;
	font-weight:" . $nav_menu_font_weight . ";
	font-style:" . $nav_menu_font_style . ";
	color:" . $nav_menu_link_text_color . ";
	background-color:" . $nav_menu_link_bg_color . ";
}

/*! redundant */
.cuttz .genesis-nav-menu > .right {
	color:" . $nav_menu_link_text_color . ";
	font-size:" . $nav_menu_font_size . "px;
}

.menu-primary .sub-menu {
	-webkit-box-shadow:  1px 3px 5px 0px rgba(0, 0, 0, .2);
	-webkit-box-shadow:  2px 2px 2px 0px rgba(0, 0, 0, .2);
	box-shadow:  1px 3px 5px 0px rgba(0, 0, 0, .2);
	box-shadow:  2px 2px 2px 0px rgba(0, 0, 0, .2);
}

/*! parent or parents parent/grandparent etc */
.menu-primary .current-menu-ancestor > a {
	color:" . $nav_menu_current_parent_link_text_color . ";
	background-color:" . $nav_menu_current_parent_bg_color . ";
}

.menu-primary .current-menu-item > a {
	color:" . $nav_menu_current_link_text_color . ";
	background-color:" . $nav_menu_current_bg_color . ";
}

.menu-primary .sub-menu {
	width:" . $nav_menu_submenu_width . "px;
}

.menu-primary a:hover {
	color:" . $nav_menu_link_text_hover_color . ";
	background-color:" . $nav_menu_hover_bg_color . ";
}

.nav-secondary {
	background-color:" . $subnav_menu_link_bg_color . ";
	border-bottom:" . $subnav_menu_border_width . "px solid " . $subnav_menu_border_color . ";
}

.nav-secondary .wrap {
	background-color: transparent;
}

.menu-secondary .sub-menu {
	border-left:" . ( ( $subnav_menu_border_width == 0 ) ? 0 : $subnav_menu_border_width ) . "px solid " . $subnav_menu_border_color . ";
	margin-left:-" . ( ( $subnav_menu_border_width == 0 ) ? 0 : $subnav_menu_border_width ) . "px;
	padding-bottom:" . ( ( $subnav_menu_border_width == 0 ) ? 0 : $subnav_menu_border_width ) . "px;
	border-top:" . $subnav_menu_border_width . "px solid " . $subnav_menu_border_color . ";
}

.rtl .menu-secondary .sub-menu {
	border-right:" . ( ( $subnav_menu_border_width == 0 ) ? 0 : $subnav_menu_border_width ) . "px solid " . $subnav_menu_border_color . ";
	border-left:0;
	margin-right:-" . ( ( $subnav_menu_border_width == 0 ) ? 0 : $subnav_menu_border_width ) . "px;
	margin-left:0;
}

.menu-secondary  li {
	font-size:" . $subnav_menu_font_size . "px;
}

.menu-secondary a,
.menu-toggle {
	font-family:" . $subnav_menu_font_family . ";
	font-size:" . $subnav_menu_font_size . "px;
	font-weight:" . $subnav_menu_font_weight . ";
	font-style:" . $subnav_menu_font_style . ";
	color:" . $subnav_menu_link_text_color . ";
	background-color:" . $subnav_menu_link_bg_color . ";
}

.menu-secondary .sub-menu {
	-webkit-box-shadow:  1px 3px 5px 0px rgba(0, 0, 0, .2);
	-webkit-box-shadow:  2px 2px 2px 0px rgba(0, 0, 0, .2);
	box-shadow:  1px 3px 5px 0px rgba(0, 0, 0, .2);
	box-shadow:  2px 2px 2px 0px rgba(0, 0, 0, .2);
}

.menu-secondary .current-menu-ancestor > a {
	color:" . $subnav_menu_current_parent_link_text_color . ";
	background-color:" . $subnav_menu_current_parent_bg_color . ";
}

.menu-secondary .current-menu-item > a {
	color:" . $subnav_menu_current_link_text_color . ";
	background-color:" . $subnav_menu_current_bg_color . ";
}

.menu-secondary .sub-menu {
	width:" . $subnav_menu_submenu_width . "px;
}

.rtl .menu-secondary .sub-menu .sub-menu {
	margin-left: 0;
}

.menu-secondary a:hover {
	color:" . $subnav_menu_link_text_hover_color . ";
	background-color:" . $subnav_menu_hover_bg_color . ";
}

.menu-toggle {
	border:" . $nav_menu_border_width . "px solid " . $nav_menu_border_color . ";
	}

/*! BYLINES */
.entry-meta,
.entry-comments .comment-meta {
	font-family:" . $byline_font_family . ";
	font-size:" . $byline_font_size . "px;
	font-weight:" . $byline_font_weight . ";
	font-style:" . $byline_font_style . ";
	color:" . $byline_font_color . ";
}

/* */
.entry-meta a,
.entry-comments .comment-meta a {
	color:" . $byline_font_color . ";
}


.entry-meta a:hover {
	color:inherit;
}

/*! SB Widget Body */

.widget-wrap {
	font-family:" . $sidebar_font_family . ";
	font-size:" . ( $sidebar_font_size ) . "px;
	font-weight:" . ( $sidebar_font_weight ) . ";
	font-style:" . ( $sidebar_font_style ) . ";
	color:" . $sidebar_font_color . ";
}

/*! SB Widget Title */
.widget-title, .widgettitle {
	font-family:" . $sidebar_heading_font_family . ";
	font-size:" . ( $sidebar_heading_font_size ) . "px;
	font-weight:" . ( $sidebar_heading_font_weight ) . ";
	font-style:" . ( $sidebar_heading_font_style ) . ";
	color:" . $sidebar_heading_font_color . ";
}

.widget-title a, .widgettitle a {
	color:" . $sidebar_heading_font_color . ";
}

/*! Footer Widget Body */
.footer-widgets .widget-wrap {
	font-family:" . $footer_widgets_font_family . ";
	font-size:" . ( $footer_widgets_font_size ) . "px;
	font-weight:" . ( $footer_widgets_font_weight ) . ";
	font-style:" . ( $footer_widgets_font_style ) . ";
	color:" . $footer_widgets_font_color . ";
	/* line-height:1.618em;  core */
}

/*! Footer Widgets Titles */
.footer-widgets .widgettitle {
	font-family:" . $footer_widgets_heading_font_family . ";
	font-size:" . ( $footer_widgets_heading_font_size ) . "px;
	font-weight:" . ( $footer_widgets_heading_font_weight ) . ";
	font-style:" . ( $footer_widgets_heading_font_style ) . ";
	color:" . $footer_widgets_heading_font_color . ";
}

/*! Footer */
.site-footer,
#footer {
	font-family:" . $footer_font_family . ";
	font-size:" . $footer_font_size . "px;
	font-weight:" . $footer_font_weight . ";
	font-style:" . $footer_font_style . ";
	color:" . $footer_font_color . ";
}

.site-footer a,
.site-footer a:hover {
	color:" . $footer_font_color . ";
	border-bottom:1px solid " . $footer_font_color . ";
	text-decoration:none;
}

.site-footer a:hover {
	border-bottom-color: transparent;
}

.site-footer .cuttz-nav-footer a:hover {
	border-bottom-color: " . $footer_font_color . ";
}

.full-width-content .content .sticky {
	_margin-left:-" . $padding . "px;
	_margin-right:-" . $padding . "px;
	padding-left:" . $padding . "px;
	padding-right:" . $padding . "px;
	padding-top: " . $padding . "px;
}

.content-sidebar .content .sticky,
.content-sidebar-sidebar .content .sticky {
	padding-left:" . $padding . "px;
	padding-right:" . $padding . "px;
	_margin-left:-" . $padding . "px;
	padding-top: " . $padding . "px;
}

.rtl.content-sidebar .content .sticky,
.rtl.content-sidebar-sidebar .content .sticky{
	margin-left: initial;
	_margin-right:-" . $padding . "px;
}

.sidebar-content-sidebar .content .sticky {
	padding-left:" . $padding . "px;
	padding-right:" . $padding . "px;
}

.sidebar-content .content .sticky,
.sidebar-sidebar-content .content .sticky {
	padding-left:" . $padding . "px;
	padding-right:" . $padding . "px;
	_margin-right:-" . $padding . "px;
}

.rtl.sidebar-content .content .sticky,
.rtl.sidebar-sidebar-content .content .sticky {
	_margin-left:-" . $padding . "px;
	margin-right: initial;
}
";



	$resp_css['three-two'] = '
		' . $site_container_three_two . '

		.content-sidebar-sidebar .wrap,
		.sidebar-content-sidebar .wrap,
		.sidebar-sidebar-content .wrap {
			width:' . ( $content_w_3col + $sb1_w_3col + $padding * 3 ) . 'px;
		}
		.content-sidebar-sidebar .sidebar-secondary,
		.sidebar-content-sidebar .sidebar-secondary,
		.sidebar-sidebar-content .sidebar-secondary {
			float: none;
			clear: both;
			width: auto;
		}';

	$resp_css['three-one'] = '
		' . $site_container_three_one . '

		.content-sidebar-sidebar .wrap,
		.sidebar-content-sidebar .wrap,
		.sidebar-sidebar-content .wrap {
			width:' . ( $content_w_3col + $padding * 2 ) . 'px;
			width: auto;
		}
		.content-sidebar-sidebar .wrap .content-sidebar-wrap,
		.sidebar-content-sidebar .wrap .content-sidebar-wrap,
		.sidebar-sidebar-content .wrap .content-sidebar-wrap {
			width:' . ( $content_w_3col ) . 'px;
			width: 100%;
		}
		.content-sidebar-sidebar .content,
		.sidebar-sidebar-content .content,
		.sidebar-content-sidebar .content {
			width: 100%;

		}
		.content-sidebar-sidebar .sidebar-primary,
		.sidebar-content-sidebar .sidebar-primary,
		.sidebar-sidebar-content .sidebar-primary {
			float: none;
			clear: both;
			width: auto;
		}
		.content-sidebar-sidebar .footer-widgets .widget-area,
		.sidebar-content-sidebar .footer-widgets .widget-area,
		.sidebar-sidebar-content .footer-widgets .widget-area {
			float: none;
			clear: both;
			display: block;
			width: auto;
		}';

	$resp_css['three-zero'] = '
		' . $site_container_three_zero . '
		.content-sidebar-sidebar .wrap,
		.sidebar-content-sidebar .wrap,
		.sidebar-sidebar-content .wrap {
			width:auto;
		}
		.content-sidebar-sidebar .wrap .content-sidebar-wrap,
		.sidebar-content-sidebar .wrap .content-sidebar-wrap,
		.sidebar-sidebar-content .wrap .content-sidebar-wrap {
			width:100%;
		}
		.content-sidebar-sidebar .content,
		.sidebar-content-sidebar .content,
		.sidebar-sidebar-content .content {
			width:100%;
		}
		.content-sidebar-sidebar .site-container,
		.sidebar-content-sidebar .site-container,
		.sidebar-sidebar-content .site-container{
			background-color:' . $page_bg_color . ';
		}
		.content-sidebar-sidebar .title-area,
		.sidebar-content-sidebar .title-area,
		.sidebar-sidebar-content .title-area {
			text-align: center;
		}
		.content-sidebar-sidebar .footer-widgets .widget-area,
		.sidebar-content-sidebar .footer-widgets .widget-area,
		.sidebar-sidebar-content .footer-widgets .widget-area {
			float: none;
			clear: both;
			display: block;
			width: auto;
		}';

	$resp_css['two-one'] = '
		' . $site_container_two_one . '

		.sidebar-content .wrap,
		.content-sidebar .wrap {
			width:' . ( $content_w_2col + $padding * 2 ) . 'px;
			width: auto;
		}
		.sidebar-content .wrap .content-sidebar-wrap,
		.content-sidebar .wrap .content-sidebar-wrap {
			width:' . ( $content_w_2col ) . 'px;
			width: auto;

		}
		.content-sidebar .content,
		.sidebar-content .content {
			width: 100%;
		}
		.sidebar-content .sidebar-primary,
		.content-sidebar .sidebar-primary {
			float: none;
			clear: both;
			width: auto;
		}
		.sidebar-content .footer-widgets .widget-area,
		.content-sidebar .footer-widgets .widget-area {
			float: none;
			clear: both;
			width: auto;
			display: block;
		}';

	$resp_css['two-zero'] = '
		' . $site_container_two_zero . '
		.sidebar-content .wrap,
		.content-sidebar .wrap {
			width:auto;
		}
		.sidebar-content .wrap .content-sidebar-wrap,
		.content-sidebar .wrap .content-sidebar-wrap {
			width:100%;
		}
		.sidebar-content .content,
		.content-sidebar .content {
			width:100%;
		}
		.sidebar-content .site-container,
		.content-sidebar .site-container {
			background-color:' . $page_bg_color . ';
		}
		.sidebar-content .title-area,
		.content-sidebar .title-area {
			text-align: center;
		}
		.sidebar-content .footer-widgets .widget-area,
		.content-sidebar .footer-widgets .widget-area {
			float: none;
			clear: both;
			width: auto;
			display: block;
		}';

	$resp_css['one-zero']  = '
		' . $site_container_one_zero . '
		.full-width-content .wrap {
			width:auto;
		}
		.full-width-content .wrap .content-sidebar-wrap {
			width:100%;
		}
		.full-width-content .content {
			width:100%;
		}
		.full-width-content .site-container{
			background-color:' . $page_bg_color . ';
		}
		.full-width-content .title-area {
			text-align:center;
		}
		.full-width-content .footer-widgets .widget-area {
			float: none;
			clear: both;
			width: auto;
			display: block;
		}';
	$resp_css['min-width'] = '
		.content-sidebar-sidebar .wrap,
		.sidebar-content-sidebar .wrap,
		.sidebar-sidebar-content .wrap,
		.content-sidebar-sidebar .wrap,
		.sidebar-content-sidebar .wrap,
		.sidebar-sidebar-content .wrap,
		.sidebar-content .wrap,
		.content-sidebar .wrap,
		.sidebar-content .wrap,
		.content-sidebar .wrap,
		.full-width-content .wrap,
		.full-width-content .wrap {
			padding-left: 35px;
			padding-right: 35px;
		}
		.content-sidebar-sidebar .nav-primary .wrap,
		.sidebar-content-sidebar .nav-primary .wrap,
		.sidebar-sidebar-content .nav-primary .wrap,
		.content-sidebar-sidebar .nav-secondary .wrap,
		.sidebar-content-sidebar .nav-secondary .wrap,
		.sidebar-sidebar-content .nav-secondary .wrap,
		.sidebar-content .nav-primary .wrap,
		.content-sidebar .nav-primary .wrap,
		.sidebar-content .nav-secondary .wrap,
		.content-sidebar .nav-secondary .wrap,
		.full-width-content .nav-primary .wrap,
		.full-width-content .nav-secondary .wrap {
			padding: 0 0 0 0;
		}
		.nav-primary,
		.nav-secondary {
			margin-left: 35px;
			margin-right: 35px;
			display: none;
		}
		.genesis-nav-menu li,
		.site-header ul.genesis-nav-menu {
			float: none;
		}
		.menu-toggle,
		.sub-menu-toggle {
			display: block;
			visibility: visible;
		}
		.genesis-nav-menu .sub-menu {
			width: auto;
			box-shadow: none;
		}
		.genesis-nav-menu .sub-menu a {
			border-left:1px solid ' . $nav_menu_border_color . ';
		}
		.genesis-nav-menu .sub-menu li:first-child a {
			border-top: none;
		}
		.menu-toggle {
			margin-left: 35px;
			margin-right: 35px;
		}
		.menu-toggle:before {
			content: "\2261\00a0Menu";
		}
		.menu-toggle.activated:before {
			content: "\2191\00a0Menu";
		}
		.sub-menu-toggle:before {
			content: "+";
		}
		.sub-menu-toggle.activated:before {
			content: "-";
		}
		.genesis-nav-menu .menu-item {
			position: relative;
			display: block;
		}
		.nav-primary .genesis-nav-menu .sub-menu,
		.nav-secondary .genesis-nav-menu .sub-menu {
			display: none;
			opacity: 1;
			position: static;
			border-left: none;
		}
		.genesis-nav-menu .sub-menu .sub-menu {
			margin: 0;
		}
		.nav-primary .menu .sub-menu,
		.nav-secondary .menu .sub-menu {
			padding-left: 1.618em;
		}';

	$responsive        = '';
	$media_queries_css = '';
	$resp_css          = apply_filters( 'cuttz_media_queries', $resp_css, $widths, $settings );
	arsort( $widths );
	$resp_css = sortArrayByArray( $resp_css, $widths );
	foreach ( $widths as $layout_css => $width ) {
		$media_queries_css .= '@media only screen and (max-width: ' . $width . 'px) {' . "\n";
		$media_queries_css .= $resp_css[$layout_css];
		$media_queries_css .= '}' . "\n";
	}
	$css = apply_filters( 'cuttz_settings_css', $css, $settings, $widths );
	$css = $css . $media_queries_css;
	if ( !$writecss ) {
		return $css;
	}
	$layoutfile = cuttz_get_res( 'file', 'settingscss' );
	touch( $layoutfile );
	if ( is_writable( $layoutfile ) ) {
		$contents = cuttz_clean_css( $css );
		$contents = apply_filters( 'cuttz_settings', $contents );
		$res      = @fopen( $layoutfile, 'w' );
		if ( is_resource( $res ) ) {
			fwrite( $res, $contents );
			fclose( $res );
			wp_cache_flush();
		}
	} else {
		printf( __( '<p>Cuttz Notice: The %s file is not writable.</p>', 'cuttz-framework' ), $layoutfile );
	}
	$cuttz_debug = cuttz_get_res( 'dir' ) . 'debug.css';
	file_put_contents( $cuttz_debug, apply_filters( 'cuttz_settings', $css ) );
	//llog($css);
}

/**
 * Debug function to help return calling function name
 * @param bool $completeTrace 
 * @return array
 * @since 1.0
 */
function getCallingFunctionName( $completeTrace = false ) {
	$trace = debug_backtrace();
	if ( $completeTrace ) {
		$str = '';
		foreach ( $trace as $caller ) {
			$str .= " -- Called by {$caller['function']}";
			if ( isset( $caller['class'] ) )
				$str .= " From Class {$caller['class']}";
		}
	} else {
		$caller = $trace[2];
		$str    = "Called by {$caller['function']}";
		if ( isset( $caller['class'] ) )
			$str .= " From Class {$caller['class']}";
	}
	return $str;
}

/**
 * Sorts an array by a certain order. Used to sort dynamic media queries
 * @param type array $tosort 
 * @param type array $orderArray 
 * @return array
 * @since 1.0
 */
function sortArrayByArray( array $tosort, array $orderArray ) {
	$ordered = array();
	foreach ( $orderArray as $key => $value ) {
		if ( array_key_exists( $key, $tosort ) ) {
			$ordered[$key] = $tosort[$key];
		}
	}
	return $ordered;
}

add_filter( 'cuttz_settings', 'cuttz_settings_file_header' );

/**
 * Returns a string containing a user warning message to be used in the settings CSS file.
 * @param string $css 
 * @return string
 * @since 1.0
 */
function cuttz_settings_file_header( $css ) {
	$msg = '/*!' . __( 'Do not edit this file directly. It\'s always overwritten upon saving of settings.', 'cuttz-framework' ) . '*/';
	return $msg . $css;
}

$cuttz_user_path;

/**
 * Initializes the cuttz user directory and files
 * @param string $path 
 * @return bool true upon success else false
 * @since 1.0
 */
function cuttz_init_path( $path ) {
	if ( !is_dir( $path ) ) {
		if ( !wp_mkdir_p( $path ) ) {
			return false;
		}
	}

	global $cuttz_user_path;

	if ( is_dir( $cuttz_user_path ) ) {
		$css = $cuttz_user_path . '/style.scss';
		$php = $cuttz_user_path . '/functions.php';
		if ( !file_exists( $css ) ) {
			$msg       = __( "/**************** Place all your css customizations in the style.scss file *****************/\n\n", 'cuttz-framework' );
			$style_out = file_put_contents( $css, $msg );
		}
		if ( !file_exists( $php ) ) {
			$msg           = __( "<?php\n/******** Place all your wp/php tweaks here ****************/\n/******** This is your master functions.php file ******/\n", 'cuttz-framework' );
			$functions_out = file_put_contents( $php, $msg );
		}
	}

	if ( !file_exists( $php ) || !file_exists( $css ) ) {
		return false;
	}

	return true;
}


/**
 * Returns the requested resource (url or path of the requested directory or file from cuttz-user)
 * @param string $info (type of information requested… url/path of a directory or a file)
 * @param type $res (the resource for which the information has been requested… settings.css etc.)
 * @return type
 * @since 1.0
 */
function cuttz_get_res( $info = false, $res = null ) {
	$loc     = '';
	$uploads = wp_upload_dir();
	if ( $info == 'fileurl' || $info == 'dirurl' ) {
		$loc = $uploads['baseurl'] . '/cuttz-user/';
	} else {
		$loc = $uploads['basedir'] . '/cuttz-user/';
	}
	global $cuttz_user_path;
	$cuttz_user_path = $uploads['basedir'] . '/cuttz-user';
	if ( cuttz_init_path( $cuttz_user_path ) ) {
		if ( $info == 'dir' || $info == 'dirurl' ) {
			return $loc;
		}
		switch ( $res ) {
		case 'userphp':
			$loc .= 'functions.php';
			break;
		case 'usercss':
			$loc .= 'autogenerated.css';
			break;
		case 'usersass':
			$loc .= 'style.scss';
			break;
		case 'settingscss':
			$loc .= 'settings.css';
			break;
		default:
			break;
		}
		return $loc;
	}
	return false;
}

/**
 * Cleans/minifies a given CSS
 * @param string $css 
 * @return string CSS
 * @since 1.0
 */

function cuttz_clean_css( $css ) {
	$css = preg_replace( '/\s+/', ' ', $css );
	$css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );
	$css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css );
	$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );
	return apply_filters( 'cuttz_clean_css', $css );
}