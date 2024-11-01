<?php
/**
 * Plugin Name: Trusted Order Notifications
 * Plugin URI: https://vnfaster.com/trusted-order-notifications-tao-thong-bao-don-hang-gan-day.html
 * Description: Trusted Order Notifications on Ecommerce Site.
 * Version: 3.0.0
 * Author: Tien Luc
 * Author URI: https://vnfaster.com/trusted-order-notifications-tao-thong-bao-don-hang-gan-day.html
 *
 * Text Domain: Trusted Order Notifications on Ecommerce Site.
 * Domain Path: /languages/
 *
 * @package Trusted Order Notifications
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define.
define( 'VNF_VERSION', '3.0.0' );
define( 'VNF_FILE', __FILE__ );
define( 'VNF_PATH', plugin_dir_path( VNF_FILE ) );
define( 'VNF_URL', plugin_dir_url( VNF_FILE ) );
define( 'VNF_MODULES_PATH', VNF_PATH . 'modules/' );
define( 'VNF_ASSETS_URL', VNF_URL . 'assets/' );

require_once VNF_PATH . '/includes/class-trusted-order-notifications.php';

/**
 * [vnf_load_plugin_textdomain description]
 * @return [type] [description]
 */
function vnf_load_plugin_textdomain() {
	load_plugin_textdomain( 'trusted-order-notifications', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'vnf_load_plugin_textdomain' );

function vnf_settings_link( $links ) {
    $url = get_admin_url() . 'options-general.php?page=trusted-order-notifications';
    $settings_link = '<a href="' . $url . '">' . __('Settings', 'textdomain') . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
 
function vnf_after_setup_theme() {
     add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'vnf_settings_link');
}
add_action ('after_setup_theme', 'vnf_after_setup_theme');

VNF::instance();
