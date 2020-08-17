<?php
/**
 * @package header_social_icons
 * @version 4.0
 */
/*
Plugin Name: header_social_icons
Plugin URI: http://flaven.fr/
Description: Show links and social icons in header
Author: Bruno Flaven
Version: 4.0
Author URI: http://flaven.fr/
*/

namespace headerSocialIcons;

// If this file is accessed directory, then abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

Class headerSocialIcons {

// Test to check the plugin activation header_social_icons
const PLUGIN_HEADER_SOCIAL_ICONS='header_social_icons';

    public function __construct() {            
                    $this->init();
                }//EOF


    // require in body, the function wp_body_open();
    // wp_head, wp_body_open, body_begin, wp_footer
    private function init() {
                add_action('wp_body_open', array( &$this, 'SocialIconsFrontendHeader' ) );
                add_action('init', array(&$this, 'enqueue_scripts'));

                add_action( 'admin_menu', array(&$this, 'add_plugin_page' ) );
                add_action( 'admin_init', array(&$this, 'page_init' ) );
            }


    public static function enqueue_scripts() {
    wp_enqueue_style( 'header-social-icons-style', plugins_url('/css/header-social-icons-style-file.css', __FILE__) );
    wp_enqueue_style( 'header-social-icons', plugins_url('/assets/stylesheets/csmb.css', __FILE__) );
    }



/************************************************
SETTING
************************************************/

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Social Icons', // Title
            'manage_options', 
            'header-social-icons', // slug in admin
            array( $this, 'header_social_icons_create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function header_social_icons_create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'header_social_icons_my_option_name' );
        ?>
        <div class="wrap">
            <h1>Header Social Icons Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'header_social_icons_my_option_group' );
                do_settings_sections( 'header_social_icons_my_setting_admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'header_social_icons_my_option_group', // Option group
            'header_social_icons_my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        

            for ($x = 1; $x <= 4; $x++) {
                    
                    add_settings_section(
                    'setting_section_social_icons_'.$x.'', 
                    'Social Icon '.$x.'', // Title
                    array( $this, 'print_section_info' ), // Callback
                    'header_social_icons_my_setting_admin' // Page
                );  

                add_settings_field(
                    'social_icon_url_'.$x.'', // ID
                    'social_icon_url_'.$x.'', // Title 
                    array( $this, 'social_icon_url_'.$x.'_callback' ), // Callback
                    'header_social_icons_my_setting_admin', // Page
                    'setting_section_social_icons_'.$x.'' // Section           
                );      

                add_settings_field(
                    'social_icon_class_'.$x.'', 
                    'social_icon_class_'.$x.'', 
                    array( $this, 'social_icon_class_'.$x.'_callback' ), 
                    'header_social_icons_my_setting_admin', // Page
                    'setting_section_social_icons_'.$x.''
                ); 
            
            }//EOL


           
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        for ($x = 1; $x <= 4; $x++) {
            if( isset( $input['social_icon_url_'.$x.''] ) )
                $new_input['social_icon_url_'.$x.''] = sanitize_text_field( $input['social_icon_url_'.$x.''] );

            if( isset( $input['social_icon_class_'.$x.''] ) )
                $new_input['social_icon_class_'.$x.''] = sanitize_text_field( $input['social_icon_class_'.$x.''] );

        }//EOL
        

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below for each header\'s icon.';
    }

    
    /** 
     * Get the settings option array and print one of its values
     */
    
/*  ### Icon 1 ### */
public function social_icon_url_1_callback()
    {
        printf(
            '<input type="text" id="title" name="header_social_icons_my_option_name[social_icon_url_1]" value="%s" />',
            isset( $this->options['social_icon_url_1'] ) ? esc_attr( $this->options['social_icon_url_1']) : ''
        );

    }

public function social_icon_class_1_callback()
    {
        
/*
        printf(
            '<input type="text" id="title" name="header_social_icons_my_option_name[social_icon_class_1]" value="%s" />',
            isset( $this->options['social_icon_class_1'] ) ? esc_attr( $this->options['social_icon_class_1']) : ''
        );
*/

$icon_css_abbreviations = array('bitbucket', 'blogger', 'codepen', 'delicious', 'deviantart', 'digg', 'dropbox', 'facebook', 'flickr', 'foursquare', 'github', 'gitlab', 'googleplus', 'grooveshark', 'icheckmovies', 'imdb', 'instagram', 'invision', 'issuu', 'jsfiddle', 'lastfm', 'linkedin', 'mail', 'medium', 'myspace', 'path', 'paypal', 'pinterest', 'reddit', 'rss', 'share', 'skype', 'slack', 'snapchat', 'soundcloud', 'spotify', 'stackoverflow', 'steam', 'stumbleupon', 'swarm', 'tumblr', 'twitter', 'vimeo', 'vine', 'whatsapp', 'wordpress', 'yelp', 'youtube');



        echo ('<select id="social_icon_class_1" name="header_social_icons_my_option_name[social_icon_class_1]">');
        echo ('<option>------- Select a network</option>');
            foreach($icon_css_abbreviations as $item) {
                $selected = (esc_attr( $this->options['social_icon_class_1'])==$item) ? 'selected="selected"' : '';
                echo ('<option value="'.$item.'" '.$selected.'>'.$item.'</option>');;
            }
        echo "</select>";

    }

/*  ### Icon 2 ### */
public function social_icon_url_2_callback()
    {

        printf(
            '<input type="text" id="title" name="header_social_icons_my_option_name[social_icon_url_2]" value="%s" />',
            isset( $this->options['social_icon_url_2'] ) ? esc_attr( $this->options['social_icon_url_2']) : ''
        );

    }

public function social_icon_class_2_callback()
    {
        /*
        printf(
            '<input type="text" id="title" name="header_social_icons_my_option_name[social_icon_class_2]" value="%s" />',
            isset( $this->options['social_icon_class_2'] ) ? esc_attr( $this->options['social_icon_class_2']) : ''
        );
        */
       
       $icon_css_abbreviations = array('bitbucket', 'blogger', 'codepen', 'delicious', 'deviantart', 'digg', 'dropbox', 'facebook', 'flickr', 'foursquare', 'github', 'gitlab', 'googleplus', 'grooveshark', 'icheckmovies', 'imdb', 'instagram', 'invision', 'issuu', 'jsfiddle', 'lastfm', 'linkedin', 'mail', 'medium', 'myspace', 'path', 'paypal', 'pinterest', 'reddit', 'rss', 'share', 'skype', 'slack', 'snapchat', 'soundcloud', 'spotify', 'stackoverflow', 'steam', 'stumbleupon', 'swarm', 'tumblr', 'twitter', 'vimeo', 'vine', 'whatsapp', 'wordpress', 'yelp', 'youtube');



        echo ('<select id="social_icon_class_2" name="header_social_icons_my_option_name[social_icon_class_2]">');
        echo ('<option>------- Select a network</option>');
            foreach($icon_css_abbreviations as $item) {
                $selected = (esc_attr( $this->options['social_icon_class_2'])==$item) ? 'selected="selected"' : '';
                echo ('<option value="'.$item.'" '.$selected.'>'.$item.'</option>');;
            }
        echo "</select>";

    }

/*  ### Icon 3 ### */
public function social_icon_url_3_callback()
    {
        printf(
            '<input type="text" id="title" name="header_social_icons_my_option_name[social_icon_url_3]" value="%s" />',
            isset( $this->options['social_icon_url_3'] ) ? esc_attr( $this->options['social_icon_url_3']) : ''
        );

    }

public function social_icon_class_3_callback()
    {
        /*
        printf(
            '<input type="text" id="title" name="header_social_icons_my_option_name[social_icon_class_3]" value="%s" />',
            isset( $this->options['social_icon_class_3'] ) ? esc_attr( $this->options['social_icon_class_3']) : ''
        );
        */
       $icon_css_abbreviations = array('bitbucket', 'blogger', 'codepen', 'delicious', 'deviantart', 'digg', 'dropbox', 'facebook', 'flickr', 'foursquare', 'github', 'gitlab', 'googleplus', 'grooveshark', 'icheckmovies', 'imdb', 'instagram', 'invision', 'issuu', 'jsfiddle', 'lastfm', 'linkedin', 'mail', 'medium', 'myspace', 'path', 'paypal', 'pinterest', 'reddit', 'rss', 'share', 'skype', 'slack', 'snapchat', 'soundcloud', 'spotify', 'stackoverflow', 'steam', 'stumbleupon', 'swarm', 'tumblr', 'twitter', 'vimeo', 'vine', 'whatsapp', 'wordpress', 'yelp', 'youtube');



        echo ('<select id="social_icon_class_3" name="header_social_icons_my_option_name[social_icon_class_3]">');
        echo ('<option>------- Select a network</option>');
            foreach($icon_css_abbreviations as $item) {
                $selected = (esc_attr( $this->options['social_icon_class_3'])==$item) ? 'selected="selected"' : '';
                echo ('<option value="'.$item.'" '.$selected.'>'.$item.'</option>');;
            }
        echo "</select>";

    }


    /*  ### Icon 4 ### */
public function social_icon_url_4_callback()
    {
        printf(
            '<input type="text" id="title" name="header_social_icons_my_option_name[social_icon_url_4]" value="%s" />',
            isset( $this->options['social_icon_url_4'] ) ? esc_attr( $this->options['social_icon_url_4']) : ''
        );

    }

public function social_icon_class_4_callback()
    {
        /*
        printf(
            '<input type="text" id="title" name="header_social_icons_my_option_name[social_icon_class_4]" value="%s" />',
            isset( $this->options['social_icon_class_4'] ) ? esc_attr( $this->options['social_icon_class_4']) : ''
        );
        */
       $icon_css_abbreviations = array('bitbucket', 'blogger', 'codepen', 'delicious', 'deviantart', 'digg', 'dropbox', 'facebook', 'flickr', 'foursquare', 'github', 'gitlab', 'googleplus', 'grooveshark', 'icheckmovies', 'imdb', 'instagram', 'invision', 'issuu', 'jsfiddle', 'lastfm', 'linkedin', 'mail', 'medium', 'myspace', 'path', 'paypal', 'pinterest', 'reddit', 'rss', 'share', 'skype', 'slack', 'snapchat', 'soundcloud', 'spotify', 'stackoverflow', 'steam', 'stumbleupon', 'swarm', 'tumblr', 'twitter', 'vimeo', 'vine', 'whatsapp', 'wordpress', 'yelp', 'youtube');



        echo ('<select id="social_icon_class_4" name="header_social_icons_my_option_name[social_icon_class_4]">');
        echo ('<option>------- Select a network</option>');
            foreach($icon_css_abbreviations as $item) {
                $selected = (esc_attr( $this->options['social_icon_class_4'])==$item) ? 'selected="selected"' : '';
                echo ('<option value="'.$item.'" '.$selected.'>'.$item.'</option>');;
            }
        echo "</select>";
       

    }
/************************************************
OUTPUT
************************************************/
// https://www.smashingmagazine.com/2016/04/three-approaches-to-adding-configurable-fields-to-your-plugin/
    public function SocialIconsFrontendHeader() {

        $output = "";    
        $output .= '<!-- '.trim(self::PLUGIN_HEADER_SOCIAL_ICONS).' -->';

        $output .= '<!--BEGIN #iconsboxhead --><div id="iconsboxhead">';
        $output .= '<p class="links-description">';


        $custom_settings = get_option( 'header_social_icons_my_option_name' );

        $social_icon_url_1 = $custom_settings['social_icon_url_1'];
        $social_icon_class_1 = $custom_settings['social_icon_class_1'];

        $social_icon_url_2 = $custom_settings['social_icon_url_2'];
        $social_icon_class_2 = $custom_settings['social_icon_class_2'];

        $social_icon_url_3 = $custom_settings['social_icon_url_3'];
        $social_icon_class_3 = $custom_settings['social_icon_class_3'];

        $social_icon_url_4 = $custom_settings['social_icon_url_4'];
        $social_icon_class_4 = $custom_settings['social_icon_class_4'];

        $output .= '<a href="'.trim($social_icon_url_1).'" class="csmb csmb-'.trim($social_icon_class_1).' csmb-rounded" target="_blank"></a>';

        $output .= '<a href="'.trim($social_icon_url_2).'" class="csmb csmb-'.trim($social_icon_class_2).' csmb-rounded" target="_blank"></a>';

        $output .= '<a href="'.trim($social_icon_url_3).'" class="csmb csmb-'.trim($social_icon_class_3).' csmb-rounded" target="_blank"></a>';

        $output .= '<a href="'.trim($social_icon_url_4).'" class="csmb csmb-'.trim($social_icon_class_4).' csmb-rounded" target="_blank"></a>';


        $output .= '</p>';
        $output .= '<!-- END #iconsboxhead --></div>';

        $output .= "\n";
        $output .= "";

        // Output the html
        echo $output;
    }//EOF

}//EOC

    /* Instantiate the Class in a variable */
    $insertHeaderSocialIcons = new headerSocialIcons();
                   

?>
