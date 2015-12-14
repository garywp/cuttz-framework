<?php

/*
 * cuttz-mobile-detection.php uses PHP Mobile Detect class which is used to detect
 * browser or device type
 */


if( !class_exists('Mobile_Detect') ) {
	require_once 'mobile-detect.php';
}

global $detect;
$detect = new Mobile_Detect();


/*
 * Returns true when on desktops or tablets
 */

function cuttz_is_notphone() {
	global $detect;
	if ( !$detect->isMobile() || $detect->isTablet() )
		return true;
}

/*
 * Returns true when on desktops or phones
 */

function cuttz_is_nottab() {
	global $detect;
	if ( !$detect->isTablet() )
		return true;
}

/*
 * Returns true when on desktops only
 */

function cuttz_is_notdevice() {
	global $detect;
	if ( !$detect->isMobile() && !$detect->isTablet() )
		return true;
}

/*
 * Returns true when on phones ONLY
 */

function cuttz_is_phone() {
	global $detect;
	if ( $detect->isMobile() && !$detect->isTablet() )
		return true;
}


/*
 * Returns true when on Tablets ONLY
 */

function cuttz_is_tablet() {
	global $detect;
	if ( $detect->isTablet() )
		return true;
}

/*
 * Returns true when on phones or tablets but NOT destkop
 */

function cuttz_is_device() {
	global $detect;
	if ( $detect->isMobile() || $detect->isTablet() )
		return true;
}

/*
 * Returns true when on iOS
 */

function cuttz_is_ios() {
	global $detect;
	if ( $detect->isiOS() )
		return true;
}

/*
 * Returns true when on iPhone
 */

function cuttz_is_iphone() {
	global $detect;
	if ( $detect->isiPhone() )
		return true;
}

/*
 * Returns true when on iPad
 */

function cuttz_is_ipad() {
	global $detect;
	if ( $detect->isiPad() )
		return true;
}

/*
 * Returns true when on Android OS
 */

function cuttz_is_android() {
	global $detect;
	if ( $detect->isAndroidOS() )
		return true;
}

/*
 * Returns true when on a Blackberry device
 */

function cuttz_is_blackberry() {
	global $detect;
	if ( $detect->isBlackBerry() )
		return true;
}

/*
 * Returns true when on Windows OS
 */

function cuttz_is_windows_mobile() {
	global $detect;
	if ( $detect->isWindowsMobileOS() )
		return true;
}

/*
 * Returns true when in a Chrome browser
 */

function cuttz_is_chrome_browser() {
	global $detect;
	if ( $detect->isChrome() )
		return true;
}

/*
 * Returns true when in a Opera browser
 */

function cuttz_is_opera_browser() {
	global $detect;
	if ( $detect->isOpera() )
		return true;
}

/*
 * Returns true when in a IE browser
 */

function cuttz_is_ie_browser() {
	global $detect;
	if ( $detect->isIE() )
		return true;
}

/*
 * Returns true when in a Firefox browser
 */

function cuttz_is_firefox_browser() {
	global $detect;
	if ( $detect->isFirefox() )
		return true;
}

/*
 * Returns true when in a Safari browser
 */

function cuttz_is_safari_browser() {
	global $detect;
	if ( $detect->isSafari() )
		return true;
}
