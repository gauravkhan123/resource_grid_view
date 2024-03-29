<?php 

if( ! class_exists('resource_grid_shortcode')){
    class resource_grid_shortcode{
        public function __construct(){
            add_shortcode( 'resource_grid', array( $this, 'add_shortcode' ) );
        }

        public function add_shortcode( $atts = array(), $content = null, $tag = '' ){

            $atts = array_change_key_case( (array) $atts, CASE_LOWER );

            extract( shortcode_atts(
                array(
                    'id' => '',
                    'orderby' => 'date'
                ),
                $atts,
                $tag
            ));

            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id ) );
            }
            
            ob_start();
            require( WP_RESOURCES_PATH . 'views/wp_resources_shortcode.php' );
           wp_enqueue_script( 'wp-resources-js' );
           wp_enqueue_style( 'wp-resources-css' );
           //resource_grid_options();
           return ob_get_clean();
        }
    }
}