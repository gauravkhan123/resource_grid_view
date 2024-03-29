<?php
if( ! function_exists( 'wp_resources_get_placeholder_image' )){
    function wp_resources_get_placeholder_image(){
        return "<img src='" . WP_RESOURCES_URL . "assets/images/default.png' class='img-fluid wp-post-image' />";
    }
}