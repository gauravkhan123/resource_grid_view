<?php

if (!class_exists('WP_Resources_Post_Type')) {
    class WP_Resources_Post_Type
    {
        function __construct()
        {
            add_action('init', array($this, 'create_post_type'));
            add_action('init', array($this, 'custom_taxonomy_categories'));
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_post'), 10, 2);
        }

        public function create_post_type()
        {
            register_post_type(
                'wp_resources',
                array(
                    'label' => esc_html__('Wp Resource', 'resources-grid-view'),
                    'description'   => esc_html__('Wp Resource', 'resources-grid-view'),
                    'labels' => array(
                        'name'  => esc_html__('WP Resource', 'resources-grid-view'),
                        'singular_name' => esc_html__('WP Resources', 'resources-grid-view'),
                        'all_items' => esc_html__('All Resources', 'resources-grid-view'),
                        'add_new' => __('Add New', 'resources-grid-view'),
                        //'name_admin_bar' => __('Add New', 'resources-grid-view'),
                        'new_item' => __('Add New Show', 'resources-grid-view'),
                    ),
                    'public'    => true,
                    'supports'  => array('title', 'editor', 'thumbnail', 'revisions',),
                    'show_ui'   => true,
                    'show_in_menu'  => true,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export'    => true,
                    'has_archive'   => false,
                    'exclude_from_search'   => false,
                    'publicly_queryable'    => true,
                    'show_in_rest'  => true,
                    'menu_icon' => 'dashicons-images-alt2',
                    //'register_meta_box_cb'  =>  array( $this, 'add_meta_boxes' )
                )
            );
        }
        // Register Custom Taxonomy
        function custom_taxonomy_categories()
        {
            register_taxonomy('wpcategories', ['wp_resources'], [
                'label' => __('Categories', 'txtdomain'),
                'hierarchical' => true,
                'rewrite' => ['slug' => 'categories'],
                'show_admin_column' => true,
                'show_in_rest' => true,
                'labels' => [
                    'singular_name' => __('Categories', 'txtdomain'),
                    'all_items' => __('All Categories', 'txtdomain'),
                    'edit_item' => __('Edit Categories', 'txtdomain'),
                    'view_item' => __('View Categories', 'txtdomain'),
                    'update_item' => __('Update Categories', 'txtdomain'),
                    'add_new_item' => __('Add New Categories', 'txtdomain'),
                    'new_item_name' => __('New Categories Name', 'txtdomain'),
                    'search_items' => __('Search Categories', 'txtdomain'),
                    'popular_items' => __('Popular Categories', 'txtdomain'),
                    'separate_items_with_commas' => __('Separate Categories with comma', 'txtdomain'),
                    'choose_from_most_used' => __('Choose from most used Categories', 'txtdomain'),
                    'not_found' => __('No Categories found', 'txtdomain'),
                ]
            ]);
        }
        public function add_meta_boxes()
        {
            add_meta_box(
                'resource_grid_meta_box',
                'Link Options',
                array($this, 'add_inner_meta_boxes'),
                'wp_resources',
                'normal',
                'high'
            );
        }

        public function add_inner_meta_boxes($post)
        {
            require_once(WP_RESOURCES_PATH . 'views/wp_resources_metabox.php');
        }

        public function save_post($post_id)
        {
            if( isset( $_POST['resource_grid_nonce'] ) ){
                if( ! wp_verify_nonce( $_POST['resource_grid_nonce'], 'resource_grid_nonce' ) ){
                    return;
                }
            }

            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
                return;
            }

            if( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'mv-slider' ){
                if( ! current_user_can( 'edit_page', $post_id ) ){
                    return;
                }elseif( ! current_user_can( 'edit_post', $post_id ) ){
                    return;
                }
            }

            if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ){
                $old_link_text = get_post_meta( $post_id, 'resource_grid_link_text', true );
                $new_link_text = $_POST['resource_grid_link_text'];
                $old_link_url = get_post_meta( $post_id, 'resource_grid_link_url', true );
                $new_link_url = $_POST['resource_grid_link_url'];

                if( empty( $new_link_text )){
                    update_post_meta( $post_id, 'resource_grid_link_text', esc_html__( 'Add some text', 'mv-slider' ) );
                }else{
                    update_post_meta( $post_id, 'resource_grid_link_text', sanitize_text_field( $new_link_text ), $old_link_text );
                }

                if( empty( $new_link_url )){
                    update_post_meta( $post_id, 'resource_grid_link_url', '#' );
                }else{
                    update_post_meta( $post_id, 'resource_grid_link_url', sanitize_text_field( $new_link_url ), $old_link_url );
                }
                
                
            }
        
        }
    }
}
