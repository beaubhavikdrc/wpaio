<?php

/**
 * Wordpress All In One
 *
 * Plugin Name: Wordpress All In One
 * Plugin URI:  https://github.com/spiderdunia/wpaio/
 * Description: Wordpress AIO plugin is a piece of code that "plugs into" your WordPress site. Wordpress AIO can add new functionality or extend existing functionality, allowing you to work smooth.
 * Version:     1.0.0
 * Author:      Beau Bhavik
 * Author URI:  https://github.com/spiderdunia/wpaio/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: wpaio
 * Domain Path: /languages
 * Requires at least: 4.9
 * Tested up to: 5.8
 * Requires PHP: 5.2.4
 *
 */


defined('ABSPATH') or die('No Access Allowed...');

define('WPAIO_PLUGIN_FILE', __FILE__);

define('WPAIO_PLUGIN_DIR', dirname(WPAIO_PLUGIN_FILE));

define('WPAIO_PLUGIN_BASENAME', plugin_basename(WPAIO_PLUGIN_FILE));

define('WPAIO_DETECT_PLUGIN_URI', plugin_dir_url(WPAIO_PLUGIN_FILE));

define('WPAIO_DETECT_PLUGIN_URL', plugins_url('', __FILE__));

add_action('plugin_action_links_' . WPAIO_PLUGIN_BASENAME, 'WPAIO_plugin_action_links');
function WPAIO_plugin_action_links($links)
{
    $links = array_merge(array(
        '<a href="' . esc_url(admin_url('/admin.php')) . '?page=wpaio">' . __('Settings', 'wpaio') . '</a>'
    ), $links);

    return $links;
}

add_action('admin_menu', 'wpaio_add_menu');
function wpaio_add_menu()
{
    $main_page = add_menu_page('Wordpress AIO', 'Wordpress AIO', 'manage_options', 'wpaio', 'wordpress_aio_init', 'dashicons-ellipsis', 70);
    add_action('admin_print_styles-' . $main_page, 'create_option_page_style_js');
}

function create_option_page_style_js()
{

    wp_enqueue_script('jquery');
    wp_enqueue_style('wpaio-main', WPAIO_DETECT_PLUGIN_URL . 'assets/css/wpaio.css');
    wp_enqueue_script('wpaio-main', WPAIO_DETECT_PLUGIN_URL . 'assets/js/wpaio.js', '', '', true);
    wp_localize_script('wpaio-admin-js', 'ajax_var', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wpaio-admin-ajax-nonce')
    ));
    // wp_localize_script( 'wpdevart_duplicate_post_admin_menu_js', 'wpdevart_js_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );		
}

function wordpress_aio_init()
{
    require_once(WPAIO_PLUGIN_DIR . '/inc/core.php');
}


