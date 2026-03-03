<?php
/**
 * Plugin Name: Meta Health Monitor
 * Description: Analyze WordPress postmeta usage and health.
 * Version: 0.1.0
 * Author: Edi Kurniawan
 * Text Domain: meta-health-monitor
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WMHM_PATH', plugin_dir_path( __FILE__ ) );
define( 'WMHM_URL', plugin_dir_url( __FILE__ ) );
define( 'WMHM_VERSION', '0.1.0' );

require_once WMHM_PATH . 'includes/class-scanner.php';
require_once WMHM_PATH . 'includes/class-analyzer.php';
require_once WMHM_PATH . 'admin/class-admin.php';

new WMHM_Admin();