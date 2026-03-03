<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WMHM_Admin {

    public function __construct() {
        add_action('admin_menu', [$this, 'register_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_init', [$this, 'handle_rescan']);
    }

    public function register_menu() {

        add_menu_page(
            __('Meta Health Monitor','wp-meta-health-monitor'),
            __('Meta Health','wp-meta-health-monitor'),
            'manage_options',
            'meta-health-monitor',
            [$this, 'render_dashboard'],
            'dashicons-database',
            25
        );
    }

    public function enqueue_assets($hook) {

        if ($hook !== 'toplevel_page_meta-health-monitor') {
            return;
        }

        wp_enqueue_style(
            'wmhm-admin',
            WMHM_URL . 'assets/admin.css',
            [],
            WMHM_VERSION
        );
    }

    public function render_dashboard() {

    $data = WMHM_Scanner::get_cached_data();

    $total         = $data['total'];
    $heavy_posts   = $data['heavy_posts'];
    $meta_by_type  = $data['meta_by_type'];
    $avg_meta      = $data['avg_meta'];
    $top_meta_keys = $data['top_meta_keys'];

    require WMHM_PATH . 'admin/view-dashboard.php';
}

public function handle_rescan() {

    if ( isset($_POST['wmhm_rescan']) ) {

        if ( ! isset($_POST['_wpnonce']) ||
             ! wp_verify_nonce($_POST['_wpnonce'], 'wmhm_rescan') ) {
            return;
        }

        delete_transient('wmhm_scan_data');
    }
}

}