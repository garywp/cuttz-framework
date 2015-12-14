<?php

add_action( 'add_meta_boxes', 'cuttz_add_landing_sections_meta_box', 9 );

/**
 * Register a new meta box to the post or page edit screen, so that the user can add landing section
 * on a per-post or per-page basis.
 */
function cuttz_add_landing_sections_meta_box() {
	if( !current_theme_supports( 'cuttz-landing-sections' ) )
		return;
	
	global $post;
	if ( get_option( 'show_on_front' ) == 'page' ) {
		$posts_page_id = get_option( 'page_for_posts' );
		if ( $posts_page_id == $post->ID ) {
			add_action( 'edit_form_after_title', 'cuttz_landing_section_posts_notice' );
			return;
		}
	}
	if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) ) {
		if( $post->ID == wc_get_page_id( 'shop' ) ) {
			add_action( 'edit_form_after_title', 'cuttz_landing_section_shop_notice' );
			return;
		}
	}

	$context  = 'normal';
	$priority = 'high';
	foreach ( (array) get_post_types( array(
		'public' => true
	) ) as $type ) {
		if ( post_type_supports( $type, 'cuttz-landing-sections' ) ) {
			add_meta_box( 'landing-sections', __( 'Cuttz Landing Sections', 'cuttz-framework' ), 'cuttz_landing_sections_box', $type, $context, $priority );
		}
	}
}

// Outputs an info on on the posts page where landing sections are not available.
function cuttz_landing_section_posts_notice() {
	echo '<div class="notice notice-warning inline"><p>' . __( 'Cuttz Landing Pages Sections are not available on the posts page.', 'cuttz-framework' ) . '</p></div>';
}

// Outputs an info on on WooCommerce shop page where landing sections are not available.
function cuttz_landing_section_shop_notice() {
	echo '<div class="notice notice-warning inline is-dismissible"><p>' . __( 'Cuttz Landing Pages Sections are not available on WooCommerce Shop page.', 'cuttz-framework' ) . '</p></div>';
}


/**
 * Callback for landing page sections.
 * Builds the backend UI
 * @param $post
 * @since 1.0
 */

function cuttz_landing_sections_box( $post ) {
	global $post;
	wp_nonce_field( 'cuttz_landing_sections_save', 'cuttz_landing_sections_box' );
	$title_placeholder         = 'Enter the section title here';
	$cuttz_ls_section_options = get_post_meta( $post->ID, '_cuttz_ls_section_options', 1 );
	$cuttz_landing_sections   = cuttz_get_landing_sections();

	foreach ( $cuttz_landing_sections as $cuttz_landing_section => $cuttz_landing_section_val ) {
		$section_name         = $cuttz_landing_section;
		$section_title        = isset( $cuttz_ls_section_options['ls_' . $section_name . '_title'] ) ? $cuttz_ls_section_options['ls_' . $cuttz_landing_section . '_title'] : '';
		$section_content      = isset( $cuttz_ls_section_options['ls_' . $section_name . '_content'] ) ? $cuttz_ls_section_options['ls_' . $cuttz_landing_section . '_content'] : '';
		$hide_section_desktop = isset( $cuttz_ls_section_options['ls_' . $section_name . '_hide_desktop'] ) ? $cuttz_ls_section_options['ls_' . $cuttz_landing_section . '_hide_desktop'] : false;
		$hide_section_mobile  = isset( $cuttz_ls_section_options['ls_' . $section_name . '_hide_mobile'] ) ? $cuttz_ls_section_options['ls_' . $cuttz_landing_section . '_hide_mobile'] : false;
?>
		<div class="landing-section-stuff">
			<h4><?php
		echo $cuttz_landing_section_val['heading'];
		?></h4>
			<div class = "section-title">
				<label class="title-prompt-text" for="<?php
		echo 'ls_' . $cuttz_landing_section . '_title';
		?>"><?php
		echo $title_placeholder;
		?></label>
				<input type="text" name="<?php
		echo 'ls_' . $cuttz_landing_section . '_title';
		?>" value="<?php
		echo $section_title;
		?>" id="<?php
		echo 'ls_' . $cuttz_landing_section . '_title';
		?>" spellcheck="true" autocomplete="off" />
			</div>
			<div class = "section-content">
			<?php
		$settings = array(
			'textarea_name' => 'ls_' . $section_name . '_content',
			'textarea_rows' => 7,
			'dfw' => true,
			'drag_drop_upload' => true
		);
		wp_editor( $section_content, 'ls_' . $section_name . '_content', $settings );
?>
			</div>
			<p>
				<input type="checkbox" id="<?php
		echo 'ls_' . $cuttz_landing_section . '_hide_desktop';
		?>" name="<?php
		echo 'ls_' . $cuttz_landing_section . '_hide_desktop';
		?>" value="true" <?php
		checked( $hide_section_desktop, true );
		?> />
				<label for="<?php
		echo 'ls_' . $cuttz_landing_section . '_hide_desktop';
		?>"><?php
		_e( 'Hide on Desktop', 'cuttz-framework' );
		?></label>
			</p>
			<p>
				<input type="checkbox" id="<?php
		echo 'ls_' . $cuttz_landing_section . '_hide_mobile';
		?>" name="<?php
		echo 'ls_' . $cuttz_landing_section . '_hide_mobile';
		?>" value="true" <?php
		checked( $hide_section_mobile, true );
		?> />
				<label for="<?php
		echo 'ls_' . $cuttz_landing_section . '_hide_mobile';
		?>"><?php
		_e( 'Hide on Mobile', 'cuttz-framework' );
		?></label>
			</p>
		</div>
		<?php
	}
}

