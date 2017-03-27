<?php
/**
 * Plugin Name: Simple Logged-in Cookie
 * Plugin URI: https://github.com/zao-web/zao-mock-api
 * Description: Simply sets a "wp_is_logged_in" cookie when a user is logged in. Useful for checking via Javascript, or for 3rd party script implemenation.
 * Version: 0.1.0
 * Author: Justin Sternberg
 * Author URI: http://zao.is
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Sets the "wp_is_logged_in" cookie when a user is logged in.
 *
 * @since  0.1.0
 *
 * @param string $logged_in_cookie The logged-in cookie.
 * @param int    $expire           The time the login grace period expires as a UNIX timestamp.
 *                                 Default is 12 hours past the cookie's expiration time.
 * @param int    $expiration       The time when the logged-in authentication cookie expires
 *                                 as a UNIX timestamp. Default is 14 days from now.
 * @param int    $user_id          User ID.
 * @param string $scheme           Authentication scheme. Default 'logged_in'.
 *
 * @return void
 */
function slic_set_cookie( $logged_in_cookie, $expire, $expiration, $user_id, $scheme = null ) {
	if ( 'logged_in' === $scheme ) {
		setcookie( 'wp_is_logged_in', 1, $expire, COOKIEPATH, COOKIE_DOMAIN );
		if ( COOKIEPATH != SITECOOKIEPATH ) {
			setcookie( 'wp_is_logged_in', 1, $expire, SITECOOKIEPATH, COOKIE_DOMAIN );
		}
	}
}
add_action( 'set_logged_in_cookie', 'slic_set_cookie', 10, 5 );

/**
 * Unsets the "wp_is_logged_in" cookie when a user logs out.
 *
 * @since  0.1.0
 *
 * @return void
 */
function slic_unset_cookie() {
	$year_ago = time() - YEAR_IN_SECONDS;
	setcookie( 'wp_is_logged_in', ' ', $year_ago, COOKIEPATH, COOKIE_DOMAIN );
	setcookie( 'wp_is_logged_in', ' ', $year_ago, SITECOOKIEPATH, COOKIE_DOMAIN );
}
add_action( 'clear_auth_cookie', 'slic_unset_cookie' );
