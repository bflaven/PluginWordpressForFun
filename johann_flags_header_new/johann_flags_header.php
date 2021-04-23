<?php
/**
 * @package johann_flags_header_new
 * @version 6.5
 */
/*
Plugin Name: johann_flags_header
Plugin URI: http://flaven.fr/
Description: Show flags and language version
Author: Bruno Flaven
Version: 6.5
Author URI: http://flaven.fr/
*/    
// Test to check the plugin activation johann_flags_header 
define('_PLUGIN_MODIFY_HEADER_FOOTER_NAME_','johann_flags_header');


// Add page in settings main menu nav
add_action( 'admin_menu', 'add_johann_plugin_page' );

// Define what in the page
// add_action( 'admin_init', 'page_johann_init' );
add_action( 'admin_init', 'page_johann_init' );

// use for frontend
add_action('init', 'enqueue_scripts');

// Frontend Hooks
add_action('wp_body_open', 'frontendHeader');

function add_johann_plugin_page() {
       
       add_options_page( 
            __( 'JohannFlags Options', 'textdomain' ),
            __( 'Johann Flags', 'textdomain' ),
            'manage_options', 
            'settings-johann-flags-page',
            'johann_flags_options' 
        );
    

    }

/************************************************
FUNCTIONS
************************************************/
function page_johann_init(  ) {
    

    register_setting( 'johann_flags_options_plugin', 'johann_flags_settings' );


    add_settings_section(
        'johann_flags_options_plugin_section',
        __( 'Johann Flags Parameters', 'wordpress' ),
        'print_section_info',
        'johann_flags_options_plugin'
    );


    /* FLAG_1 */
    add_settings_field(
        'flag_one_slug',
        __( 'First Site URL', 'wordpress' ),
        'flag_one_slug_render',
        'johann_flags_options_plugin',
        'johann_flags_options_plugin_section'
    );

    add_settings_field(
        'flag_one_abbreviation',
        __( 'First Flag Abbreviation', 'wordpress' ),
        'flag_one_abbreviation_render',
        'johann_flags_options_plugin',
        'johann_flags_options_plugin_section'
    );

    /* FLAG_2 */

        add_settings_field(
        'flag_two_slug',
        __( 'Second Site URL', 'wordpress' ),
        'flag_two_slug_render',
        'johann_flags_options_plugin',
        'johann_flags_options_plugin_section'
    );

    add_settings_field(
        'flag_two_abbreviation',
        __( 'Second Flag Abbreviation', 'wordpress' ),
        'flag_two_abbreviation_render',
        'johann_flags_options_plugin',
        'johann_flags_options_plugin_section'
    );
    
}
/* FLAG_1 */
// flag_one_slug_render
function flag_one_slug_render () {
    $options = get_option( 'johann_flags_settings' );
    print('<input type="text" name="johann_flags_settings[flag_one_slug]" value="');

    // required
    $options['flag_one_slug'] = isset( $options['flag_one_slug'] ) ? $options['flag_one_slug'] : '';

    echo $options['flag_one_slug']; 
     
    print('">');
    
}

// flag_one_abbreviation_render
function flag_one_abbreviation_render () {
    $options = get_option( 'johann_flags_settings' );
    print('<input type="text" name="johann_flags_settings[flag_one_abbreviation]" value="');

    // required
    $options['flag_one_abbreviation'] = isset( $options['flag_one_abbreviation'] ) ? $options['flag_one_abbreviation'] : '';

    echo $options['flag_one_abbreviation']; 
     
    print('">');
    
}


/* FLAG_2 */
// flag_one_slug_render
function flag_two_slug_render () {
    $options = get_option( 'johann_flags_settings' );
    print('<input type="text" name="johann_flags_settings[flag_two_slug]" value="');

    // required
    $options['flag_two_slug'] = isset( $options['flag_two_slug'] ) ? $options['flag_two_slug'] : '';

    echo $options['flag_two_slug']; 
     
    print('">');
    
}


// flag_two_abbreviation_render
function flag_two_abbreviation_render () {
    $options = get_option( 'johann_flags_settings' );
    print('<input type="text" name="johann_flags_settings[flag_two_abbreviation]" value="');

    // required
    $options['flag_two_abbreviation'] = isset( $options['flag_two_abbreviation'] ) ? $options['flag_two_abbreviation'] : '';

    echo $options['flag_two_abbreviation']; 
     
    print('">');
    
}



