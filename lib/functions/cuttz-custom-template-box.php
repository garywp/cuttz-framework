<?php

add_action( 'add_meta_boxes', 'cuttz_template_box' );

/**
 * Adds a meta box that allows us to choose a custom page template
 * @return none
 * @since 1.0
 */
function cuttz_template_box() {
	$screens = array(
		'page'
	);

	foreach ( $screens as $screen ) {
		add_meta_box( 'cuttzpagetemplate', __( 'Template', 'cuttz-framework' ), 'cuttz_custom_template_meta_box', $screen, 'side', 'core' );
	}

}


/**
 * Outputs the html markup of the meta box that allows us to choose a custom page template
 * @return none
 * @since 1.0
 */
function cuttz_custom_template_meta_box( $post ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'cuttz_custom_template_meta_box', 'cuttz_custom_template_nonce' );
	$value            = get_post_meta( $post->ID, '_cuttz_page_template', true );
	$cuttz_templates = cuttz_get_templates( $post );

	echo '<p>';
	_e( 'Select the page template to be used for this page.', 'cuttz-framework' );
	echo '</p>';
	echo '<select type="text" id="cuttz-page-template" name="cuttz-page-template" value="' . esc_attr( $value ) . '">';
	echo PHP_EOL . '<option value="default">Default Template</option>';
	$current = get_post_meta( $post->ID, '_wp_page_template', true );

	foreach ( $cuttz_templates as $key => $value ) {
		$selected = selected( $current, $key, false );
		echo PHP_EOL . '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . $value . '</option>';
	}
	echo '</select>';

	echo '<style type="text/css">
	#parent_id +p,#page_template {display:none;}
	</style>';
}

/**
 * Gets all the custom templates stored inside the current skin directory
 * @param type $post 
 * @return ? templates
 * @since 1.0
 */
function cuttz_get_templates( $post ) {
	$page_templates = ''; // wp_cache_get( 'page_templates' );
	$page_templates = array();
	$files = glob( SKIN_DIR . '/*.php' );

	foreach ( $files as $file => $full_path ) {
		if ( !preg_match( '|Template Name:(.*)$|mi', file_get_contents( $full_path ), $header ) ) {
			continue;
		}
		$page_templates[basename( $full_path )] = _cleanup_header_comment( $header[1] );
	}

	if ( wp_get_theme()->parent() ) {
		$page_templates = wp_get_theme()->parent()->get_page_templates( $post ) + $page_templates;
	}
	
	return apply_filters( 'cuttz_page_templates', $page_templates, $post );
}


add_action( 'save_post', 'cuttz_save_template_box_data' );
/**
 * Save the setting of our custom page template chooser
 * @param type $post_id 
 * @return none
 * @since 1.0
 */
function cuttz_save_template_box_data( $post_id ) {
	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */
	// Check if our nonce is set.
	if ( !isset( $_POST['cuttz_custom_template_nonce'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( !wp_verify_nonce( $_POST['cuttz_custom_template_nonce'], 'cuttz_custom_template_meta_box' ) ) {
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
	// Make sure that it is set.
	if ( !isset( $_POST['cuttz-page-template'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['cuttz-page-template'] );
	// Update the meta field in the database.

	update_post_meta( $post_id, '_wp_page_template', $my_data );
}



add_filter( 'page_template', 'cuttz_template_locate' );
/**
 * Locates the custom template to use when displaying a page on the front-end
 * @param type $template 
 * @return string path to the custom template
 * @since 1.0
 */
function cuttz_template_locate( $template ) {
	$current = get_page_template_slug();
	if ( empty( $current ) ) {
		return $template;
	}
	if ( basename( $template ) != $current ) { // If Wordpress hasn't been able to locate our custom template
		if ( file_exists( SKIN_DIR . "/$current" ) ) { // And if such a template exists
			return SKIN_DIR . "/$current";
		} else {
			// echo 'such file doesn\'t exist';
		}
	}
	return $template;
}