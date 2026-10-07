<?php
/**
 * ACF Settings for ENIGMA 14 Site Identity & Contact
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add the ACF Options Page for Site Settings
add_action('acf/init', 'enigma14_acf_options_page');
function enigma14_acf_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title'    => 'Setari ENIGMA 14',
            'menu_title'    => 'Setari Site',
            'menu_slug'     => 'enigma14-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'icon_url'      => 'dashicons-admin-generic',
            'position'      => 30
        ));
    }
}
