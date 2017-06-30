<?php
/**
 * For rainbow.art (urban art hunting app)
 *
 * @package Nope...
 * @author EFB (Essentials, Fundamentals, Basics)
 * @since 1.0
 */

/*
 Plugin Name:   Urban Art Hunting App
 Plugin URI: https://flaven.fr
 Description: Se situer, se positionner, se centrer dans la ville, entre le marché de l'art et la guérilla urbaine, les installations végétales et les jardins, le tricot urbain et le tissu urbain, entre l'ombre et la lumière, l’infiniment petit et le décidément grand... A taste of modernity.
 Version: 1.1
 Author: Etienne, Fred & Bruno aka EFB (Essentials, Fundamentals, Basics)
 Author URI: https://flaven.fr
 * Text Domain: urban_art_hunting_app
 * Domain Path: /languages
 */

 /* PLUGIN  ART WORK  */
/* ---------- */ 


/* TODO
1. define the post_type
artist (post_type_1)
artwork (post_type_2)
location (post_type_3)
style (post_type_4)
event (post_type_5)

2. select icon for post_type
artist (post_type_1) => dashicons-universal-access
artwork (post_type_2) => dashicons-palmtree
location (post_type_3) => dashicons-location
style (post_type_4) => dashicons-carrot
event (post_type_5) => dashicons-calendar

Check it there if you want to change...
https://developer.wordpress.org/resource/dashicons/#external

3.bis add the PARENT CHILD RELATIONSHIPS between 
3. define the transversal taxonomy
Let's say we call it => aaronhasnodoubt (Aron ha'Edout)
Attached it to all the post_type


4. Use plural for all post_type and activate for REST API

'show_in_rest' => true,

artists (post_type)
artworks (post_type)
locations (post_type)
styles (post_type)
events (post_type)


*/

/* NOT ENABLE
function my_plugin_load_plugin_textdomain() {
    load_plugin_textdomain( 'urban_art_hunting_app', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'my_plugin_load_plugin_textdomain' );
*/


/* ##### artist (post_type_1) ##### */
// Register Custom Post Type Projects - artist (post_type_1)

function custom_post_type_artist() {

  $labels = array(
  'name'  => 'Artists', 
  'singular_name' => 'Artist',
  'menu_name' => 'Artists',
  'name_admin_bar' => 'Artists'
  );

  $args = array(
    'label' => 'Artists',
    'description' => 'This is a artist content type. ',
    'labels' => $labels,
    'supports' => array('title','editor','thumbnail','taxonomies'),
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,      
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'page',
    'query_var' => 'artists',
    'rewrite' => array( 'slug' => 'artists'),
    'show_in_rest' => true,
    'menu_icon' => 'dashicons-universal-access', 
    
    );
  register_post_type( 'artists', $args );

}
add_action( 'init', 'custom_post_type_artist', 0 );

/* ##### artwork (post_type_2) ##### */
// Register Custom Post Type Projects - artwork (post_type_2)

function custom_post_type_artwork() {

  $labels = array(
  'name'  => 'Artworks', 
  'singular_name' => 'Artwork',
  'menu_name' => 'Artworks',
  'name_admin_bar' => 'Artworks'
  );

  $args = array(
    'label' => 'Artworks',
    'description' => 'This is a artwork content type. ',
    'labels' => $labels,
    'supports' => array('title','editor','thumbnail','taxonomies'),
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,      
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'page',
    'query_var' => 'artworks',
    'rewrite' => array( 'slug' => 'artworks'),
    'show_in_rest' => true,
    'menu_icon' => 'dashicons-palmtree', 
    
    );
  register_post_type( 'artworks', $args );

}
add_action( 'init', 'custom_post_type_artwork', 0 );


/* ##### location (post_type_3) ##### */
// Register Custom Post Type Projects - location (post_type_3)

