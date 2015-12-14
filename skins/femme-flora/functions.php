<?php

/**
 * Cuttz Framework Core Skin
 * Skin Name: Femme Flora
 * Highlights: Beautiful Feminine Design, Genesis Grid Loop, in-built social sharing
 */

/**
 * Enqueue cuttz skin specific scripts
 * @since 1.0
 */

add_action( 'wp_enqueue_scripts', 'femme_scripts' );

function femme_scripts() {
	wp_enqueue_script( 'femme-scripts', SKIN_URL . '/scripts/femme_scripts.js', array(), false, false );
}

/**
 * Enqueue Raleway Google font as a fallback for Century Gothic on Mac 
 * @since 1.0
 */
 
function femme_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'femme-raleway', "$protocol://fonts.googleapis.com/css?family=Raleway:400,700" );
}

add_action( 'wp_enqueue_scripts', 'femme_fonts' );

/**
 * Setting up the skin defaults for femme flora
 * @return array
 * @since 1.0
 */

add_filter( 'cuttz_skin_defaults', 'femme_skin_defaults' );

function femme_skin_defaults( $defaults ) {
	
	$defaults['skin-version']	= 'false';
	$defaults['layout']         = 'fullwidth';
	$defaults['col-spacing']         = '35';
	$defaults['column-content-1col'] = '975';
	$defaults['column-content-2col'] = '645';
	$defaults['sidebar-one-2col']    = '295';
	$defaults['column-content-3col'] = '475';
	$defaults['sidebar-one-3col']    = '215';
	$defaults['sidebar-two-3col']    = '215';
	$defaults['body-font-family']					= 'century_gothic';
	$defaults['body-font-weight']					= '400';
	$defaults['body-font-size'] = '15';
	$defaults['form-font-size'] = '14';
	$defaults['site-background-color'] = '#ffffff';
	$defaults['page-background-color'] = '#ffffff';
	$defaults['primary-text-color']    = '#665c61';
	$defaults['primary-link-color']    = '#bf80a0';
	$defaults['primary-link-hover-color']    = '#00d2e6';
	$defaults['form-font-family']					= 'century_gothic';
	$defaults['form-text-color']       = '#665c61';
	$defaults['site-title-font-color']  = '#bf80a0';
	$defaults['site-title-font-size']   = '72';
	$defaults['site-title-font-family']				= 'italianno';
	$defaults['site-title-font-weight']				= 'regular';	
	$defaults['site-description-font-color']  = '#bf80a0';
	$defaults['site-description-font-size']   = '20';
	$defaults['site-description-font-family']		= 'cinzel';
	$defaults['site-description-font-weight']  		= 'regular';
	$defaults['headline-font-family']				= 'cinzel';
	$defaults['headline-font-weight']				= 'regular';
	$defaults['headline-font-color']  = '#bf80a0';
	$defaults['headline-font-size']   = '24';	
	$defaults['headline-subhead-font-color']  = '#bf80a0';
	$defaults['headline-subhead-font-family']		= 'cinzel';
	$defaults['headline-subhead-font-weight']		= 'regular';
	$defaults['nav-menu-font-family']				= 'century_gothic';
	$defaults['nav-menu-font-weight']				= '400';
	$defaults['nav-menu-font-size']                      = '14';
	$defaults['nav-menu-link-text-color']                = '#bf80a0';
	$defaults['nav-menu-link-text-hover-color']          = '#ffffff';
	$defaults['nav-menu-current-link-text-color']        = '#ffffff';
	$defaults['nav-menu-current-parent-link-text-color'] = '#ffffff';
	$defaults['nav-menu-link-bg-color']                  = '#ffffff';
	$defaults['nav-menu-hover-bg-color']                 = '#bf80a0';
	$defaults['nav-menu-current-bg-color']               = '#bf80a0';
	$defaults['nav-menu-current-parent-bg-color']        = '#bf80a0';
	$defaults['nav-menu-border-width']                   = '0';
	$defaults['nav-menu-border-color']                   = '#bf80a0';
	$defaults['nav-menu-submenu-width']                  = '200';	
	$defaults['subnav-menu-font-family']			= 'century_gothic';
	$defaults['subnav-menu-font-weight']			= 'regular';
	$defaults['subnav-menu-font-size']                      = '12';
	$defaults['subnav-menu-link-text-color']                = '#bf80a0';
	$defaults['subnav-menu-link-text-hover-color']          = '#ffffff';
	$defaults['subnav-menu-current-link-text-color']        = '#ffffff';
	$defaults['subnav-menu-current-parent-link-text-color'] = '#ffffff';
	$defaults['subnav-menu-link-bg-color']                  = '#f4f4f4';
	$defaults['subnav-menu-hover-bg-color']                 = '#bf80a0';
	$defaults['subnav-menu-current-bg-color']               = '#bf80a0';
	$defaults['subnav-menu-current-parent-bg-color']        = '#bf80a0';
	$defaults['subnav-menu-border-width']                   = '0';
	$defaults['subnav-menu-border-color']                   = '#bf80a0';
	$defaults['subnav-menu-submenu-width']                  = '200';	
	$defaults['byline-font-family']					= 'century_gothic';
	$defaults['byline-font-weight']					= '400';	
	$defaults['byline-font-color']  = '#999999';
	$defaults['byline-font-size']   = '13';
	$defaults['sidebar-font-family']				= 'century_gothic';
	$defaults['sidebar-font-weight']				= '400';
	$defaults['sidebar-font-color']          = '#665c61';
	$defaults['sidebar-font-size']           = '14';
	$defaults['sidebar-heading-font-family']		= 'cinzel';
	$defaults['sidebar-heading-font-weight']		= 'regular';
	$defaults['sidebar-heading-font-size']   = '18';
	$defaults['sidebar-heading-font-color']  = '#bf80a0';	
	$defaults['footer-widgets-font-family']			= 'century_gothic';
	$defaults['footer-widgets-font-weight']			= 'regular';
	$defaults['footer-widgets-font-color']          = '#665c61';
	$defaults['footer-widgets-font-size']           = '14';	
	$defaults['footer-widgets-heading-font-family']	= 'cinzel';
	$defaults['footer-widgets-heading-font-weight']	= 'regular';
	$defaults['footer-widgets-heading-font-size']   = '16';
	$defaults['footer-widgets-heading-font-color']  = '#bf80a0';	
	$defaults['footer-font-family']					= 'century_gothic';
	$defaults['footer-font-weight']					= 'regular';
	$defaults['footer-font-color']  = '#91868c';
	$defaults['footer-font-size']   = '13';
	$defaults['cuttz-web-fonts']	= 'Italianno:regular|Italianno:regular|Cinzel:regular|Cinzel:regular|Cinzel:regular|Cinzel:regular|Cinzel:regular|';
    return $defaults;
	
}

