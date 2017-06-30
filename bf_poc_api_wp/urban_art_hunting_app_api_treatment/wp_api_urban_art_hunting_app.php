<?php
/**
 * Plugin Name: WP REST API Urban Art Hunting App
 * Plugin URI:  https://flaven.fr
 * Description: Extends WP API with WordPress for urban_art_hunting_app plugin.
 *
 * Version:     1.0
 *
 * Bruno aka B (Basics)
 * Author URI:  https://flaven.fr
 *
 * Text Domain: wp_api_urban_art_hunting_app
 * Domain Path: /languages
 *
 * @package wp_api_urban_art_hunting_app
 */

/**
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// WP API v2 see wp_api_urban_art_hunting_app.php for the routes
include_once 'includes/inc_wp_api_urban_art_hunting_app_v2.php';

if ( ! function_exists ( 'wp_api_urban_art_hunting_app_init' ) ) :

	/**
	 * Init JSON REST API routes for the POC project
	 *
	 * @since 1.0.0
	 */
	/* V1 */

	function wp_api_urban_art_hunting_app_init() {
			
			 $class = new WP_REST_urban_art_hunting_app();
			 add_filter( 'rest_api_init', array( $class, 'wp_api_uaha_register_routes' ) );

	}

	add_action( 'init', 'wp_api_urban_art_hunting_app_init' );

endif;