function custom_post_type_location() {

  $labels = array(
  'name'  => 'Locations', 
  'singular_name' => 'Location',
  'menu_name' => 'Locations',
  'name_admin_bar' => 'Locations'
  );

  $args = array(
    'label' => 'Locations',
    'description' => 'This is a location content type. ',
    'labels' => $labels,
    'supports' => array('title','editor','thumbnail','taxonomies'),
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,      
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'page',
    'query_var' => 'locations',
    'rewrite' => array( 'slug' => 'locations'),
    'show_in_rest' => true,
    'menu_icon' => 'dashicons-location', 
    
    );
  register_post_type( 'locations', $args );

}
add_action( 'init', 'custom_post_type_location', 0 );




/* ##### style (post_type_4) ##### */
// Register Custom Post Type Style - style (post_type_3)

function custom_post_type_style() {

  $labels = array(
  'name'  => 'Styles',  
  'singular_name' => 'Styles',
  'menu_name' => 'Styles',
  'name_admin_bar' => 'Styles'
  );

  $args = array(
    'label' => 'Styles',
    'description' => 'This is a style content type. ',
    'labels' => $labels,
    'supports' => array('title','editor','thumbnail','taxonomies'),
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,      
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'page',
    'query_var' => 'styles',
    'rewrite' => array( 'slug' => 'styles'),
    'show_in_rest' => true,
    'menu_icon' => 'dashicons-carrot', 
    
    );
  register_post_type( 'styles', $args );

}
add_action( 'init', 'custom_post_type_style', 0 );

/* ##### event (post_type_5) ##### */
// Register Custom Post Type Style - event (post_type_5)

function custom_post_type_event() {

  $labels = array(
  'name'  => 'Events',
  'singular_name' => 'Events',
  'menu_name' => 'Events',
  'name_admin_bar' => 'Events'
  );

  $args = array(
    'label' => 'Events',
    'description' => 'This is a event content type. ',
    'labels' => $labels,
    'supports' => array('title','editor','thumbnail','taxonomies'),
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,      
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'page',
    'query_var' => 'events',
    'rewrite' => array( 'slug' => 'events'),
    'show_in_rest' => true,
    'menu_icon' => 'dashicons-admin-site', 
    
    );
  register_post_type( 'events', $args );

}
add_action( 'init', 'custom_post_type_event', 0);


/* ---------- */ 
/* ##### ADD PARENT CHILD RELATIONSHIPS ##### */
/* 
OK this is just a track.
Link between these 2 post_type.
Give to caesar what belongs to caesar
artists (post_type)
artworks (post_type)

 */
// FIRST PART
add_action('admin_menu', function() { 
   remove_meta_box('pageparentdiv', 'artworks', 'normal');
});

// SECOND PART
add_action('add_meta_boxes', function() { 
   add_meta_box('artwork-parent', 'Artists', 'artist_artwork_attributes_meta_box', 'artworks', 'side', 'high');
});
  
// THIRD PART
function artist_artwork_attributes_meta_box($post) { 
    $post_type_object = get_post_type_object($post->post_type);
  
  //var_dump($post_type_object);


    if ( $post_type_object->hierarchical ) {
          $pages = wp_dropdown_pages(array(
                'post_type' => 'artists', 
                'selected' => $post->post_parent, 
          'name' => 'parent_id', 
                'show_option_none' => __('(no parent)'), 
                'sort_column' => 'menu_order, post_title', 
          'echo'=> 0
    ));
      
          if ( ! empty($pages) ) {
            echo $pages;
            // var_dump($pages);
          } 
      }
}

/*
IF NEEDED

The parent permalink:
$parent_permalink = get_permalink($post->post_parent);

The child permalink (artist, artwork)
the_permalink();

*/

/* ----------- */
/* TAXONOMY */
// aaronhasnodoubt
// Aron ha'Edout
// UAH stand for Urban Art Hunting 
/* for explantations about custom taxonomies about 
http://justintadlock.com/archives/2010/06/10/a-refresher-on-custom-taxonomies 
*/