/**
 * Adding image size for grid loop
 * @since 1.0
 */

add_image_size('femme-grid-thumbnail', 480, 360, true);


/**
 * Customizing Read More text which shows on excerpt 
 * @since 1.0
 */

remove_action( 'genesis_entry_content', 'show_read_more_on_excerpt' );
add_action( 'genesis_entry_content', 'femme_show_read_more_on_excerpt' );

function femme_show_read_more_on_excerpt() {
	if ( is_singular() || ( function_exists( 'is_bbPress' ) && is_bbPress() ) ) {
		return;
	}
	if ( 'excerpts' == genesis_get_option( 'content_archive' ) || has_excerpt() ) {
		echo '<p class="more-link-excerpt"><a href="' . get_permalink() . '" class="more-link">' . __( 'Continue Reading', 'cuttz-framework' ) . '</a></p>';
	}
}


/**
 * Setting up the grid loop for home and archive views
 * @return array
 * @since 1.0
 */

add_action('genesis_before', 'femme_grid_loop_helper');
add_action('genesis_before_entry', 'femme_switch_content');

function femme_grid_loop_helper() {
	if(function_exists('is_shop') && is_shop()) return;
	if(is_tax()) return;
	
	if(!is_singular()) {
		if(is_404()) return;
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'femme_grid_loop' );
	}
}

function femme_grid_loop() {
	if ( function_exists( 'genesis_grid_loop' ) ) {
		genesis_grid_loop( array(
			'features' => 1,
			'feature_image_size' => 'large',
			'feature_image_class' => 'cuttz-alignnone post-image',
			'feature_content_limit' => 200,
			'grid_image_size' => 'femme-grid-thumbnail',
			'grid_image_class' => 'post-image',
			'grid_content_limit' => 'no_content',
			'more' => __( 'Continue reading', 'cuttz-framework' ),
		) );
	} else {
		genesis_standard_loop();
	}
} 

