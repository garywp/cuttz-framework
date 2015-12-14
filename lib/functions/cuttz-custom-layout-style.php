<?php

/**
 *
 * Cuttz Custom Post / Page Layout Metabox
 * Description: Allows users to set custom layout styles for each pages and posts
 * @since 1.1
 *
 */

add_action( 'admin_menu', 'cuttz_custom_layout_styles', 8 );
 
function cuttz_custom_layout_styles() {
	if ( !current_theme_supports( 'cuttz-layout-style' ) )
		return;
	
	foreach( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'cuttz-custom-layout-styles' ) ) {
			add_meta_box( 'cuttz-page-layout', __( 'Cuttz Custom Layout Style Selector', 'cuttz-framework' ), 'cuttz_custom_layout_style_box', $type, 'normal', 'high' );
		}
	}
}

/* Callback to build the Custom Page/Post layout metabox */

function cuttz_custom_layout_style_box( $post ) {
	
	global $typenow;
	
	$cuttz_page_layout = get_post_meta( $post->ID, '_cuttz_page_layout', true );

	$page_layout = empty( $cuttz_page_layout ) ? 'default' : $cuttz_page_layout;
	
	wp_nonce_field( 'cuttz_page_layout_nonce_field', 'cuttz_page_layout_nonce' );
	
	?>
	<div class="cuttz-lp-layout">
	<p>
		<?php printf( __( 'Select a custom page layout style for this %s, if you want it to be different from the default theme layout style.', 'cuttz-framework' ), $typenow ); ?>
	</p>
	<p>
		<input id="layout-default" type="radio" name="page-layout" value="default" <?php checked( $page_layout, 'default' ); ?> /><label for="layout-default"><?php _e( 'Theme Default', 'cuttz-framework' ); ?></label>
	</p>
	<div class="layout-selector">
		<label class="cuttz-page-layout-style" for="fw-layout"><img src="<?php echo CHILD_IMAGES . '/layout-icons/full-width-layout.png' ?>" alt="Full-Width" /><input id="fw-layout" class="screen-reader-text" type="radio" name="page-layout" value="fullwidth" <?php checked( $page_layout, 'fullwidth' ); ?> /><span class="layout-title"><?php _e( 'Full-Width', 'cuttz-framework' ); ?></span></label>
		
		<label class="cuttz-page-layout-style" for="pw-layout"><img src="<?php echo CHILD_IMAGES . '/layout-icons/page-width-layout.png' ?>" alt="Page-Width" /><input id="pw-layout" class="screen-reader-text" type="radio" name="page-layout" value="pagewidth" <?php checked( $page_layout, 'pagewidth' ); ?> /><span class="layout-title"><?php _e( 'Page-Width', 'cuttz-framework' ); ?></span></label>
		
		<div class="clear"></div>
	</div>
	</div>
	<?php
	
}


/* Save the layout style set by the user for page / post */

add_action( 'save_post', 'cuttz_save_layout_style' );

function cuttz_save_layout_style( $post_id ) {
	
	// Check if our nonce is set.
	if ( !isset( $_POST['cuttz_page_layout_nonce'] ) ) {
		return;
	}
	
	// Verify that the nonce is valid.
	if ( !wp_verify_nonce( $_POST['cuttz_page_layout_nonce'], 'cuttz_page_layout_nonce_field' ) ) {
		return;
	}
	
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( !current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* It's safe for us to save the data now. */
	
	$page_layout = empty( $_POST['page-layout'] ) ? 'default' : $_POST['page-layout'];
	
	update_post_meta( $post_id, '_cuttz_page_layout', $page_layout );
	
}


/**
 * Modifies the front-end for layout style as per the user's layout selection
 * @return none
 * @since 1.0
 */
 
add_action( 'wp_head', 'cuttz_custom_layout_style', 10 );

function cuttz_custom_layout_style() {
	if ( !current_theme_supports( 'cuttz-layout-style' ) )
		return;
		
	if ( is_home() ) {
		$page_id = get_option( 'page_for_posts' );
	} else {
		$page_id = get_the_ID();
	}

	/* Execute the post layout option set by the user */

	$cuttz_page_layout = get_post_meta( $page_id, '_cuttz_page_layout', true );
	$page_layout = empty( $cuttz_page_layout ) ? 'default' : $cuttz_page_layout;

	if( $page_layout != 'default' ) {
		add_filter( 'body_class', 'cuttz_set_page_custom_layout' );
	}
}