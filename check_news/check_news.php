<?php
/*
 * Plugin Name: CheckNews
 * Plugin URI: https://flaven.fr
 * Description: Including a ClaimReview structured data element on your WordPress post
 * Version: 1.0
 * Author: Bruno Flaven
 * Text Domain: claimreview-textdomain
 * Domain Path: /languages
*/

/**
 * The main functions to add the meta box in the post edition's sidebar to declare the article "fact checked" and add a ClaimReview structured data element on your article.
 * for ClaimReview
 * @since 1.0
 * @return custom form Fact Check Details to add custom data to the post edition
 */

        /**
         * Include jquery-ui-datepicker in admin area
         */
        if(is_admin()) {   
            /**
             * Include  a CSS for the calendar
             */
            function claimreview_admin_styles() {
                wp_enqueue_style( 'jquery-ui-datepicker-style',  plugin_dir_url( __FILE__ ) . 'assets/jquery-ui-1.12.1/jquery-ui.css' );
                wp_enqueue_style( 'jquery-ui-datepicker-style' );  
            }
            
            add_action('admin_print_styles', 'claimreview_admin_styles');

            /**
             * Include JS file for for jquery-ui-datepicker
             */
            function claimreview_admin_scripts() {
              wp_enqueue_script( 'jquery-ui-datepicker' );
                }
            add_action('admin_enqueue_scripts', 'claimreview_admin_scripts');
                          
            }//isAdmin

/**
 * Add datepicker from jQuery
 */
add_action('admin_head','add_custom_scripts');
function add_custom_scripts() {
    global $custom_meta_fields, $post;
     
    $output = '<script type="text/javascript">';
    $output .= "\n";    
    $output .= '//insert the datepicker jquery';
    $output .= "\n";    
    $output .= 'jQuery(function() {';    
    $output .= '';
                 
    foreach ($custom_meta_fields as $field) { // loop through the fields looking for certain types
        if($field['type'] == 'date')
            $output .= 'jQuery(".datepicker").datepicker();';
    }
    $output .= '});';
    $output .= "\n";    
    $output .= '</script>';
         
    //Final output
    echo $output;
}

/**
 * Add translation with the directory /languages/
 */