function femme_switch_content() {
	if ( in_array( 'genesis-feature', get_post_class()) || in_array( 'genesis-grid', get_post_class())) {
		remove_action( 'genesis_entry_content', 'show_read_more_on_excerpt' );
		remove_action('genesis_entry_content', 'genesis_grid_loop_content');
		add_action('genesis_entry_content', 'femme_grid_loop_content');
	}
} 

function femme_grid_loop_content() {

	global $_genesis_loop_args;
	

	if ( in_array( 'genesis-feature', get_post_class() ) ) { // if the post is a feature

		if ( $_genesis_loop_args['feature_image_size'] ) {

			$image = genesis_get_image( array(
				'size'    => $_genesis_loop_args['feature_image_size'],
				'context' => 'grid-loop-featured',
				'attr'    => genesis_parse_attr( 'entry-image-grid-loop', array( 'class' => $_genesis_loop_args['feature_image_class'] ) ),
			) );

			printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $image );

		}

		if ( $_genesis_loop_args['feature_content_limit'] )
			the_content_limit( (int) $_genesis_loop_args['feature_content_limit'], esc_html( $_genesis_loop_args['more'] ) );
		else
			the_content( esc_html( $_genesis_loop_args['more'] ) );

	}

	else {	// The post is a teaser

		$default_img = '<img class="post-image" itemprop="image" src="'.CUTTZ_CORE_SKINS_URL.'/femme-flora/images/femme-default-img.png" alt="Femme-Flora" />';
		
		if ( $_genesis_loop_args['grid_image_size'] ) {
			
			$image = genesis_get_image( array(
				'size'    => $_genesis_loop_args['grid_image_size'],
				'context' => 'grid-loop',
				'attr'    => genesis_parse_attr( 'entry-image-grid-loop', array( 'class' => $_genesis_loop_args['grid_image_class'] ) ),
			) );

			printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), empty( $image ) ? $default_img : $image );

		}
		
		if ( $_genesis_loop_args['grid_content_limit'] == 'no_content') {
			printf( __( '%sClick to read more&hellip;%s', 'cuttz-framework' ), '<a href="'.get_permalink().'" class="more-link"><span class="more-link-content">', '</span></a>' );
		}
		
		elseif ( $_genesis_loop_args['grid_content_limit'] ) {
			the_content_limit( (int) $_genesis_loop_args['grid_content_limit'], esc_html( $_genesis_loop_args['more'] ) );
		}
		
		else {
			//the_excerpt();
			printf( '<a href="%s" class="more-link">%s</a>', get_permalink(), esc_html( $_genesis_loop_args['more'] ) );
		}

	}
}

/**
 * Adding a clear div to clear the floats for grid loop
 * @since 1.0
 */

add_action('genesis_after_endwhile', 'femme_clear_grid', 9);

function femme_clear_grid() {
	echo '<div class="clear"></div>';	
}
 

/**
 * Removing entry-footer from Genesis grid
 * @since 1.0
 */
 
add_action('genesis_before_entry','remove_grid_entry_footer');

