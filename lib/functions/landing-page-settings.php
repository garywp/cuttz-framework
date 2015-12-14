<?php

/**
 * Inserts the Landing Page Settings meta box
 * @return none
 * @since 1.0
 */
add_action( 'add_meta_boxes', 'cuttz_add_template_settings_box' );

function cuttz_add_template_settings_box() {
	if( !current_theme_supports( 'cuttz-landing-page-experience' ) )
		return;
	
	foreach ( (array) get_post_types( array(
		'public' => true
	) ) as $type ) {
		if ( post_type_supports( $type, 'cuttz-landing-page-experience' ) ) {
			add_meta_box( 'lpsettings', __( 'Cuttz Landing Page Experience', 'cuttz-framework' ), 'cuttz_template_meta_box', $type, 'side', 'default' );
		}
	}
}


/**
 * Builds the actual markup for Cuttz landing page experience
 * @param type $post 
 * @return none
 * @since 1.0
 */
function cuttz_template_meta_box( $post ) {
	global $post, $typenow;
	$cuttz_template_options = get_post_meta( $post->ID, '_cuttz_template_options', 1 );

	$hide_header = isset( $cuttz_template_options['hide-header'] ) ? $cuttz_template_options['hide-header'] : false;

	$hide_breadcrumbs = isset( $cuttz_template_options['hide-breadcrumbs'] ) ? $cuttz_template_options['hide-breadcrumbs'] : false;

	$hide_page_title = isset( $cuttz_template_options['hide-page-title'] ) ? $cuttz_template_options['hide-page-title'] : false;

	$hide_widgets_above_header = isset( $cuttz_template_options['hide-widgets-above-header'] ) ? $cuttz_template_options['hide-widgets-above-header'] : false;

	$hide_widgets_below_header = isset( $cuttz_template_options['hide-widgets-below-header'] ) ? $cuttz_template_options['hide-widgets-below-header'] : false;

	$hide_widgets_above_footer = isset( $cuttz_template_options['hide-widgets-above-footer'] ) ? $cuttz_template_options['hide-widgets-above-footer'] : false;

	$hide_after_entry_widget = isset( $cuttz_template_options['hide-after-entry-widget'] ) ? $cuttz_template_options['hide-after-entry-widget'] : false;

	$hide_footer_widgets = isset( $cuttz_template_options['hide-footer-widgets'] ) ? $cuttz_template_options['hide-footer-widgets'] : false;

	$hide_footer = isset( $cuttz_template_options['hide-footer'] ) ? $cuttz_template_options['hide-footer'] : false;
	
	wp_nonce_field( 'cuttz_template_meta_box_save', 'cuttz_template_meta_box' );
	
	?>
	<p>
        <input type="checkbox" value="true" id="hide-header" name="hide-header" <?php checked( $hide_header, true ); ?> />
        <label for="hide-header"><?php _e( 'Hide Header', 'cuttz-framework' ); ?></label>
	</p>
	<?php

	// building the conditional UI for hide breadcrumbs
	if ( $typenow == 'page' ) {
		if ( 'page' === get_option( 'show_on_front' ) ) {
			$front_page = get_option( 'page_on_front' );
			$blog_page  = get_option( 'page_for_posts' );
			if ( $front_page == $post->ID ) {
				if ( genesis_get_option( 'breadcrumb_front_page' ) == 1 ) {
				?>
					<p>
						<input type="checkbox" value="true" id="hide-breadcrumbs" name="hide-breadcrumbs" <?php checked( $hide_breadcrumbs, true ); ?> />
						<label for="hide-breadcrumbs"><?php _e( 'Hide Breadcrumbs', 'cuttz-framework' ); ?></label>
					</p>
				<?php
				}
			} else {
				if ( $blog_page == $post->ID ) {
					if ( genesis_get_option( 'breadcrumb_posts_page' ) == 1 ) {
					?>
						<p>
							<input type="checkbox" value="true" id="hide-breadcrumbs" name="hide-breadcrumbs" <?php checked( $hide_breadcrumbs, true ); ?> />
							<label for="hide-breadcrumbs"><?php _e( 'Hide Breadcrumbs', 'cuttz-framework' ); ?></label>
						</p>
					<?php
					}
				} else {
					if ( genesis_get_option( 'breadcrumb_page' ) == 1 ) {
					?>
						<p>
							<input type="checkbox" value="true" id="hide-breadcrumbs" name="hide-breadcrumbs" <?php checked( $hide_breadcrumbs, true ); ?> />
							<label for="hide-breadcrumbs"><?php _e( 'Hide Breadcrumbs', 'cuttz-framework' ); ?></label>
						</p>
					<?php
					}
				}
			}
		} else {
			if ( genesis_get_option( 'breadcrumb_page' ) == 1 ) {
			?>
				<p>
					<input type="checkbox" value="true" id="hide-breadcrumbs" name="hide-breadcrumbs" <?php checked( $hide_breadcrumbs, true ); ?> />
					<label for="hide-breadcrumbs"><?php _e( 'Hide Breadcrumbs', 'cuttz-framework' ); ?></label>
				</p>
			<?php
			}
		}
	} else {
		if ( genesis_get_option( 'breadcrumb_single' ) == 1 ) {
		?>
			<p>
				<input type="checkbox" value="true" id="hide-breadcrumbs" name="hide-breadcrumbs" <?php checked( $hide_breadcrumbs, true ); ?> />
				<label for="hide-breadcrumbs"><?php _e( 'Hide Breadcrumbs', 'cuttz-framework' ); ?></label>
			</p>
		<?php
		}
	}

	?>
	<p>
		<input type="checkbox" value="true" id="hide-page-title" name="hide-page-title" <?php checked( $hide_page_title, true ); ?> />
		<label for="hide-page-title"><?php _e( 'Hide Page Title', 'cuttz-framework' ); ?></label>
		</p>
	<?php

	// building the conditional UI for hide Widgets Above Header
	do {
		// Bail if a WooCommerce page
		if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) && ( $post->ID == wc_get_page_id( 'shop' ) || $post->ID == wc_get_page_id( 'cart' ) || $post->ID == wc_get_page_id( 'checkout' ) || $post->ID == wc_get_page_id( 'myaccount' ) ) ) {
			break;
		}
		if ( $typenow == 'page' ) {
			if ( 'page' === get_option( 'show_on_front' ) ) {
				$front_page = get_option( 'page_on_front' );
				$blog_page  = get_option( 'page_for_posts' );
				if ( $front_page == $post->ID ) {
					if ( genesis_get_option( 'widgets_before_header_front', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
					?>
						<p>
							<input type="checkbox" id="hide-widgets-above-header" name="hide-widgets-above-header" <?php checked( $hide_widgets_above_header, true ); ?> value="true" />
							<label for="hide-widgets-above-header"><?php _e( 'Hide Widgets Above Header', 'cuttz-framework' ); ?></label>
						</p>
					<?php
					}
				} else {
					if ( $blog_page == $post->ID ) {
						if ( genesis_get_option( 'widgets_before_header_posts_page', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
						?>
							<p>
								<input type="checkbox" id="hide-widgets-above-header" name="hide-widgets-above-header" <?php checked( $hide_widgets_above_header, true ); ?> value="true" />
								<label for="hide-widgets-above-header"><?php _e( 'Hide Widgets Above Header', 'cuttz-framework' ); ?></label>
							</p>
						<?php
						}
					} else {
						if ( genesis_get_option( 'widgets_before_header_page', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
						?>
							<p>
								<input type="checkbox" id="hide-widgets-above-header" name="hide-widgets-above-header" <?php checked( $hide_widgets_above_header, true ); ?> value="true" />
								<label for="hide-widgets-above-header"><?php _e( 'Hide Widgets Above Header', 'cuttz-framework' ); ?></label>
							</p>
						<?php
						}
					}
				}
			} else {
				if ( genesis_get_option( 'widgets_before_header_page', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
				?>
					<p>
						<input type="checkbox" id="hide-widgets-above-header" name="hide-widgets-above-header" <?php checked( $hide_widgets_above_header, true ); ?> value="true" />
						<label for="hide-widgets-above-header"><?php _e( 'Hide Widgets Above Header', 'cuttz-framework' ); ?></label>
					</p>
				<?php
				}
			}
		} else {
			if ( genesis_get_option( 'widgets_before_header_post', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
			?>
				<p>
					<input type="checkbox" id="hide-widgets-above-header" name="hide-widgets-above-header" <?php checked( $hide_widgets_above_header, true ); ?> value="true" />
					<label for="hide-widgets-above-header"><?php _e( 'Hide Widgets Above Header', 'cuttz-framework' ); ?></label>
				</p>
			<?php
			}
		}
	} while(false);

	// building the conditional UI for hide Widgets Below Header
	do {
		// Bail if a WooCommerce page
		if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) && ( $post->ID == wc_get_page_id( 'shop' ) || $post->ID == wc_get_page_id( 'cart' ) || $post->ID == wc_get_page_id( 'checkout' ) || $post->ID == wc_get_page_id( 'myaccount' ) ) ) {
			break;
		}
		if ( $typenow == 'page' ) {
			if ( 'page' === get_option( 'show_on_front' ) ) {
				$front_page = get_option( 'page_on_front' );
				$blog_page  = get_option( 'page_for_posts' );
				if ( $front_page == $post->ID ) {
					if ( genesis_get_option( 'widgets_after_header_front', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
					?>
						<p>
							<input type="checkbox" id="hide-widgets-below-header" name="hide-widgets-below-header" <?php checked( $hide_widgets_below_header, true ); ?> value="true" />
							<label for="hide-widgets-below-header"><?php _e( 'Hide Widgets Below Header', 'cuttz-framework' ); ?></label>
						</p>
					<?php
					}
				} else {
					if ( $blog_page == $post->ID ) {
						if ( genesis_get_option( 'widgets_after_header_posts_page', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
						?>
							<p>
								<input type="checkbox" id="hide-widgets-below-header" name="hide-widgets-below-header" <?php checked( $hide_widgets_below_header, true ); ?> value="true" />
								<label for="hide-widgets-below-header"><?php _e( 'Hide Widgets Below Header', 'cuttz-framework' ); ?></label>
							</p>
						<?php
						}
					} else {
						if ( genesis_get_option( 'widgets_after_header_page', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
						?>
							<p>
								<input type="checkbox" id="hide-widgets-below-header" name="hide-widgets-below-header" <?php checked( $hide_widgets_below_header, true ); ?> value="true" />
								<label for="hide-widgets-below-header"><?php _e( 'Hide Widgets Below Header', 'cuttz-framework' ); ?></label>
							</p>
						<?php
						}
					}
				}
			} else {
				if ( genesis_get_option( 'widgets_after_header_page', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
				?>
					<p>
						<input type="checkbox" id="hide-widgets-below-header" name="hide-widgets-below-header" <?php checked( $hide_widgets_below_header, true ); ?> value="true" />
						<label for="hide-widgets-below-header"><?php _e( 'Hide Widgets Below Header', 'cuttz-framework' ); ?></label>
					</p>
				<?php
				}
			}
		} else {
			if ( genesis_get_option( 'widgets_after_header_post', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
			?>
				<p>
					<input type="checkbox" id="hide-widgets-below-header" name="hide-widgets-below-header" <?php checked( $hide_widgets_below_header, true ); ?> value="true" />
					<label for="hide-widgets-below-header"><?php _e( 'Hide Widgets Below Header', 'cuttz-framework' ); ?></label>
				</p>
			<?php
			}
		}
	} while(false);

	// building the conditional UI for hide Widgets Above Footer
	do {
		// Bail if a WooCommerce page
		if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) && ( $post->ID == wc_get_page_id( 'shop' ) || $post->ID == wc_get_page_id( 'cart' ) || $post->ID == wc_get_page_id( 'checkout' ) || $post->ID == wc_get_page_id( 'myaccount' ) ) ) {
			break;
		}
		if ( $typenow == 'page' ) {
			if ( 'page' === get_option( 'show_on_front' ) ) {
				$front_page = get_option( 'page_on_front' );
				$blog_page  = get_option( 'page_for_posts' );
				if ( $front_page == $post->ID ) {
					if ( genesis_get_option( 'widgets_above_footer_front', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
					?>
						<p>
							<input type="checkbox" id="hide-widgets-above-footer" name="hide-widgets-above-footer" <?php checked( $hide_widgets_above_footer, true ); ?> value="true" />
							<label for="hide-widgets-above-footer"><?php _e( 'Hide Widgets Above Footer', 'cuttz-framework' ); ?></label>
						</p>
					<?php
					}
				} else {
					if ( $blog_page == $post->ID ) {
						if ( genesis_get_option( 'widgets_above_footer_posts_page', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
						?>
							<p>
								<input type="checkbox" id="hide-widgets-above-footer" name="hide-widgets-above-footer" <?php checked( $hide_widgets_above_footer, true ); ?> value="true" />
								<label for="hide-widgets-above-footer"><?php _e( 'Hide Widgets Above Footer', 'cuttz-framework' ); ?></label>
							</p>
						<?php
						}
					} else {
						if ( genesis_get_option( 'widgets_above_footer_page', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
						?>
							<p>
								<input type="checkbox" id="hide-widgets-above-footer" name="hide-widgets-above-footer" <?php checked( $hide_widgets_above_footer, true ); ?> value="true" />
								<label for="hide-widgets-above-footer"><?php _e( 'Hide Widgets Above Footer', 'cuttz-framework' ); ?></label>
							</p>
						<?php
						}
					}
				}
			} else {
				if ( genesis_get_option( 'widgets_above_footer_page', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
				?>
					<p>
						<input type="checkbox" id="hide-widgets-above-footer" name="hide-widgets-above-footer" <?php checked( $hide_widgets_above_footer, true ); ?> value="true" />
						<label for="hide-widgets-above-footer"><?php _e( 'Hide Widgets Above Footer', 'cuttz-framework' ); ?></label>
					</p>
				<?php
				}
			}
		} else {
			if ( genesis_get_option( 'widgets_above_footer_post', CHILD_SETTINGS_FIELD_EXTRAS, false ) ) {
			?>
				<p>
					<input type="checkbox" id="hide-widgets-above-footer" name="hide-widgets-above-footer" <?php checked( $hide_widgets_above_footer, true ); ?> value="true" />
					<label for="hide-widgets-above-footer"><?php _e( 'Hide Widgets Above Footer', 'cuttz-framework' ); ?></label>
				</p>
			<?php
			}
		}
	} while(false);

	// conditional UI for After Entry widget area
	if ( $typenow == 'post' ) {
		if ( current_theme_supports( 'genesis-after-entry-widget-area' ) ) {
		?>
			<p>
				<input type="checkbox" id="hide-after-entry-widget" name="hide-after-entry-widget" <?php checked( $hide_after_entry_widget, true ); ?> value="true" />
				<label for="hide-after-entry-widget"><?php _e( 'Hide After Entry Widgets', 'cuttz-framework' ); ?></label>
			</p>
		<?php
		}
	}

	// conditional UI for footer widgets
	$global_fwidgets = genesis_get_option( 'footer-widgets', CHILD_SETTINGS_FIELD_EXTRAS, false );

	if ( $global_fwidgets ) {
	?>
		<p>
			<input type="checkbox" id="hide-footer-widgets" name="hide-footer-widgets" <?php checked( $hide_footer_widgets, true ); ?> value="true" />
			<label for="hide-footer-widgets"><?php _e( 'Hide Footer Widgets', 'cuttz-framework' ); ?></label>
		</p>
	<?php
	}

	?>
	<p>
		<input type="checkbox" id="hide-footer" name="hide-footer" <?php checked( $hide_footer, true ); ?> value="true" />
		<label for="hide-footer"><?php _e( 'Hide Footer', 'cuttz-framework' ); ?></label>
	</p>
	<?php

}

/**
 * Saves the Cuttz landing page metabox settings
 * @param type $post_id 
 * @return none
 * @since 1.0
 */
add_action( 'save_post', 'cuttz_save_template_settings' );

function cuttz_save_template_settings( $post_id ) {
	
	// Check if our nonce is set.
	if ( !isset( $_POST['cuttz_template_meta_box'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( !wp_verify_nonce( $_POST['cuttz_template_meta_box'], 'cuttz_template_meta_box_save' ) ) {
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
	
	$cuttz_template_options                              = array();
	$cuttz_template_options['hide-header']               = isset( $_POST['hide-header'] ) ? true : false;
	$cuttz_template_options['hide-breadcrumbs']          = isset( $_POST['hide-breadcrumbs'] ) ? true : false;
	$cuttz_template_options['hide-page-title']           = isset( $_POST['hide-page-title'] ) ? true : false;
	$cuttz_template_options['hide-widgets-above-header'] = isset( $_POST['hide-widgets-above-header'] ) ? true : false;
	$cuttz_template_options['hide-widgets-below-header'] = isset( $_POST['hide-widgets-below-header'] ) ? true : false;
	$cuttz_template_options['hide-widgets-above-footer'] = isset( $_POST['hide-widgets-above-footer'] ) ? true : false;
	$cuttz_template_options['hide-after-entry-widget']   = isset( $_POST['hide-after-entry-widget'] ) ? true : false;
	$cuttz_template_options['hide-footer-widgets']       = isset( $_POST['hide-footer-widgets'] ) ? true : false;
	$cuttz_template_options['hide-footer']               = isset( $_POST['hide-footer'] ) ? true : false;
	
	update_post_meta( $post_id, '_cuttz_template_options', $cuttz_template_options );
	
}


add_action( 'wp_head', 'landing_page_settings', 10 );

/**
 * Modifies the front-end as per the landing page settings set in the post editor screen.
 * @return none
 * @since 1.0
 */
function landing_page_settings() {
	
	if ( !current_theme_supports( 'cuttz-landing-page-experience' ) )
		return;
	
	if ( cuttz_is_mobile() ) // Bail, if on mobile or if not single post type
		return;
	
	if ( !is_singular() && !cuttz_is_woo_shop() )
		return;
	
	if ( get_option( 'show_on_front' ) === 'page' && is_home() ) {
		$page_id = get_option( 'page_for_posts' );
	} else {
		if( cuttz_is_woo_shop() ) {
			$page_id = wc_get_page_id( 'shop' );
		} else {
			$page_id = get_the_ID();
		}
	}
	
	/* Execute all the other hide/show options in Landing Page Experience metabox */
	
	$cuttz_template_options = get_post_meta( $page_id, '_cuttz_template_options', 1 );

	$hide_header             = isset( $cuttz_template_options['hide-header'] ) ? $cuttz_template_options['hide-header'] : false;

	$hide_breadcrumbs = isset( $cuttz_template_options['hide-breadcrumbs'] ) ? $cuttz_template_options['hide-breadcrumbs'] : false;

	$hide_page_title = isset( $cuttz_template_options['hide-page-title'] ) ? $cuttz_template_options['hide-page-title'] : false;

	$hide_widgets_above_header = isset( $cuttz_template_options['hide-widgets-above-header'] ) ? $cuttz_template_options['hide-widgets-above-header'] : false;

	$hide_widgets_below_header = isset( $cuttz_template_options['hide-widgets-below-header'] ) ? $cuttz_template_options['hide-widgets-below-header'] : false;

	$hide_widgets_above_footer = isset( $cuttz_template_options['hide-widgets-above-footer'] ) ? $cuttz_template_options['hide-widgets-above-footer'] : false;

	$hide_after_entry_widget = isset( $cuttz_template_options['hide-after-entry-widget'] ) ? $cuttz_template_options['hide-after-entry-widget'] : false;

	$hide_footer_widgets = isset( $cuttz_template_options['hide-footer-widgets'] ) ? $cuttz_template_options['hide-footer-widgets'] : false;

	$hide_footer = isset( $cuttz_template_options['hide-footer'] ) ? $cuttz_template_options['hide-footer'] : false;
	
	if ( $hide_header ) {
		remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
		remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
		remove_action( 'genesis_header', 'genesis_do_header' );
	}

	if ( $hide_breadcrumbs ) {
		// Do not remove breadcrumbs as per SEO guidelines; hide it via CSS instead
		add_filter( 'body_class', 'cuttz_seo_hide_breadcrumbs' );
	}

	if ( $hide_page_title ) {
		if ( !is_home() ) {
			add_filter( 'post_class', 'cuttz_hide_title_class' );
		}
		if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) ) {
			if( is_woocommerce() || is_cart() || is_checkout() ) {
				add_filter( 'woocommerce_show_page_title', '__return_false' );
			}
		}
	}

	if ( $hide_widgets_above_header ) {
		remove_action( 'genesis_before_header', 'cuttz_sidebar_before_header' );
	}

	if ( $hide_widgets_below_header ) {
		remove_action( 'genesis_after_header', 'cuttz_sidebar_after_header' );
	}

	if ( $hide_widgets_above_footer ) {
		remove_action( 'genesis_before_footer', 'cuttz_sidebar_above_footer', 5 );
	}

	if ( $hide_after_entry_widget ) {
		remove_theme_support( 'genesis-after-entry-widget-area' );
	}

	if ( $hide_footer_widgets ) {
		remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
	}

	if ( $hide_footer ) {
		remove_action( 'genesis_footer', 'cuttz_do_nav_footer', 5 );
		remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
		remove_action( 'genesis_footer', 'genesis_footer_markup_close', 5 );
		remove_action( 'genesis_footer', 'genesis_do_footer' );
	}

}