<?php

/**
 * Class that generates the Cuttz Branding Settings UI. See Genesis_Admin_Basic for more information.
 *
 * @since 1.0
 *
 */
class Cuttz_Favicon_Settings extends Genesis_Admin_Basic {

	function __construct() {
		$page_id          = CHILD_SETTINGS_FIELD_BRANDING;
		$menu_ops         = array(
			'submenu' => array(
				'parent_slug' => __( 'genesis', 'cuttz-framework' ),
				'page_title' => __( 'Cuttz Branding', 'cuttz-framework' ),
				'menu_title' => __( 'Cuttz Branding', 'cuttz-framework' )
			)
		);
		$page_ops         = array(
			'screen_icon' => 'themes'
		);
		$settings_field   = CHILD_SETTINGS_FIELD_BRANDING;
		$default_settings = array(
			'icon' => CHILD_URL . '/images/favicon.svg',
			'logo' => CHILD_URL . '/images/logo.svg'
		);
		$this->create( $page_id, $menu_ops );
		add_action( 'admin_init', array(
				$this,
				'upload'
			) );
	}

	function help() {

	}

	/**
	 *
	 *
	 * @brief The Admin Page HTML for Branding
	 * @details [long description]
	 * @return [description]
	 */
	function admin() {
?>
	<div class="wrap">
		<?php
		screen_icon( 'tools' );
?>
		<h2><?php
		echo esc_html( get_admin_page_title() );
		?></h2>
		<form enctype="multipart/form-data" method="post" action="<?php
		echo menu_page_url( CHILD_SETTINGS_FIELD_BRANDING, 0 );
		?>"><?php
		wp_nonce_field( CHILD_SETTINGS_FIELD_BRANDING );
?>
		<table id="cuttz-branding-form" class="form-table" style="width:auto;">
			<tbody>
			<tr>
				<th scope="row">
					<p><strong><?php
		_e( 'Current Favicon:', 'cuttz-framework' );
		?></strong></p>
						<?php
		$settings = cuttz_favicon();
		if ( !$settings ) {
			$settings = CHILD_URL . '/images/favicon.png';
		} //!$settings
?>
				</th>
				<td>
					<p><?php
		echo cuttz_favicon();
		?></p>
					<p><img alt="Favicon" src="<?php
		echo $settings . '?t=' . microtime();
		?>" /></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<p><strong><?php
		_e( 'Current Logo:', 'cuttz-framework' );
		?></strong></p><p>

					</p>
				</th>
				<td><p><?php
		echo cuttz_logo( true );
		?></p>
					<p><img alt="Logo" src="<?php
		echo cuttz_logo( true ) . '?t=' . microtime();
		?>" /></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<p><strong><?php
		_e( 'Upload Favicon', 'cuttz-framework' );
		?></strong></p>
				</th>
				<td>
				<p>
				<input type="file" id="cuttz-icon" name="cuttz-icon" />
				<br /><small><em><?php
		_e( 'This will delete your previous favicon!', 'cuttz-framework' );
		?></em></small>
				</p>
				<p><strong><?php
		_e( 'Favicon Specifications &mdash;', 'cuttz-framework' );
		?> </strong></p>
				<?php
		_e( 'Must be 32px X 32px and must be of the type', 'cuttz-framework' );
		?> <?php
		echo implode( ', ', cuttz_favicon_types() );
		?>.
				</td>
			</tr>
			<tr>
			<th scope="row"><p><strong><?php
		_e( 'Upload Logo', 'cuttz-framework' );
		?></strong></p></th>
			<td>
				<p>
					<input type="file" id="cuttz-logo" name="cuttz-logo" />
					<br /><small><em><?php
		_e( 'This will delete your previous logo!', 'cuttz-framework' );
		?></em></small>
				</p>
				<?php
		$widths         = array();
		$settings       = get_option( cuttz_get_skin_page_id() );
		$padding        = (int) $settings['col-spacing'];
		$content_w_1col = (int) $settings['column-content-1col'];
		$content_w_2col = (int) $settings['column-content-2col'];
		$sb1_w_2col     = (int) $settings['sidebar-one-2col'];
		$content_w_3col = (int) $settings['column-content-3col'];
		$sb1_w_3col     = (int) $settings['sidebar-one-3col'];
		$sb2_w_3col     = (int) $settings['sidebar-two-3col'];
		$widths[]       = ( $content_w_3col + $sb1_w_3col + $sb2_w_3col + $padding * 4 );
		$widths[]       = ( $content_w_3col + $sb1_w_3col + $padding * 3 );
		$widths[]       = ( $content_w_3col + $padding * 2 );
		$widths[]       = ( $content_w_2col + $sb1_w_2col + $padding * 3 );
		$widths[]       = ( $content_w_2col + $padding * 2 );
		$widths[]       = ( $content_w_1col + $padding * 2 );
?>
				<p><strong><?php
		_e( 'Logo Specifications &mdash;', 'cuttz-framework' );
		?></strong></p>
				<ol>
				<li><?php
		printf( __( 'The image should be at least %dpx wide (the largest column layout). ', 'cuttz-framework' ), 2 * max( $widths ) );
		?></li>
				<li><?php
		printf( __( 'The content inside the image should not exceed %dpx (the smallest column layout).', 'cuttz-framework' ), 2 * min( $widths ) );
		?></li>
				<li><?php
		printf( __( 'The trademark should be positioned at least %dpx away from the left edge of the image.', 'cuttz-framework' ), $padding * 2 );
		?></li>
				<li><?php
		_e( 'The trademark should be vertically centred in the image.', 'cuttz-framework' );
		?></li>
				<li><?php
		_e( 'To create your logo, please use the default-logo.psd that you received with the purchase.', 'cuttz-framework' );
		?></li>
				</ol>

				<p><strong><?php
		_e( 'To remove logo or favicon just remove or rename those files.', 'cuttz-framework' );
		?></strong></p>

				</td>
			</tr>
			<tr><td></td><td><?php
		submit_button( __( 'Upload', 'cuttz-framework' ), 'primary large', 'cuttz-branding-upload', false );
		?><br /><br /><span style="font-size:small"><span style="font-weight:bold;"><?php
		_e( 'Maximum File Size:', 'cuttz-framework' );
		?></span> <?php
		echo ini_get( 'post_max_size' );
		?></span><br />
					<span style="font-size:small"><span style="font-weight:bold;"><?php
		_e( 'File Types:', 'cuttz-framework' );
		?></span> <?php
		echo implode( cuttz_logo_types(), ', ' );
		?></span>
					</td></tr>
			<?php
		do_action( 'cuttz_favicon_form' );
?>
			</tbody>
		</table>
		</form>
	</div>
	<?php
	}