function remove_grid_entry_footer() {
	if ( in_array( 'genesis-grid', get_post_class() ) ) {
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}

/**
 * Filtering genesis post info to only show date and edit link
 * @returns post_info
 * @since 1.0
 */

add_filter('genesis_post_info','femme_post_info');

function femme_post_info($post_info) {
	if(is_attachment()) return;
	if(!is_page()) {
		$post_info = '[post_date] [post_edit]';
		return $post_info;
	}
}

/**
 * Filtering genesis post meta to comments and share icons
 * @returns $post_meta
 * @since 1.0
 */

add_filter( 'genesis_post_meta', 'femme_post_meta' );

function femme_post_meta($post_meta) {
	if(is_attachment()) return;
	$post_meta = '<span class="left-meta">[post_categories before="Categories: "]</span> <span class="right-meta">[post_comments zero="Comment" one="1 Comment" more="% Comments"] <span class="divider">/</span> [post_share]</span><span class="clear"></span>';
	return $post_meta;
}

/**
 * Defining a shortcode for social sharing icons 
 * @returns share icons
 * @since 1.0
 */

add_shortcode('post_share', 'femme_post_share_shortcode');

function femme_post_share_shortcode($atts) {
	global $post;
	$imageurl = CUTTZ_CORE_SKINS_URL . '/femme-flora/images/femme-default-img.png';
	if (has_post_thumbnail( $post->ID ) ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
		$imageurl = rawurlencode( $image[0]);
	}
	$title=urlencode(get_the_title());
	$urlenc = rawurlencode(get_permalink());
	ob_start();
	?>
	<span class="femme-share">
		Share 
		<a class="femme-fb" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo untrailingslashit( get_permalink() );?>&amp;display=popup" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a>
		
		<a class="femme-twitter" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php echo $urlenc; ?>" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>	
		
		<a class="femme-gplus" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"  onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a>
		
		<a class="femme-pin" href="http://pinterest.com/pin/create/button/?url=<?php echo $urlenc; ?>&media=<?php echo $imageurl; ?>&amp;description=<?php echo $title; ?>" count-layout="none" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-pinterest-square"></i></a>
		
	</span>
	<?php
	$share_buttons = ob_get_clean();
	return $share_buttons;
}	

/**
 * Setting up animated search icon
 * Adds animated search box as last menu item in primary nav menu 
 * @returns $menu
 * @since 1.0
 */

add_filter( 'wp_nav_menu_items', 'femme_search_menu_item', 10, 2 );

function femme_search_menu_item( $menu, $args ) {
	if ( 'primary' !== $args->theme_location )
		return $menu;
	$menu .= '<li class="search"><a id="main-nav-search-link" class="icon-search"></a><div class="search-div">' . get_search_form( false ) . '</div></li>';
	return $menu;
}

add_filter( 'genesis_search_button_text', 'femme_search_button_text' );

function femme_search_button_text( $text ) {
	return esc_attr( 'Go' );
}

/**
 * Enable post navigation for single posts
 * @since 1.0
 */

add_action( 'genesis_entry_footer', 'femme_prev_next_post_nav' );

function femme_prev_next_post_nav() {
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
 * Displays featured image on single post
 * @since 1.0
 */

add_action( 'genesis_entry_content', 'femme_single_post_featured_image', 9 );

function femme_single_post_featured_image() {
	if(is_single()) {
		$image_args = array(
		'size' => 'large',
		'attr' => array(
		'class' => 'cuttz-alignnone',
		));
	genesis_image( $image_args );
	}
}

/**
 * Defining femme flora styles dependent on skin settings
 * @param $css 
 * @param $settings 
 * @param $widths 
 * @return array
 * @since 1.0
 */

add_filter( 'cuttz_settings_css', 'femme_settings_css', 10, 3 );

function femme_settings_css($css, $settings, $widths) {
	$css = $css . '.nav-primary .menu { border-top: 1px solid '.$settings['nav-menu-border-color'].'; }';
	$css = $css . '.nav-primary .menu { border-bottom: 1px solid '.$settings['nav-menu-border-color'].'; }';
	$css = $css . '.nav-secondary { background-color:'.$settings['subnav-menu-link-bg-color'].'; }';
	$css = $css . '.author-box-title { font-family:'.$settings['headline-font-family'].'; }';
	$css = $css . 'blockquote::before { color:'.$settings['primary-link-color'].'; }';
	$css = $css . '.femme-flora .genesis-feature .more-link { border: 1px solid '.$settings['primary-link-color'].'; }';
	$css = $css . '.femme-flora .genesis-feature .more-link:hover { border-color:'.$settings['primary-link-hover-color'].'; }';
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

add_filter( 'cuttz_media_queries', 'femme_media_queries', 10, 3 );

function femme_media_queries($resp_css, $widths, $settings) {
	$resp_css['min-width'] = $resp_css['min-width']. 'body.femme-flora .nav-primary .menu > .search {display: none;}';
	$resp_css['min-width'] = $resp_css['min-width'].'body.femme-flora .nav-primary .genesis-nav-menu a {padding: 0.618em 1em; border-bottom: 1px solid #e5e5e5;}';
	$resp_css['min-width'] = $resp_css['min-width'].'body.femme-flora .nav-primary .genesis-nav-menu li:last-child a { border-bottom: none;}';
	return $resp_css;
}

/**
 * Adding theme support for content width
 * used primarily for image galleries powered by Jetpack
 * @since 1.0
 */

if ( ! isset( $content_width ) ) {
	$content_width = 975;
}


/**
 * Adding woocommerce specific customizations
 * forces full-width layout for product category, product tag and cart view 
 * removes star rating from shop loop  
 * @since 1.0
 */

add_action( 'wp_head', 'femme_woo_pages_customization' );

function femme_woo_pages_customization() {
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;
	
	if(is_product_category() || is_product_tag() || is_cart() || is_shop()) {
		add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');
	}
	
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
}