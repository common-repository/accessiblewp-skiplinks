<?php
/**
 * Plugin Name: AccessibleWP - Skip-Links
 * Plugin URI: https://wordpress.org/plugins/accessiblewp-skiplinks/
 * Description: Adds an accessible way to skip to page sections, as required by WCAG 2.0 for all levels.
 * Author: Codenroll
 * Author URI: https://www.codenroll.co.il/
 * Version: 1.0.0
 * Text Domain: acwp
 * License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if( ! defined( 'ABSPATH' ) )
    return;

// Define our directory
define('AWP_SKIPLINKS_DIR', plugin_dir_url( __FILE__ ));

require_once 'inc/assets.php';
require_once 'inc/skiplinks.php';
require_once 'inc/panel.php';
require_once 'inc/meta.php';


/**
 * Load toolbar textdomain
 */
function acwp_skiplinks_load_textdomain() {
    $res = load_plugin_textdomain( 'accessiblewp-skiplinks', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}
add_action( 'init', 'acwp_skiplinks_load_textdomain' );

function acwp_skiplinks_body_injection(){
    $is_skiplinks = get_option('acwp_skiplinks');
    $is_bodyopen = get_option('acwp_skiplinks_body_open');
    
    if( $is_skiplinks == 'yes' && $is_bodyopen == 'yes'){
        echo acwp_skiplinks_component();
    }
}
add_action('wp_body_open', 'acwp_skiplinks_body_injection');

function acwp_skiplinks_footer_injection_script(){
    $is_skiplinks = get_option('acwp_skiplinks');
    $is_bodyopen = get_option('acwp_skiplinks_body_open');
    if( $is_skiplinks == 'yes' && $is_bodyopen != 'yes' ){
        echo '<script>jQuery(\'#acwp-skiplinks\').prependTo(document.body);</script>';
    }
}
add_action('wp_head', 'acwp_skiplinks_footer_injection');

function acwp_skiplinks_footer_injection(){
    $is_skiplinks = get_option('acwp_skiplinks');
    $is_bodyopen = get_option('acwp_skiplinks_body_open');
    
    if( $is_skiplinks == 'yes' && $is_bodyopen != 'yes' ){
        echo acwp_skiplinks_component();
    }
}
add_action('wp_footer', 'acwp_skiplinks_footer_injection');

function acwp_skiplinks_component(){
    
    $turnsides = get_option('acwp_skiplinks_turnsides');
    
    $disable_animation = get_option('acwp_skiplinks_noanimation');
    $disable_shadows = get_option('acwp_skiplinks_noshadows');
    
    $header_label = get_option('acwp_skiplinks_header_label');
    $header_id = get_option('acwp_skiplinks_header_id');
    
    $footer_label = get_option('acwp_skiplinks_footer_label');
    $footer_id = get_option('acwp_skiplinks_footer_id');
    
    $content_label = get_option('acwp_skiplinks_content_label');
    $content_id = get_option('acwp_skiplinks_content_id');
    
    $pid = get_the_ID();
    $skiplinks_meta = get_post_meta($pid, 'acwp_skiplinks', true);
    
    // Implement 'class' attribute
    $class = '';
    if(
        ($disable_animation != 'yes') ||
        ($disable_shadows != 'yes') ||
        ($turnsides == 'yes')
    ){
        $class .= 'class="';
        $class .= ($disable_animation != 'yes') ? 'acwp-skiplinks-animated ' : '';
        $class .= ($disable_shadows != 'yes') ? 'acwp-skiplinks-shadows ' : '';
        $class .= ($turnsides == 'yes') ? 'acwp-skiplinks-turnsides' : '';
        $class .= '"';
    }
    $output  = '<nav id="acwp-skiplinks" '.$class.'>';
    $output .= '  <ul>';
    $output .= ($header_label != '' && $header_id != '') ? '<li><a href="#'.$header_id.'" aria-label="'.__('Navigate to', 'accessiblewp-skiplinks').' '.$header_label.'">'.$header_label.'</a></li>' : '';
    $output .= ($content_label != '' && $content_id != '') ? '<li><a href="#'.$content_id.'" aria-label="'.__('Navigate to', 'accessiblewp-skiplinks').' '.$content_label.'">'.$content_label.'</a></li>' : '';
    
    if( $skiplinks_meta ) {
        foreach ( $skiplinks_meta as $field ) {
            $output .= ($field['section_id'] != '' && $field['label'] != '') ? '<li><a href="#'.$field['section_id'].'" aria-label="'.__('Navigate to', 'accessiblewp-skiplinks').' '.$field['label'].'">'.$field['label'].'</a></li>' : '';
        }
    }
    $output .= ($footer_label != '' && $footer_id != '') ? '<li><a href="#'.$footer_id.'" aria-label="'.__('Navigate to', 'accessiblewp-skiplinks').' '.$footer_label.'">'.$footer_label.'</a></li>' : '';
    $output .= '  </ul>';
    $output .= '</nav>';
    
    return wp_kses_post($output);
}

function acwp_skiplinks_customstyle(){
    wp_enqueue_style(
		'acwp-skiplinks-customstyle',
		get_template_directory_uri() . '/assets/css/custom.css'
	);
    $bg_color = get_option('acwp_skiplinks_bg');
    $text_color = get_option('acwp_skiplinks_txt');
    
    $is_custom_style = ($bg_color || $text_color) ? true : false;
    
    $output  = '';
    if( $bg_color && $bg_color != '' ){
        $output .= '#acwp-skiplinks > ul > li > a {background-color: '.$bg_color.'}';
    }
    if( $text_color && $text_color != '' ){
        $output .= '#acwp-skiplinks > ul > li > a {color: '.$text_color.'}';
    }

    
    if( $is_custom_style ){
        wp_add_inline_style( 'acwp-skiplinks-customstyle', $output );
    }
}
add_action('wp_enqueue_scripts', 'acwp_skiplinks_customstyle');