add_action( 'save_post', 'cuttz_landing_sections_save_settings' );

/**
 * Save the Landing sections when we save a post or page.
 * @param $post_id
 * @since 1.0
 */
function cuttz_landing_sections_save_settings( $post_id ) {
	// Check if our nonce is set.
	if ( !isset( $_POST['cuttz_landing_sections_box'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( !wp_verify_nonce( $_POST['cuttz_landing_sections_box'], 'cuttz_landing_sections_save' ) ) {
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
	$cuttz_ls_section_options = array();
	$cuttz_landing_sections   = cuttz_get_landing_sections();

	foreach ( $cuttz_landing_sections as $cuttz_landing_section => $cuttz_landing_section_val ) {
		$section_name                                                       = $cuttz_landing_section;
		$cuttz_ls_section_options['ls_' . $section_name . '_title']        = isset( $_POST['ls_' . $section_name . '_title'] ) ? sanitize_text_field( $_POST['ls_' . $section_name . '_title'] ) : '';
		$cuttz_ls_section_options['ls_' . $section_name . '_content']      = isset( $_POST['ls_' . $section_name . '_content'] ) ? ( current_user_can( 'unfiltered_html' ) ? $_POST['ls_' . $section_name . '_content'] : wp_filter_post_kses( $_POST['ls_' . $section_name . '_content'] ) ) : '';
		$cuttz_ls_section_options['ls_' . $section_name . '_hide_desktop'] = isset( $_POST['ls_' . $section_name . '_hide_desktop'] ) ? true : false;
		$cuttz_ls_section_options['ls_' . $section_name . '_hide_mobile']  = isset( $_POST['ls_' . $section_name . '_hide_mobile'] ) ? true : false;
	}

	update_post_meta( $post_id, '_cuttz_ls_section_options', $cuttz_ls_section_options );
}


add_action( 'genesis_before', 'cuttz_output_landing_sections' );

/**
 * Checks if landing page sections are populated
 * Defines the markup for the landing sections.
 * Hooks landing sections on front
 * @since 1.0
 */
function cuttz_output_landing_sections() {
	if( !current_theme_supports( 'cuttz-landing-sections' ) )
		return;
		
	if ( is_404() || is_search() ) {
		return;
	}
	global $post;

	$cuttz_landing_sections = cuttz_get_landing_sections();
	foreach ( $cuttz_landing_sections as $cuttz_landing_section => $cuttz_landing_section_val ) {
		$section_name  = $cuttz_landing_section;
		$hook_name     = $cuttz_landing_section_val['hook'];
		$hook_priority = $cuttz_landing_section_val['priority'];
		$callback = function() use ( $section_name ) {
			cuttz_landing_section_markup( $section_name );
		};
		add_action( $hook_name, $callback, $hook_priority ); // to dynamically build the markup for landing-sections to show on the front-end
	}
}


/* Defines an array for creation of landing sections
 * @filter use 'cuttz_landing_sections' to add extra landing sections
 */

function cuttz_get_landing_sections() {
	$cuttz_landing_sections = array(
		'after_header_first' => array(
			'context' => 'after-header-first',		//used for id/classname
			'heading' => __( 'Landing Section After Header First', 'cuttz-framework' ),	//used for heading on the backend
			'hook' => 'genesis_after_header',	//hook where the section will be output
			'priority' => '10'	//priority of the hook
		),
		'after_header_second' => array(
			'context' => 'after-header-second',
			'heading' => __( 'Landing Section After Header Second', 'cuttz-framework' ),
			'hook' => 'genesis_after_header',
			'priority' => '11'
		),
		'after_header_third' => array(
			'context' => 'after-header-third',
			'heading' => __( 'Landing Section After Header Third', 'cuttz-framework' ),
			'hook' => 'genesis_after_header',
			'priority' => '12'

		),
		'before_footer_first' => array(
			'context' => 'before-footer-first',
			'heading' => __( 'Landing Section Before Footer First', 'cuttz-framework' ),
			'hook' => 'genesis_before_footer',
			'priority' => '4'
		),
		'before_footer_second' => array(
			'context' => 'before-footer-second',
			'heading' => __( 'Landing Section Before Footer Second', 'cuttz-framework' ),
			'hook' => 'genesis_before_footer',
			'priority' => '4'
		),
		'before_footer_third' => array(
			'context' => 'before-footer-third',
			'heading' => __( 'Landing Section Before Footer Third', 'cuttz-framework' ),
			'hook' => 'genesis_before_footer',
			'priority' => '4'
		)

	);

	return apply_filters( 'cuttz_landing_sections', $cuttz_landing_sections );
}

/* Helper function to get the genesis context (for use with genesis structural wrap) of the landing section
 * @usage cuttz_landing_section_markup()
 */

function cuttz_get_landing_section_context( $landing_section ) {
	$landing_sections = cuttz_get_landing_sections();
	if ( array_key_exists( $landing_section, $landing_sections ) ) {
		return $landing_sections[$landing_section]['context'];
	} else {
		return;
	}
}

/**
 * Helper function to get the names of the landing section
 * @usage cuttz_landing_section_markup()
 */
function cuttz_landing_section_names() {
	$cuttz_landing_sections = cuttz_get_landing_sections();
	$section_names           = array();
	foreach ( $cuttz_landing_sections as $key => $value ) {
		$section_names[] = $key;
	}
	return $section_names;
}


/**
 * Helper function
 * Used in output functions to build the markup of the landing sections
 * @since 1.0
 */
function cuttz_landing_section_markup( $section_name ) {

	if ( !is_singular() ) {
		return;
	}

	global $post;
	$context                   = cuttz_get_landing_section_context( $section_name );
	$cuttz_ls_section_options = get_post_meta( $post->ID, '_cuttz_ls_section_options', 1 );

	if ( !$cuttz_ls_section_options ) {
		return;
	}

	$section_title        = $cuttz_ls_section_options['ls_' . $section_name . '_title'];
	$section_title        = apply_filters( 'cuttz_landing_section_title', $section_title );
	$section_content      = $cuttz_ls_section_options['ls_' . $section_name . '_content'];
	$hide_section_desktop = isset( $cuttz_ls_section_options['ls_' . $section_name . '_hide_desktop'] ) ? $cuttz_ls_section_options['ls_' . $section_name . '_hide_desktop'] : false;
	$hide_section_mobile  = isset( $cuttz_ls_section_options['ls_' . $section_name . '_hide_mobile'] ) ? $cuttz_ls_section_options['ls_' . $section_name . '_hide_mobile'] : false;

	// Hide if hidden and not visiting on mobile
	if ( $hide_section_desktop && !cuttz_is_mobile() )
		return;

	// Hide if hidden and only on mobile
	if ( $hide_section_mobile && cuttz_is_mobile() )
		return;

	if ( $section_title || $section_content ) {
	?>
		<div class = "<?php echo $context; ?> cuttz-landing-section">
			<?php cuttz_structural_wrap_open( $context ); ?>
				<section class="ls-<?php echo $context; ?> landing-section">
				<?php
				if ( $section_title ) {
					echo '<h2 class="landing-section-title">' . $section_title . '</h2>';
				}
				?>
				<?php
				if ( $section_content ) {
					echo '<div class="landing-section-content">' . apply_filters( 'the_content', $section_content ) . '</div>';
				}
				?>
				</section>
			<?php cuttz_structural_wrap_close( $context ); ?>
		</div>
	<?php
	}
}

/**
 * Helper function
 * Used in cuttz_structural_wrap_open() and cuttz_structural_wrap_close()
 * @param string $context to build the structural wrap for
 * @param array wrap_support of supported wraps.
 * @return bool
 * @since 1.0
 */

function search_context( $context, $wrap_support ) {
	if ( in_array( $context, $wrap_support ) ) {
		return true;
	}
	foreach ( $wrap_support as $element ) {
		if ( is_array( $element ) && search_context( $context, $element ) )
			return true;
	}
	return false;
}

/**
 * Checks if the elements supports genesis-structural-wraps
 * Uses genesis_structural_wrap to open the markup for wrap
 * Echos markup if genesis_structural_wrap is not supported
 * @since 1.0
 */

function cuttz_structural_wrap_open( $context ) {
	$wrap_support = get_theme_support( 'genesis-structural-wraps' );
	if ( search_context( $context, $wrap_support ) ) {
		genesis_structural_wrap( $context );
	} else {
		echo '<div class = "wrap">';
	}
}

/**
 * Checks if the elements supports genesis-structural-wraps
 * Uses genesis_structural_wrap to close the markup for wrap
 * Echos markup if genesis_structural_wrap is not supported
 * @since 1.0
 */

function cuttz_structural_wrap_close( $context ) {
	$wrap_support = get_theme_support( 'genesis-structural-wraps' );
	if ( search_context( $context, $wrap_support ) ) {
		genesis_structural_wrap( $context, 'close' );
	} else {
		echo '</div>';
	}
}