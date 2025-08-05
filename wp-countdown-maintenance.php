<?php

/*
Plugin Name: WP Countdown Maintenance
Description: Lightweight maintenance mode plugin for WordPress with countdown and logo support.  
Version: 1.0
Requires at least: 6.8.2
Author: Dreidgon
Licence: GPL v2 or later
Licence URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Text Domain: wp-countdown-maintenance
Domain Path: /languages
*/



if ( ! defined('ABSPATH')){
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}


$options = get_option('smp_settings_options');

/*This adds the menu */
function add_menu() {
    add_menu_page(
        'Simple Maintenance Page Options', // Page title
        'SMP',                             // Menu label in sidebar
        'manage_options',                  // Only admins see this(Only these types of user can see this menu, this is roles)
        'simple_maintenance_page',         // Slug for the page(unique ID)
        'simple_maintenance_page_html',    // Call back function to display your page
        'dashicons-images-alt2',           // Icon in sidebar
        10                                 // Position (top of menu)
    );
}
add_action('admin_menu', 'add_menu');

function simple_maintenance_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Maintenance Mode Settings</h1>
        <form action="options.php" method="post">
            <?php
                settings_fields('smp_settings_group');
                do_settings_sections('smp_settings');
                submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}




/*This creates the sections of the admin menu */

function simple_maintenance_page_settings(){
    // Register setting

    //Register separate
    /*
    register_setting('smp_settings_group', 'smp_enabled');
    register_setting('smp_settings_group', 'smp_maintenante_text');
    */
    //register array format
    register_setting('smp_settings_group', 'smp_settings','smp_settings_sanitize');

    add_settings_section(
        'smp_section_main',   // Section ID
        'Main Settings',      // Section Title
        null,                 // No description text needed(Callback (can be null))
        'smp_settings'        // Page slug (used above in do_settings_sections)
    );

    // Enable field
    add_settings_field(
        'smp_enabled',             // Field ID
        'Enable Maintenance Mode', // Label
        'smp_enabled_callback',    // Callback to render the field
        'smp_settings',            // Page
        'smp_section_main'         // Section
    );
    // Textarea field
    add_settings_field(
        'smp_maintenante_text',             // Field ID
        'Maintenance message', // Label
        'smp_maintenante_text_callback',    // Callback to render the field
        'smp_settings',            // Page
        'smp_section_main'         // Section
    );
    // Logo field
    add_settings_field(
        'smp_logo',
        'Logo Image URL',
        'smp_logo_callback',
        'smp_settings',
        'smp_section_main'
    );

    // Add the countdown input field
    add_settings_field(
        'smp_countdown', // Field ID
        'Countdown Target Date', // Label
        'smp_countdown_callback', // Callback function
        'smp_settings', // Page
        'smp_section_main' // Section
    );
}

add_action('admin_init','simple_maintenance_page_settings');

function smp_settings_sanitize($input){    
    $output = array();

    // Sanitize enabled (checkbox)
    $output['enabled'] = isset($input['enabled']) && $input['enabled'] ? 1 : 0;

    // Sanitize maintenance text — allow limited HTML or strip all tags
    $output['maintenance_text'] = wp_kses_post($input['maintenance_text']);

    // Sanitize logo URL
    $output['logo'] = esc_url_raw($input['logo']);

    // Sanitize countdown date/time — validate datetime-local format roughly
    if (isset($input['smp_countdown']) && preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $input['smp_countdown'])) {
        $output['smp_countdown'] = $input['smp_countdown'];
    } else {
        $output['smp_countdown'] = '';
    }

    return $output;;
}



function smp_countdown_callback() {
    $value = get_option('smp_settings');
    echo '<input type="datetime-local" name="smp_settings[smp_countdown]" value="' . esc_attr(isset($value['smp_countdown']) ? $value['smp_countdown'] : '') . '" />';

    /*$value = get_option('smp_settings');
    echo '<input type="datetime-local" name="smp_settings[smp_countdown]" value="' . esc_attr($value['smp_countdown']) . '" />';*/
}


function smp_enabled_callback() {
    $options = get_option('smp_settings');
    $enabled = isset($options['enabled']) ? $options['enabled'] : 0;
    echo '<input type="checkbox" name="smp_settings[enabled]" value="1" ' . checked(1, $enabled, false) . ' />';
    /*
    $value = get_option('smp_enabled');
    echo '<input type="checkbox" name="smp_enabled" value="1" ' . checked(1, $value, false) . ' />';*/
}

function smp_maintenante_text_callback(){
    $options = get_option('smp_settings');
    $text = isset($options['maintenance_text']) ? $options['maintenance_text'] : 'We’ll be back soon!';
    echo '<textarea name="smp_settings[maintenance_text]" rows="5" cols="50">' . esc_textarea($text) . '</textarea>';
    /*$value = get_option('smp_maintenante_text', 'We’ll be back soon!');
    echo '<textarea name="smp_maintenante_text" rows="5" cols="50">' . esc_textarea($value) . '</textarea>';*/
}

function smp_logo_callback() {
    $options = get_option('smp_settings');
    $logo_url = isset($options['logo']) ? esc_url($options['logo']) : '';
    ?>
    <input type="text" name="smp_settings[logo]" id="smp_logo" value="<?php echo $logo_url; ?>" style="width: 70%;" />
    <input type="button" class="button" value="Upload Image" id="smp_logo_button" />
    <script>
    jQuery(document).ready(function($){
        $('#smp_logo_button').on('click', function(e) {
            e.preventDefault();
            var image = wp.media({ 
                title: 'Upload Maintenance Logo',
                multiple: false
            }).open().on('select', function(){
                var uploaded_image = image.state().get('selection').first().toJSON();
                $('#smp_logo').val(uploaded_image.url);
            });
        });
    });
    </script>
    <?php
}

/*Load the WordPress Media Uploader (only in admin), for uploading a image and using the wordpress media uploader*/

function smp_enqueue_media_uploader($hook) {
    if ($hook === 'toplevel_page_simple_maintenance_page') { // matches your menu slug
        /*
        wp_enqueue_media(); is a WordPress function that loads all the necessary JavaScript, CSS, 
        and dependencies to use the WordPress Media Uploader in the admin area.
        
        */
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'smp_enqueue_media_uploader');

//https://developer.wordpress.org/reference/hooks/template_redirect/
function smp_redirect_to_coming_soon(){
    $options = get_option('smp_settings');
    $enabled = isset($options['enabled']) ? $options['enabled'] : 0;
    //https://developer.wordpress.org/reference/functions/current_user_can/
    if (! current_user_can('manage_options') && $enabled == '1') {
        //If current user is not admin
        status_header(503);
        include plugin_dir_path(__FILE__) . 'templates/coming-soon-template.php';
        exit;
    }
}

add_action('template_redirect', 'smp_redirect_to_coming_soon');