<?php

add_action( 'add_meta_boxes', 'cuttz_add_schema_settings_box' );

/**
 * Adds the schema metabox at the post editor screen
 * @return type
 * @since 1.0
 */
function cuttz_add_schema_settings_box() {
	if( !current_theme_supports( 'cuttz-schema' ) )
		return;
	foreach ( (array) get_post_types( array(
		'public' => true
	) ) as $type ) {
		if ( post_type_supports( $type, 'cuttz-schema' ) ) {
			add_meta_box( 'cuttzschema', __( 'Cuttz Schema', 'cuttz-framework' ), 'cuttz_schema_meta_box', $type, 'side', 'default' );
		}
	}
}


/**
 * Outputs the markup of the schema metabox
 * @param type $post 
 * @return none
 * @since 1.0
 */
function cuttz_schema_meta_box( $post ) {
	global $post;
	if ( get_option( 'show_on_front' ) == 'page' ) {
		$posts_page_id = get_option( 'page_for_posts' );
		if ( $posts_page_id == $post->ID ) {
			echo '<p><em>' . __( 'Cuttz Schema is not available on on the posts page.', 'cuttz-framework' ) . '</em></p>';
			return;
		}
	}
	wp_nonce_field( 'cuttz_schema_box', 'cuttz_schema_box_nonce' );
	$cuttz_schema  = get_post_meta( $post->ID, '_cuttz_schema', 1 );
	$current_schema = isset( $cuttz_schema ) ? $cuttz_schema : false;
	echo '<p>' . __( 'Depending on the semantics of this content you may select a specific schema to override the default.', 'cuttz-framework' ) . '</p>';
	echo '<select id="cuttz_schema" name="cuttz_schema">';
	$cuttz_schemas = cuttz_get_schemas();

	foreach ( $cuttz_schemas as $key => $value ) {
		$selected = selected( $key, $current_schema, 0 );
		echo '<option ' . $selected . ' value="' . $key . '">' . $value['name'] . '</option>' . "\n";
	}
	echo '</select>';
}


add_action( 'save_post', 'cuttz_save_schema_settings' );

/**
 * Saves the schema settings when the post is saved
 * @param type $post_id 
 * @return none
 * @since 1.0
 */
function cuttz_save_schema_settings( $post_id ) {
	if ( !isset( $_POST['cuttz_schema_box_nonce'] ) ) {
		return;
	}
	if ( !wp_verify_nonce( $_POST['cuttz_schema_box_nonce'], 'cuttz_schema_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	
	/* It's safe for us to save the data now */
	// Make sure it is set
	if ( !isset( $_POST['cuttz_schema'] ) ) {
		return;
	}
	$cuttz_schema = isset( $_POST['cuttz_schema'] ) ? $_POST['cuttz_schema'] : false;
	
	update_post_meta( $post_id, '_cuttz_schema', $cuttz_schema );
}


/**
 * Builds a list of schemas
 * @return array
 * @since 1.0
 */
function cuttz_get_schemas() {
	$cuttz_schemas = array(
		'none' => array(
			'name' => __( 'Default', 'cuttz-framework' ),
			'itemtype' => '',
			'context' => ''
		),
		'about-page' => array(
			'name' => __( 'About Page', 'cuttz-framework' ),
			'itemtype' => 'http://schema.org/AboutPage',
			'context' => 'body'
		),
		'contact-page' => array(
			'name' => __( 'Contact Page', 'cuttz-framework' ),
			'itemtype' => 'http://schema.org/ContactPage',
			'context' => 'body'
		),
		'profile-page' => array(
			'name' => __( 'Profile Page', 'cuttz-framework' ),
			'itemtype' => 'http://schema.org/ProfilePage',
			'context' => 'body'
		),
		'qa-page' => array(
			'name' => __( 'QA Page', 'cuttz-framework' ),
			'itemtype' => 'http://schema.org/QAPage',
			'context' => 'body'
		),
		'article' => array(
			'name' => __( 'Article', 'cuttz-framework' ),
			'itemtype' => 'http://schema.org/Article',
			'context' => 'entry'
		),
		'review' => array(
			'name' => __( 'Review', 'cuttz-framework' ),
			'itemtype' => 'http://schema.org/Review',
			'context' => 'entry'
		),
		'recipe' => array(
			'name' => __( 'Recipe', 'cuttz-framework' ),
			'itemtype' => 'http://schema.org/Recipe',
			'context' => 'entry'
		)
	);

	return apply_filters( 'cuttz_schemas', $cuttz_schemas );
}

/**
 * Return a particular schema from the list of all schemas
 * @param string $schema 
 * @return string
 * @since 1.0
 */
function cuttz_get_schema( $schema ) {
	if ( !$schema )
		return;

	$schemas = cuttz_get_schemas();
	if ( array_key_exists( $schema, $schemas ) ) {
		return $schemas[$schema];
	}
}


add_action( 'wp_head', 'cuttz_set_schema' );

/**
 * Inserts the schema to the frontend
 * @return none
 * @since 1.0
 */
function cuttz_set_schema() {
	if( !current_theme_supports( 'cuttz-schema' ) )
		return;
	
	if ( !is_single() && !is_page() )
		return;
	global $post;
	$schema = get_post_meta( $post->ID, '_cuttz_schema', 1 );
	if ( $schema == 'none' )
		return;
	if ( !empty( $schema ) ) {
		$schema  = cuttz_get_schema( $schema );
		$context = $schema['context'];
		add_filter( 'genesis_attr_' . $context, 'cuttz_attributes_node' );
	}
}