	function notices() {
	}


	/**
	 * @brief Handles logo and favicon uploads.
	 * @details [long description]
	 * @return [description]
	 */
	function upload() {
		if ( !isset( $_REQUEST['cuttz-branding-upload'] ) ) {
			return;
		}
		check_admin_referer( CHILD_SETTINGS_FIELD_BRANDING );
		$res         = '';
		$usr_img_dir = cuttz_get_res( 'dir' ) . 'img';
		cuttz_init_path( $usr_img_dir );
		$tmp_icon = $_FILES['cuttz-icon']['tmp_name'];
		if ( is_uploaded_file( $tmp_icon ) ) {
			$file_parts = pathinfo( $_FILES['cuttz-icon']['name'] );
			$ext        = $file_parts['extension'];
			$dest       = $usr_img_dir . '/' . 'favicon.' . $ext;
			if ( in_array( $ext, cuttz_favicon_types() ) ) {
				cuttz_remove_favicons();
				$res = move_uploaded_file( $tmp_icon, $dest );
				if ( $res ) {
					$favurl = cuttz_get_res( 'dirurl' ) . 'img/favicon.' . $ext;
					wp_cache_flush();
					$res = __( 'Favicon updated. Old favicon purged.', 'cuttz-framework' );
				} else {
					$res = __( 'Couldn\'t move file.', 'cuttz-framework' );
					if ( !is_writable( $dest ) ) {
						$res .= __( ' Destination is not writable.', 'cuttz-framework' );
					}
				}
			} else {
				$res .= ' ' . __( 'File type not allowed', 'cuttz-framework' );
			}
		} else {
			//$res .= ' '.__('File could not be uploaded.','cuttz-framework');
		}
		$tmp_logo = $_FILES['cuttz-logo']['tmp_name'];
		if ( is_uploaded_file( $tmp_logo ) ) {
			$file_parts = pathinfo( $_FILES['cuttz-logo']['name'] );
			$ext        = $file_parts['extension'];
			$dest       = $usr_img_dir . '/' . 'logo.' . $ext;
			if ( in_array( $ext, cuttz_logo_types() ) ) {
				cuttz_remove_logos();
				$res = move_uploaded_file( $tmp_logo, $dest );
				if ( $res ) {
					$favurl = cuttz_get_res( 'dirurl' ) . 'img/logo.' . $ext;
					wp_cache_flush();
					$res = __( 'Logo updated. Old logo purged.', 'cuttz-framework' );
				} //$res
				else {
					$res = __( 'Couldn\'t move file.', 'cuttz-framework' );
					if ( !is_writable( $dest ) ) {
						$res .= ' ' . __( 'Destination is not writable.', 'cuttz-framework' );
					}
				}
			} else {
				$res .= ' ' . __( 'File type not allowed', 'cuttz-framework' );
			}
		} else {
			//$res .= ' '. __('File could not be uploaded.','cuttz-framework');
		}
		echo '<div id="message" class="updated"><p><strong>' . $res . '</strong></p></div>';
	}
}


