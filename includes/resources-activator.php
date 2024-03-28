<?php 
function rgv_create_menu_pages() {
    add_menu_page('WP Resources', 'WP Resources', 'manage_options', 'rgv-main-menu', 'rgv_main_menu_callback');
    add_submenu_page('rgv-main-menu', 'All Resources', 'All Resources', 'manage_options', 'rgv-all-resources', 'rgv_all_resources_callback');
    add_submenu_page('rgv-main-menu', 'Add New Resource', 'Add New', 'manage_options', 'rgv-add-new', 'rgv_add_new_callback');
    add_submenu_page('rgv-main-menu', 'Categories', 'Categories', 'manage_options', 'rgv-categories', 'rgv_categories_callback');
}
add_action('admin_menu', 'rgv_create_menu_pages');
// Callback function for main menu page
function rgv_main_menu_callback() {
    echo '<h1>WP Resources Dashboard</h1>';
    // Add your main menu page content here
}

// Callback function for All Resources page
function rgv_all_resources_callback() {
    echo '<h1>All Resources</h1>';
    // Add your All Resources page content here
}

// Callback function for Add New Resource page
function rgv_add_new_callback() {
    echo '<h1>Add New Resource</h1>';
    // Add your Add New Resource page content here
}

// Callback function for Categories page
function rgv_categories_callback() {
    echo '<h1>Categories</h1>';
    // Add your Categories page content here
}

// Handle form submissions and save data
// Add your form handling functions here

// Shortcode implementation
// function rgv_resources_grid_shortcode($atts) {
//     // Shortcode logic to display resources in a grid view
// }
// add_shortcode('resources_grid', 'rgv_resources_grid_shortcode');