function urban_art_hunting_app_taxonomy() {
$labels = array(
        'name'              => __( 'UAH Categories' ),
        'singular_name'     => __( 'UAH Category' ),
        'search_items'      => __( 'Search UAH Categories' ),
        'all_items'         => __( 'All UAH Categories' ),
        'parent_item'       => __( 'Parent UAH Category' ),
        'parent_item_colon' => __( 'Parent UAH Category:' ),
        'edit_item'         => __( 'Edit UAH Category' ), 
        'update_item'       => __( 'Update UAH Category' ),
        'add_new_item'      => __( 'Add UAH Category' ),
        'new_item_name'     => __( 'New UAH Category' ),
        'menu_name'         => __( 'UAH Categories' ),
    ); 

       $args = array(
        'labels'            => $labels,
        'public'            =>  true,
        'show_in_rest'      => true,
        'has_archive'       =>  true,
        'hierarchical'      =>  true, 
        'query_var'         => 'uahc',
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_tagcloud'     => true,
        'show_in_nav_menus' =>  true,
        'rewrite'           =>  array('slug' => '/uahc', 'with_front' => true),
    );

      $post_types = array("artists", "artworks", "locations", "styles", "events");
  register_taxonomy( 'uahcategories', $post_types, $args );
}
add_action( 'init', 'urban_art_hunting_app_taxonomy');

/* // END TAXONOMY */

/* ----------- */
/* META_BOXES FOR POST_TYPE location */

/* 
NO MORE - use the Advanced Custom Fields plugin
See https://www.advancedcustomfields.com/
 */


/* Source if needed
https://return-true.com/adding-custom-post-type-and-custom-meta-box-in-wordpress/
*/
/*
add_action( 'add_meta_boxes', 'uah_add_custom_box' );
add_action( 'save_post', 'uah_save_postdata' );

function uah_add_custom_box() {
    add_meta_box( 
        'uah_options',
        'Geolocalisation for location',
        'uah_inner_custom_box',
        'locations' 
    );
}


function uah_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'uah_noncename' );

  $custom_data = get_post_meta($post->ID, 'uah_location', TRUE);

  echo ('<ul>');
  echo ('<li>');
  echo ('<label for="uah_location_latitude">');
  echo ('<b>Latitude:</b>&nbsp;');
  echo ('</label>');
  echo ('<input type="text" id="uah_location_latitude" name="uah_location_latitude" value="'.$custom_data['uah_location_latitude'].'" size="25" class="regular-text" />');
  echo ('</li>');
  echo ('<li>');
  echo ('<label for="uah_location_longitude">');
  echo ('<b>Longitude:</b>&nbsp;');
  echo ('</label>');
  echo ('<input type="text" id="uah_location_longitude" name="uah_location_longitude" value="'.$custom_data['uah_location_longitude'].'" size="25" class="regular-text" />');
  echo ('</li>');
      echo ('<p class="howto">For Bristol in England, <code>latitude: 51.454513</code> and <code>longitude: -2.58791</code><br>Use the google map API: http://maps.googleapis.com/maps/api/geocode/json?address=Bristol&sensor=false</p>');

  echo ('</ul>');
  }

function uah_save_postdata( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  if ( !wp_verify_nonce( $_POST['uah_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  $custom_data = array();
  foreach($_POST as $key => $data) {
    if($key == 'uah_noncename')
      continue;
    if(preg_match('/^uah/i', $key)) {
      $custom_data[$key] = $data;
    }
  }
  update_post_meta($post_id, 'uah_location', $custom_data);
  return $custom_data;
}
*/

/* // META_BOXES FOR POST_TYPE */


/* ----------- */
/* API */
// SOURCE
// http://v2.wp-api.org/extending/custom-content-types/
// https://developer.wordpress.org/rest-api/
// https://developer.wordpress.org/rest-api/extending-the-rest-api/
/*
DESTINATION 
http://localhost/wp/wordpress/wp-json/wp/v2/artists
http://localhost/wp/wordpress/wp-json/wp/v2/artworks
http://localhost/wp/wordpress/wp-json/wp/v2/locations
http://localhost/wp/wordpress/wp-json/wp/v2/styles
http://localhost/wp/wordpress/wp-json/wp/v2/events

*/

/* 
NO MORE - use the Advanced Custom Fields plugin
See https://www.advancedcustomfields.com/
Move to plugin wp_api_urban_art_hunting_app.php  */


/* // API */








 