add_action( 'plugins_loaded', 'claimreview_load_plugin_textdomain' );
function claimreview_load_plugin_textdomain() {
    load_plugin_textdomain( 'claimreview-textdomain', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}

/**
 * The main functions to add the meta box in the post edition's sidebar to declare the article "fact checked" and add a ClaimReview structured data element on your article.
 * @since 1.0
 * @return Add the sidebar box Fact Check to check status during the post edition and declare the article as ClaimReview
 */



/**
 * Adds a meta box to the post editing screen
 */
function claimreview_featured_meta() {
    
    // In the sidebar
    add_meta_box( 'claimreview_meta', __( 'Fact Check', 'claimreview-textdomain' ), 'claimreview_meta_callback', 'post', 'side', 'high' );


}
add_action( 'add_meta_boxes', 'claimreview_featured_meta' );
 
/**
 * Outputs the content of the meta box
 */
 
                function claimreview_meta_callback( $post ) {
                    wp_nonce_field( basename( __FILE__ ), 'claimreview_nonce' );
                    $claimreview_stored_meta = get_post_meta( $post->ID );


                    echo ('<p>');
                        echo ('<span>'. __( 'Yes, it is a Fact Check Post:', 'claimreview-textdomain' ).'</span>');
                        echo ('<div>');
                                    echo ('<label>');
                                    echo ('<input type="checkbox" name="claimreview_itemReviewed_status" value="1"');
                                    if (isset($claimreview_stored_meta['claimreview_itemReviewed_status'])) 
                                         checked ($claimreview_stored_meta['claimreview_itemReviewed_status'][0], '1');
                                    echo('/>');
                                    echo (''.__( 'Fact Checked Status', 'claimreview-textdomain' ).'');
                                    echo('</label>');
                                    echo ('<p class="howto">'. __('If you check this box, this post will be considered "Fact Check", do not to forget to fill in the fields for the ClaimReview JSON-LD Header in the Fact Check Details Box.', 'claimreview-textdomain').'</p>');
                         echo('</div>');

                                    


                    echo('</p>');

                }//EOF
 
/**
 * Saves the custom meta input
 */
function claimreview_meta_save( $post_id ) {
 
    // Checks save status - overcome autosave, etc.
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'claimreview_nonce' ] ) && wp_verify_nonce( $_POST[ 'claimreview_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
// Checks for input and saves - save checked as 1 (yes) and unchecked at 0 (no)
if( isset( $_POST[ 'claimreview_itemReviewed_status' ] ) ) {
    update_post_meta( $post_id, 'claimreview_itemReviewed_status', '1' );
} else {
    update_post_meta( $post_id, 'claimreview_itemReviewed_status', '0' );
}
 
}
add_action( 'save_post', 'claimreview_meta_save' );

/**
 * The main functions to add custom data to the post edition to feed with data the JSON-LD in the form for ClaimReview.
 * Used https://github.com/tammyhart/Reusable-Custom-WordPress-Meta-Boxes
 * @since 1.0
 * @return custom form Fact Check Details to add custom data to the post edition
 */

// Add the Meta Box
function add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // $id
         __('Fact Check Details', 'claimreview-textdomain'), // $title 
        'show_custom_meta_box', // $callback
        'post', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_custom_meta_box');




// Field Array
$prefix = 'claimreview_details';
$custom_meta_fields = array(
    array(
        'label' => __('itemReviewed Author Name'),
        'desc'  => __('itemReviewed e.g. ClaudioRelor FakeBook page'),
        'tip'   => __('It is recommended to set type BlogPosting for posts, and leave empty or set to General for page post type', 'claimreview-textdomain'),
        'id'    => $prefix.'_itemReviewed_author_name',
        'type'  => 'text'
    ),
        array(
        'label' => __('itemReviewed Author SameAs'),
        'desc'  => __('URL e.g. https://www.facebook.com/ClaudioRelor/photos/a.3435443453/2119662481697641/'),
        'tip'   => __('URL e.g. https://www.facebook.com/ClaudioRelor/photos/a.3435443453/2119662481697641/', 'claimreview-textdomain'),
        'id'    => $prefix.'_itemReviewed_author_sameAs',
        'type'  => 'textarea'
    ),
// Gave up using the datepicker due to problem with changing language and date picking if you goes to Spanish, French and switch back to English, it is messing around.
/*
    array(
    'label' => __('itemReviewed Date Published'),
    'desc'  => __('The publication date YYYY-MM-DD e.g. 2017-12-30'),
    'tip'   => __('The publication date YYYY-MM-DD e.g. 2017-12-30'),
    'id'    => $prefix.'_itemReviewed_datePublished',
    'type'  => 'date'
    ),
*/
    array(
        'label' => __('itemReviewed Date Published', 'claimreview-textdomain'),
        'desc'  => __('The publication date YYYY-MM-DD e.g. 2015-12-30', 'claimreview-textdomain'),
        'tip'   => __('The publication date YYYY-MM-DD e.g. 2015-12-30', 'claimreview-textdomain'),
        'id'    => $prefix.'_itemReviewed_datePublished',
        'type'  => 'text'
    ),


    array(
    'label' => __('itemReviewed claimReviewed', 'claimreview-textdomain'),
    'desc'  => __('Max 1 paragraph e.g. The most viral information ever or What You Don\'t Know About Conspiracy May Shock You', 'claimreview-textdomain'),
    'tip'  => __('Max 1 paragraph e.g. The most viral information ever or What You Don\'t Know About Conspiracy May Shock You', 'claimreview-textdomain'),
    'id'    => $prefix.'_itemReviewed_claimReviewed',
    'type'  => 'textarea'
    ),

    array(
        'label'=> __('reviewRating ratingValue', 'claimreview-textdomain'),
        'desc'  => __('Pick one figure between 1 to 5, that is the degree of Truth', 'claimreview-textdomain'),
        'tip'  => __('Pick one figure between 1 to 5, that is the degree of Truth', 'claimreview-textdomain'),
        'id'    => $prefix.'_reviewRating_ratingValue',
        'type'  => 'select',
        'options' => array (
            'one' => array (
                'label' => '1 = "False"',
                'value' => '1'
            ),
            'two' => array (
                'label' => '2 = "Mostly false"',
                'value' => '2'
            ),
            'three' => array (
                'label' => '3 = "Half true"',
                'value' => '3'
            ),
            'four' => array (
                'label' => '4 = "Mostly true"',
                'value' => '4'
            ),
            'five' => array (
                'label' => '5 = "True"',
                'value' => '5'
            )
        )
    ),

    array(
        'label' => __('reviewRating alternateName', 'claimreview-textdomain'),
        'desc'  => __('Short text e.g. Mostly True', 'claimreview-textdomain'),
        'tip'   => __('Short text e.g. Mostly True', 'claimreview-textdomain'),
        'id'    => $prefix.'_reviewRating_alternateName',
        'type'  => 'text'
    ),




);


// The Callback
function show_custom_meta_box() {
global $custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
     
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // case items will go here

// text
case 'text':
echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
<br /><span class="description">'.$field['desc'].'</span>';
break;

// textarea
case 'textarea':
    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
        <br /><span class="description">'.$field['desc'].'</span>';
break;

// checkbox
case 'checkbox':
    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
        <label for="'.$field['id'].'">'.$field['desc'].'</label>';
break;

// select
case 'select':
    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
    foreach ($field['options'] as $option) {
        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
    }
    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
break;


// date
case 'date':
    echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
            <br /><span class="description">'.$field['desc'].'</span>';
break;


                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}


// Save the Data
function save_custom_meta($post_id) {
    global $custom_meta_fields;
     
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
     
    // loop through fields and save the data
    foreach ($custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_custom_meta');



/**
 * The main function responsible in order to output schema JSON-LD structured data for ClaimReview
 * @since 1.0
 * @return schema json-ld for ClaimReview
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
add_action('wp_head', 'schema_wp_output');

function schema_wp_output() {
    
        global $post;

        // Set post ID
        if ( ! isset($post_id) ) $post_id = $post->ID;
        
        // Get post content
        $content_post = get_post($post_id);
        $post_meta_data = get_post_custom($post_id);

        // Debug
        // var_dump($post_meta_data);
        
        // General informations from the blog
        $site_title = get_bloginfo( 'name' );
        $site_url = network_site_url('/');
        $site_description = get_bloginfo( 'description' );
        $post_url = get_the_permalink();
        $post_datePublished = get_the_date('Y-m-d');        

        $output = "";
        $output .= '<!-- This site included CheckNews Plugin - https://schema.org/ClaimReview -->';
        $output .= "\n";
        $output .= '<!-- // ClaimReview Insert -->';
        $output .= '<script type="application/ld+json">';
        $output .= "\n";

        /* JSON-LD ClaimReview */
        $output .= '{';
        $output .= '"@context": "http://schema.org",';
        $output .= '"@type": "ClaimReview",';
        $output .= '"datePublished": "'.$post_datePublished.'",';
        $output .= '"url": "'.$post_url.'",';
        $output .= '"itemReviewed": {';
        $output .= '"@type": "CreativeWork",';
        $output .= '"author": {';
        $output .= '"@type": "Organization",';
        $output .= '"name": "'.trim($post_meta_data['claimreview_details_itemReviewed_author_name'][0]).'",';
        $output .= '"sameAs": "'.trim($post_meta_data['claimreview_details_itemReviewed_author_sameAs'][0]).'"';
        $output .= '},';
        $output .= '"datePublished": "'.trim($post_meta_data['claimreview_details_itemReviewed_datePublished'][0]).'"';
        $output .= '},';
        $output .= '"claimReviewed": "'.trim($post_meta_data['claimreview_details_itemReviewed_claimReviewed'][0]).'",';
        $output .= '"author": {';
        $output .= '"@type": "Organization",';
        $output .= '"name": "'.$site_title.', '.$site_description.'",';
        $output .= '"url": "'.$site_url.'"';
        $output .= '},';
        $output .= '"reviewRating": {';
        $output .= '"@type": "Rating",';
        $output .= '"ratingValue": "'.trim($post_meta_data['claimreview_details_reviewRating_ratingValue'][0]).'",';
        $output .= '"bestRating": "5",';
        $output .= '"worstRating": "1",';
        $output .= '"alternateName": "'.trim($post_meta_data['claimreview_details_reviewRating_alternateName'][0]).'"';
        $output .= '}';
        $output .= '}';
        /* JSON-LD ClaimReview */


        $output .= "\n";
        $output .= '</script>';
        $output .= '<!-- // ClaimReview Insert -->';
        $output .= "\n\n";

        // Print in header if it is a post and the claimreview_itemReviewed_status was set to 1
        if ( (is_single()) && (trim($post_meta_data['claimreview_itemReviewed_status'][0]))== 1) {
                //print the header
                echo $output;

        } else {
        // Just for debug
        
        /*     
        $output = "";
        $output .= '<!-- No ClaimReview -->';
        $output .= "\n";

        //print the header
        echo $output;
        */
        
        }//EOI

        


    
    
}// EOF