// 
function print_settings_section_info(  ) {
    echo __( 'How to manage flags and languages version in the header. A function has been placed in the header.php of the theme. <br><b>Be sure to know the correct abbreviation for flag!</b>', 'wordpress' );
}

/*
flag_one_slug
flag_one_abbreviation
flag_two_slug
flag_two_abbreviation
 */


function print_section_info() {   
        print'<p>';
        print 'Enter your settings below:<br>';
        print '- 1 - flag_one_slug or flag_two_slug for slug ex http://www.johann-rousselot.com/fr or flag_two_slug http://www.johann-rousselot.com/en<br>';
        print '- 2 - flag_one_abbreviation or flag_two_abbreviation for flag abbreviation ex fr for France, gb for Great-Britain, gr for Greece...<br>Check <a href="https://github.com/lipis/flag-icon-css">https://github.com/lipis/flag-icon-css</a><br>';
        // print 'For info, this url is automatic based on get_option( \'siteurl\' );<br>';
        print'</p>';
    }

function johann_flags_options(  ) {
    
    print('<form action="options.php" method="post">'); 
        print('<h2>Johann Flags Header</h2>');
        print_settings_section_info();
        settings_fields( 'johann_flags_options_plugin' );
        do_settings_sections( 'johann_flags_options_plugin' );
        submit_button();
    print('</form>');

}

/************************************************
ASSETS
************************************************/
function enqueue_scripts() {

    wp_enqueue_style( 'johann-flags-style', plugins_url('/css/johann-flags-style-file.css', __FILE__) );
    wp_enqueue_style( 'johann-flag-icon', plugins_url('/assets/css/flag-icon.min.css', __FILE__) );


    }


/************************************************
OUTPUT
************************************************/
// https://www.smashingmagazine.com/2016/04/three-approaches-to-adding-configurable-fields-to-your-plugin/
    function frontendHeader() {
        $url = get_option( 'siteurl' );


        $output = "";
         
        $output .= '<!-- '.trim(_PLUGIN_MODIFY_HEADER_FOOTER_NAME_).' -->';
        $output .= "\n";


        $custom_settings = get_option( 'johann_flags_settings' );

        // required
        $custom_settings['flag_one_slug'] = isset( $custom_settings['flag_one_slug'] ) ? $custom_settings['flag_one_slug'] : '';
        $flag_one_slug = $custom_settings['flag_one_slug'];
        

        // required
        $custom_settings['flag_one_abbreviation'] = isset( $custom_settings['flag_one_abbreviation'] ) ? $custom_settings['flag_one_abbreviation'] : '';
        $flag_one_abbreviation = $custom_settings['flag_one_abbreviation'];

        // required
        $custom_settings['flag_two_slug'] = isset( $custom_settings['flag_two_slug'] ) ? $custom_settings['flag_two_slug'] : '';
        $flag_two_slug = $custom_settings['flag_two_slug'];

                // required
        $custom_settings['flag_two_abbreviation'] = isset( $custom_settings['flag_two_abbreviation'] ) ? $custom_settings['flag_two_abbreviation'] : '';
        $flag_two_abbreviation = $custom_settings['flag_two_abbreviation'];

        // DEBUG
        // var_dump($custom_settings);



        $output .= '<!--BEGIN #searchboxhead --><div id="searchboxhead">';
        $output .= '<!--BEGIN #search-form --><div class="search-form">';


        /* search form */

        $output .= '<form method="get" id="searchform" class="clearfix" action="'.esc_url( home_url( '/' ) ).'" role="search">';

        

        $output .= '<input type="text" class="field" name="s" value="'.get_search_query().'" id="s" placeholder="Search &hellip;" />';

        $output .= '<input type="submit" class="submit" name="submit" id="searchsubmit" value="Go" />';
        $output .= '</form>';



        $output .= '</div><!--END #search-form -->';
        $output .= '<!-- END #searchboxhead --></div>';
            




        $output .= "\n";
        $output .= '<!--BEGIN #flagshead --><div id="flagshead"><p class="flags-description"><a href="'.$flag_one_slug.'" rel="home" target="_blank"><span style="width:20px;height:15px;" class="flag-icon-spacing flag-icon flag-icon-'.$flag_one_abbreviation.'"></span></a>&nbsp;&nbsp;<a href="'.$flag_two_slug.'" rel="home" target="_blank"><span style="width:20px;height:15px;" class="flag-icon-spacing flag-icon flag-icon-'.$flag_two_abbreviation.'"></span></a></p><!-- END #flagshead --></div>';
        $output .= "";

        echo $output;
    }





?>