/**
 * Returns the allowed file extensions for favicon.
 * @return array
 * @since 1.0
 */
function cuttz_logo_types() {
	return apply_filters( 'cuttz_logo_types', array(
			'svg',
			'png',
			'ico',
			'jpg',
			'gif'
		) );
}

/**
 * Returns the allowed file extensions for favicon.
 * @return array
 * @since 1.0
 */
function cuttz_favicon_types() {
	return apply_filters( 'cuttz_favicon_types', array(
			//'svg',
			'png',
			'ico',
			'jpg',
			'gif'
		) );
}

/**
 * Returns the url of the favicon which Genesis will use. If the favicon named file doesn't exist with a supported extension then returns false and allows Genesis to use parent's favicon.
 * @return url to the favicon else false
 * @since 1.0
 */
function cuttz_favicon( $url = '' ) {
	$icon_types = cuttz_favicon_types();
	$fav_dest   = cuttz_get_res( 'dir' ) . 'img/favicon.';

	foreach ( $icon_types as $ext ) {
		if ( file_exists( $fav_dest . $ext ) ) {
			return cuttz_get_res( 'dirurl' ) . 'img/favicon.' . $ext;
		}
	}
	//return false;
	if ( file_exists( CHILD_DIR . '/images/favicon.png' ) ) {
		return CHILD_URL . '/images/favicon.png';
	} else {
		return false;
	}
}

add_filter( 'genesis_pre_load_favicon', 'cuttz_favicon' );


/**
 * Deletes all old favicons files. Called when a new favicon is uploaded.
 * @return none
 * @since 1.0
 */
function cuttz_remove_favicons() {
	if ( !WP_Filesystem() ) {
		return;
	}
	global $wp_filesystem;
	$icon_types = cuttz_favicon_types();
	foreach ( $icon_types as $icon ) {
		if ( file_exists( cuttz_get_res( 'dir' ) . 'img/favicon.' . $icon ) ) {
			$wp_filesystem->delete( cuttz_get_res( 'dir' ) . 'img/favicon.' . $icon );
		}
	}
}

/**
 * Deletes all old logo files. Called when a new logo is uploaded.
 * @return none
 * @since 1.0
 */
function cuttz_remove_logos() {
	if ( !WP_Filesystem() ) {
		return;
	}
	global $wp_filesystem;
	$logo_types = cuttz_logo_types();
	foreach ( $logo_types as $logo ) {
		if ( file_exists( cuttz_get_res( 'dir' ) . 'img/logo.' . $logo ) ) {
			$wp_filesystem->delete( cuttz_get_res( 'dir' ) . 'img/logo.' . $logo );
		}
	}
}


/**
 * Creates the Cuttz Branding Admin Menu
 * @since 1.0
 */
function cuttz_favicon_settings_menu() {
	global $cuttz_favicon;
	$cuttz_favicon = new Cuttz_Favicon_Settings;
}