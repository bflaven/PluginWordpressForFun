<?php
/*
Plugin Name: Meta Refresh Page
Description: Allows users to set a meta refresh timer and URL.
Version: 1.0
Plugin URI: http://flaven.fr
Author: Bruno Flaven
Author URI: http://flaven.fr
*/


// Add a menu item under "Settings"
function add_meta_refresh_menu_item() {
    add_submenu_page(
        'options-general.php',
        'Meta Refresh Page',
        'Meta Refresh Page',
        'manage_options',
        'meta-refresh-page-settings',
        'meta_refresh_page_settings'
    );
}
add_action('admin_menu', 'add_meta_refresh_menu_item');

// Callback function for the settings page
function meta_refresh_page_settings() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Save settings when the form is submitted
    if (isset($_POST['meta_refresh_submit'])) {
        
        update_option('add_meta_refresh_timer_page_id', sanitize_text_field($_POST['add_meta_refresh_timer_page_id']));
       
        update_option('add_meta_refresh_timer', sanitize_text_field($_POST['add_meta_refresh_timer']));
        
        update_option('add_meta_refresh_url', esc_url_raw($_POST['add_meta_refresh_url']));

        echo '<div class="notice notice-success"><p>Settings saved.</p></div>';
    }

    // Retrieve current settings
     
    // Refresh Specific Page ID
    $add_meta_refresh_timer_page_id = get_option('add_meta_refresh_timer_page_id', '453');

    // Refresh Meta Timer
    $add_meta_refresh_timer = get_option('add_meta_refresh_timer', '5');

    // Refresh Meta Url
    $add_meta_refresh_url = get_option('add_meta_refresh_url', 'https://app.justicity.fr/mediation/5320/amapa/');

    // Display the settings form
    ?>
    <div class="wrap">
        <h2>Meta Refresh Page Settings</h2>
        <form method="post" action="">
            <table class="form-table">
            	<tr valign="top">
                    <th scope="row">Page ID (e.g. 453):</th>
                    <td><input type="number" name="add_meta_refresh_timer_page_id" value="<?php echo $add_meta_refresh_timer_page_id; ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Refresh Timer (in seconds):</th>
                    <td><input type="number" name="add_meta_refresh_timer" value="<?php echo $add_meta_refresh_timer; ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Refresh URL:</th>
                    <td><input type="text" name="add_meta_refresh_url" value="<?php echo $add_meta_refresh_url; ?>" /></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="meta_refresh_submit" class="button-primary" value="Save Changes" />
            </p>
        </form>
    </div>
    <?php
}

// Function to add the meta refresh tag to the page header
function add_meta_refresh_page_wpse161271() {
	
	// Refresh Specific Page ID
	$add_meta_refresh_timer_page_id = get_option('add_meta_refresh_timer_page_id', '10');
    
    // Refresh Meta Timer
    $add_meta_refresh_timer = get_option('add_meta_refresh_timer', '10');

    // Refresh Meta Url
    $add_meta_refresh_url = get_option('add_meta_refresh_url', '');

    global $post;

    if (is_page() && $add_meta_refresh_url && $post->ID == $add_meta_refresh_timer_page_id) {
        echo "<!-- check plugin add-meta-refresh-page -->\n";
        echo '<meta http-equiv="refresh" content="' . esc_attr($add_meta_refresh_timer) . '; url=' . esc_url($add_meta_refresh_url) . '" />';
    }
}
add_action('wp_head', 'add_meta_refresh_page_wpse161271');



?>