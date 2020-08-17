<?php
/**
 * @package johann_flags_header
 * @version 6.0
 */
/*
Plugin Name: johann_flags_header
Plugin URI: http://flaven.fr/
Description: Show flags and language version
Author: Bruno Flaven
Version: 6.0
Author URI: http://flaven.fr/
*/

namespace johannFlagsHeader;

// If this file is accessed directory, then abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

Class johannFlagsHeader {

// Test to check the plugin activation johann_flags_header 
const PLUGIN_MODIFY_HEADER_FOOTER_NAME='johann_flags_header';


    
    public function __construct() {            
                    $this->init();
                }//EOF

     private function init() {

                // Frontend Hooks
                // add_action( 'wp_head', array( &$this, 'frontendHeader' ) );
                // add_filter('body_class', array( &$this, 'frontendHeader' ) );
                add_action('wp_body_open', array( &$this, 'frontendHeader' ) );
                add_action('init', array(&$this, 'enqueue_scripts'));
                add_action( 'admin_menu', array(&$this, 'add_johann_plugin_page' ) );
                add_action( 'admin_init', array(&$this, 'page_johann_init' ) );
            }


    public static function enqueue_scripts() {

    wp_enqueue_style( 'johann-flags-style', plugins_url('/css/johann-flags-style-file.css', __FILE__) );
    wp_enqueue_style( 'johann-flag-icon', plugins_url('/assets/css/flag-icon.min.css', __FILE__) );


    }
/************************************************
SETTING
************************************************/

    public static function add_johann_plugin_page() {
        add_options_page(__('JohannFlags Options', 'johannflags'), 
        'Johann Flags', 
        'administrator', 
        'johann_flags_options', 
        array($this, 'JohannFlagsOptions')
        );
    }

    public static function JohannFlagsOptions() {
        // Set class property
        $this->options = get_option( 'johann_option_name' );
        ?>
        <div class="wrap">
            <h1>Johann Flags Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'johann_option_group' );
                do_settings_sections( 'johann-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }


    /**
     * Register and add settings
     */
    public function page_johann_init()
    {        
        register_setting(
            'johann_option_group', // Option group
            'johann_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'johann_setting_section', // ID
            'Flags Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'johann-setting-admin' // Page
        );  

        add_settings_field(
            'flag_one_slug', // ID
            'Flag Slug One', // Title 
            array( $this, 'flag_one_slug_callback' ), // Callback
            'johann-setting-admin', // Page
            'johann_setting_section' // Section           
        );      

        add_settings_field(
            'flag_one_abbreviation', 
            'Flag Abbreviation One', 
            array( $this, 'flag_one_abbreviation_callback' ), 
            'johann-setting-admin', 
            'johann_setting_section'
        );      

        add_settings_field(
            'flag_two_slug', // ID
            'Flag Slug Two', // Title 
            array( $this, 'flag_two_slug_callback' ), // Callback
            'johann-setting-admin', // Page
            'johann_setting_section' // Section           
        );      

        add_settings_field(
            'flag_two_abbreviation', 
            'Flag Abbreviation Two', 
            array( $this, 'flag_two_abbreviation_callback' ), 
            'johann-setting-admin', 
            'johann_setting_section'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        
        if( isset( $input['flag_one_slug'] ) )
            $new_input['flag_one_slug'] = sanitize_text_field( $input['flag_one_slug'] );

        if( isset( $input['flag_one_abbreviation'] ) )
            $new_input['flag_one_abbreviation'] = sanitize_text_field( $input['flag_one_abbreviation'] );

        if( isset( $input['flag_two_slug'] ) )
            $new_input['flag_two_slug'] = sanitize_text_field( $input['flag_two_slug'] );

        if( isset( $input['flag_two_abbreviation'] ) )
            $new_input['flag_two_abbreviation'] = sanitize_text_field( $input['flag_two_abbreviation'] );


        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {   
        print'<p>';
        print 'Enter your settings below:<br>';
        print '- 1 - flag_slug for slug ex http://www.johann-rousselot.com/fr ou http://www.johann-rousselot.com/en<br>';
        print '- 2 - flag_abbreviation for flag abbreviation ex fr for France, gb for Great-Britain, gr for Greece. Check https://github.com/lipis/flag-icon-css<br>';
        print 'For info, this url is automatic based on get_option( \'siteurl\' );<br>';
        print'</p>';



    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function flag_one_slug_callback()
    {
        printf(
            '<input type="text" id="flag_one_slug" name="johann_option_name[flag_one_slug]" value="%s" />',
            isset( $this->options['flag_one_slug'] ) ? esc_attr( $this->options['flag_one_slug']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function flag_one_abbreviation_callback()
    {
        
        $flags_abbreviations = array("ad", "ae", "af", "ag", "ai", "al", "am", "ao", "aq", "ar", "as", "at", "au", "aw", "ax", "az", "ba", "bb", "bd", "be", "bf", "bg", "bh", "bi", "bj", "bl", "bm", "bn", "bo", "bq", "br", "bs", "bt", "bv", "bw", "by", "bz", "ca", "cc", "cd", "cf", "cg", "ch", "ci", "ck", "cl", "cm", "cn", "co", "cr", "cu", "cv", "cw", "cx", "cy", "cz", "de", "dj", "dk", "dm", "do", "dz", "ec", "ee", "eg", "eh", "er", "es-ca", "es", "et", "eu", "fi", "fj", "fk", "fm", "fo", "fr", "ga", "gb-eng", "gb-nir", "gb-sct", "gb-wls", "gb", "gd", "ge", "gf", "gg", "gh", "gi", "gl", "gm", "gn", "gp", "gq", "gr", "gs", "gt", "gu", "gw", "gy", "hk", "hm", "hn", "hr", "ht", "hu", "id", "ie", "il", "im", "in", "io", "iq", "ir", "is", "it", "je", "jm", "jo", "jp", "ke", "kg", "kh", "ki", "km", "kn", "kp", "kr", "kw", "ky", "kz", "la", "lb", "lc", "li", "lk", "lr", "ls", "lt", "lu", "lv", "ly", "ma", "mc", "md", "me", "mf", "mg", "mh", "mk", "ml", "mm", "mn", "mo", "mp", "mq", "mr", "ms", "mt", "mu", "mv", "mw", "mx", "my", "mz", "na", "nc", "ne", "nf", "ng", "ni", "nl", "no", "np", "nr", "nu", "nz", "om", "pa", "pe", "pf", "pg", "ph", "pk", "pl", "pm", "pn", "pr", "ps", "pt", "pw", "py", "qa", "re", "ro", "rs", "ru", "rw", "sa", "sb", "sc", "sd", "se", "sg", "sh", "si", "sj", "sk", "sl", "sm", "sn", "so", "sr", "ss", "st", "sv", "sx", "sy", "sz", "tc", "td", "tf", "tg", "th", "tj", "tk", "tl", "tm", "tn", "to", "tr", "tt", "tv", "tw", "tz", "ua", "ug", "um", "un", "us", "uy", "uz", "va", "vc", "ve", "vg", "vi", "vn", "vu", "wf", "ws", "xk", "ye", "yt", "za", "zm", "zw");
    
        echo ('<select id="flag_one_abbreviation" name="johann_option_name[flag_one_abbreviation]">');
        echo ('<option>------- Select a flag</option>');
            foreach($flags_abbreviations as $item) {
                $selected = (esc_attr( $this->options['flag_one_abbreviation'])==$item) ? 'selected="selected"' : '';
                echo ('<option value="'.$item.'" '.$selected.'>'.$item.'</option>');;
            }
        echo "</select>";

    }



/** 
     * Get the settings option array and print one of its values
     */
    public function flag_two_slug_callback()
    {
        printf(
            '<input type="text" id="flag_two_slug" name="johann_option_name[flag_two_slug]" value="%s" />',
            isset( $this->options['flag_two_slug'] ) ? esc_attr( $this->options['flag_two_slug']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function flag_two_abbreviation_callback()
    {

    $flags_abbreviations = array("ad", "ae", "af", "ag", "ai", "al", "am", "ao", "aq", "ar", "as", "at", "au", "aw", "ax", "az", "ba", "bb", "bd", "be", "bf", "bg", "bh", "bi", "bj", "bl", "bm", "bn", "bo", "bq", "br", "bs", "bt", "bv", "bw", "by", "bz", "ca", "cc", "cd", "cf", "cg", "ch", "ci", "ck", "cl", "cm", "cn", "co", "cr", "cu", "cv", "cw", "cx", "cy", "cz", "de", "dj", "dk", "dm", "do", "dz", "ec", "ee", "eg", "eh", "er", "es-ca", "es", "et", "eu", "fi", "fj", "fk", "fm", "fo", "fr", "ga", "gb-eng", "gb-nir", "gb-sct", "gb-wls", "gb", "gd", "ge", "gf", "gg", "gh", "gi", "gl", "gm", "gn", "gp", "gq", "gr", "gs", "gt", "gu", "gw", "gy", "hk", "hm", "hn", "hr", "ht", "hu", "id", "ie", "il", "im", "in", "io", "iq", "ir", "is", "it", "je", "jm", "jo", "jp", "ke", "kg", "kh", "ki", "km", "kn", "kp", "kr", "kw", "ky", "kz", "la", "lb", "lc", "li", "lk", "lr", "ls", "lt", "lu", "lv", "ly", "ma", "mc", "md", "me", "mf", "mg", "mh", "mk", "ml", "mm", "mn", "mo", "mp", "mq", "mr", "ms", "mt", "mu", "mv", "mw", "mx", "my", "mz", "na", "nc", "ne", "nf", "ng", "ni", "nl", "no", "np", "nr", "nu", "nz", "om", "pa", "pe", "pf", "pg", "ph", "pk", "pl", "pm", "pn", "pr", "ps", "pt", "pw", "py", "qa", "re", "ro", "rs", "ru", "rw", "sa", "sb", "sc", "sd", "se", "sg", "sh", "si", "sj", "sk", "sl", "sm", "sn", "so", "sr", "ss", "st", "sv", "sx", "sy", "sz", "tc", "td", "tf", "tg", "th", "tj", "tk", "tl", "tm", "tn", "to", "tr", "tt", "tv", "tw", "tz", "ua", "ug", "um", "un", "us", "uy", "uz", "va", "vc", "ve", "vg", "vi", "vn", "vu", "wf", "ws", "xk", "ye", "yt", "za", "zm", "zw");
        
        echo ('<select id="flag_two_abbreviation" name="johann_option_name[flag_two_abbreviation]">');
        echo ('<option>------- Select a flag</option>');
            foreach($flags_abbreviations as $item) {
                $selected = (esc_attr( $this->options['flag_two_abbreviation'])==$item) ? 'selected="selected"' : '';
                echo ('<option value="'.$item.'" '.$selected.'>'.$item.'</option>');;
            }
        echo "</select>";
    }


/************************************************
OUTPUT
************************************************/

public function frontendHeader() {
        $url = get_option( 'siteurl' );


        $output = "";
         
        $output .= '<!-- '.trim(self::PLUGIN_MODIFY_HEADER_FOOTER_NAME).' -->';
        $output .= "\n";

        $custom_settings = get_option( 'johann_option_name' );
        
        $flag_one_slug = $custom_settings['flag_one_slug'];
        $flag_one_abbreviation = $custom_settings['flag_one_abbreviation'];

        $flag_two_slug = $custom_settings['flag_two_slug'];
        $flag_two_abbreviation = $custom_settings['flag_two_abbreviation'];

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



}//EOC
    
    /* Instantiate the Class in a variable */
    $insertFlags = new johannFlagsHeader();
/*


 */                   

?>
