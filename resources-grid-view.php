<?php

/**
 * Plugin Name: Resources Grid View
 * Plugin URI: https://www.wordpress.org/resources-grid-view
 * Description: this plugin helps to display any resources post on any page via a shortcode
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Gaurav Khandelwal
 * Author URI: https://gauravkhandelwal.in/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: resources-grid-view
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WP_Resources_Grid')) {
    class WP_Resources_Grid
    {
        function __construct()
        {
            $this->define_constants();
            add_action( 'admin_menu', array( $this, 'add_menu' ) );
            require_once(WP_RESOURCES_PATH . 'post-types/class.wp-resources-cpt.php');
            $WP_Resources_Post_Type = new WP_Resources_Post_Type();
            require_once( WP_RESOURCES_PATH . 'class.setting-page.php' );
            $resource_grid_Settings = new resource_grid_Settings();
            require_once(WP_RESOURCES_PATH . 'shortcodes/class.wp-resources-shortcode.php');
            $resource_grid_Settings = new resource_grid_Settings();
            add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 999 );
            add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts') );
        }

        public function define_constants()
        {
            define('WP_RESOURCES_PATH', plugin_dir_path(__FILE__));
            define('WP_RESOURCES_URL', plugin_dir_url(__FILE__));
            define('WP_RESOURCES_VERSION', '1.0.0');
        }

        public static function activate()
        {
            update_option('rewrite_rules', '');
        }

        public static function deactivate()
        {
            flush_rewrite_rules();
            unregister_post_type('wp_resources');
        }

        public static function uninstall()
        {
            delete_option('resource_grid_options');

            $posts = get_posts(
                array(
                    'post_type' => 'wp_resources',
                    'number_posts'  => -1,
                    'post_status'   => 'any'
                )
            );

            foreach ($posts as $post) {
                wp_delete_post($post->ID, true);
            }
        }
        public function add_menu(){
            add_menu_page(
                esc_html__( 'Resources grid Options', 'resources-grid-view' ),
                'Resources grid Options',
                'manage_options',
                'rg_admin',
                array( $this, 'resource_grid_settings_page' ),
                'dashicons-images-alt2'
            );

            // add_submenu_page(
            //     'rg_admin',
            //     esc_html__( 'Manage Slides', 'mv-slider' ),
            //     esc_html__( 'Manage Slides', 'mv-slider' ),
            //     'manage_options',
            //     'edit.php?post_type=mv-slider',
            //     null,
            //     null
            // );

            // add_submenu_page(
            //     'resource_grid_admin',
            //     esc_html__( 'Add New Slide', 'mv-slider' ),
            //     esc_html__( 'Add New Slide', 'mv-slider' ),
            //     'manage_options',
            //     'post-new.php?post_type=mv-slider',
            //     null,
            //     null
            // );

        }

        public function resource_grid_settings_page(){
            if( ! current_user_can( 'manage_options' ) ){
                return;
            }

            if( isset( $_GET['settings-updated'] ) ){
                add_settings_error( 'resource_grid_options', 'resource_grid_message', esc_html__( 'Settings Saved', 'mv-slider' ), 'success' );
            }
            
            settings_errors( 'resource_grid_options' );

            require( WP_RESOURCES_PATH . 'views/setting-page.php' );
        }
        public function register_scripts(){
            wp_register_script( 'wp-resources-js', WP_RESOURCES_URL . 'assets/css/bootstrap.min.js', array( 'jquery' ), WP_RESOURCES_VERSION, true );
            wp_register_style( 'wp-resources-css', WP_RESOURCES_URL . 'assets/css/bootstrap.min.css', array(), WP_RESOURCES_VERSION, 'all' );
        }
        
        public function register_admin_scripts(){
            global $typenow;
            if( $typenow == 'wp_resources'){
                wp_enqueue_style( 'wp-resources-admin', WP_RESOURCES_URL . 'assets/css/admin.css' );
            }
        }
    }
}

if (class_exists('WP_Resources_Grid')) {
    register_activation_hook(__FILE__, array('WP_Resources_Grid', 'activate'));
    register_deactivation_hook(__FILE__, array('WP_Resources_Grid', 'deactivate'));
    register_uninstall_hook(__FILE__, array('WP_Resources_Grid', 'uninstall'));

    $WP_Resources_Grid = new WP_Resources_Grid();
}
// add_action($tag, $function_to_add, $priority, $accepted_args);
// settings_fields($option_group);
// do_settings_sections($page);
// add_settings_field($id, $title, $callback, $page, $section, $args)
