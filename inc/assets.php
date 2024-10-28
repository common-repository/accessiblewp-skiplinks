<?php
/**
 * Enqueue the front-end assets
 */
function acwp_skiplinks_front_assets() {
    $assets_dir_url = AWP_SKIPLINKS_DIR . 'assets';
	
    wp_enqueue_style( 'acwp-skiplinks-css',      $assets_dir_url . '/css/skiplinks.css' );

    // wp_enqueue_script("jquery-ui-draggable");
}
add_action( 'wp_enqueue_scripts', 'acwp_skiplinks_front_assets' );

/**
 * Enqueue the admin panel assets
 */
function acwp_skiplinks_admin_assets() {
    $assets_dir_url = AWP_SKIPLINKS_DIR . 'assets';

    wp_enqueue_script( 'acwp-skiplinks-admin',    $assets_dir_url . '/js/admin.js', array( 'jquery' ), '', true );
    wp_enqueue_style( 'acwp-skiplinks-admin-css', $assets_dir_url . '/css/admin.css' );
    wp_enqueue_media();
    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');
}
add_action('admin_enqueue_scripts', 'acwp_skiplinks_admin_assets');
