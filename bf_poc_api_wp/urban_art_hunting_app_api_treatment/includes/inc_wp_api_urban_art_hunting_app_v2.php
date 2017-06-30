<?php
/**
 * WP REST API Urban Art Hunting App
 *
 * @package WP_API_Urban_Art_Hunting_App
 */

/* caution */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'WP_REST_urban_art_hunting_app' ) ) :


    /**
     * WP REST Urban Art Hunting App class.
     *
     * WP API Urban Art Hunting App support for WP API v2.
     *
     * @package WP_API_Urban_Art_Hunting_App
     * @since 1.0
     */
    class WP_REST_urban_art_hunting_app {

        /**
         * Get WP API namespace.
         *
         * @since 1.0
         * @return string
         */
        public static function get_api_namespace() {
            return 'wp/v2';
        }


        /**
         * Get WP API Urban Art Hunting App namespace.
         *
         * @since 1.2.1
         * @return string
         */
        public static function get_plugin_namespace() {
            return 'wp-api-uaha/v1';

        }

        /* ROUTES */
	    
        /**
         * Register Urban Art Hunting App routes for WP API v2.
         *
         * @since  1.2.0
         */
        // register_routes
        public function wp_api_uaha_register_routes() {

        $base = 'artists';


            register_rest_route( self::get_plugin_namespace(), '/'.$base, array(
                array(
                    'methods'  => WP_REST_Server::READABLE,
                    'callback' => array( $this, 'get_items' ),
                )
            ) );

            
        }//EOF
        /* // ROUTES */


        /* --- FUNCTIONS --- */

        /**
     * Get all the items from a post_type eg artists
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Request
     */
    public static function get_items( $request ) {
        $data = get_posts (array(
            'post_type'      => 'artists',
            'post_status'    => 'publish',
            'posts_per_page' => 20,
        ) );

        // @TODO do your magic here
        return new WP_REST_Response( $data, 200 );
    }


/*  Too lazy to keep the work done 
if you want to continue check http://v2.wp-api.org/extending/adding/
*/
/* 
NO MORE - use the Rest Routes plugin
See https://fr.wordpress.org/plugins/rest-routes/

*/


   


 } //EOC 

/* caution */
endif;
