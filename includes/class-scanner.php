<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Meta Health Scanner
 */
class WMHM_Scanner {

    /**
     * Get total rows from wp_postmeta
     */
    public static function get_total_postmeta_rows() {

        global $wpdb;

        $total = $wpdb->get_var("
            SELECT COUNT(*)
            FROM {$wpdb->postmeta}
        ");

        return (int) $total;
    }
    
    public static function get_heaviest_posts($limit = 10) {

    global $wpdb;

    $query = $wpdb->prepare("
    SELECT 
        pm.post_id,
        COUNT(*) AS total_meta,
        p.post_title,
        p.post_type
    FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p
        ON pm.post_id = p.ID
    GROUP BY pm.post_id
    ORDER BY total_meta DESC
    LIMIT %d
", $limit);

    return $wpdb->get_results($query);
}

//** post by type **//

public static function get_meta_by_post_type() {

    global $wpdb;

    $query = "
        SELECT 
            p.post_type,
            COUNT(pm.meta_id) AS total_meta
        FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p
            ON pm.post_id = p.ID
        GROUP BY p.post_type
        ORDER BY total_meta DESC
    ";

    return $wpdb->get_results($query);
}

//** Avg meta per product **//

public static function get_avg_meta_per_product() {

    global $wpdb;

    $query = "
        SELECT 
            COUNT(pm.meta_id) / COUNT(DISTINCT p.ID) AS avg_meta
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p
            ON pm.post_id = p.ID
        WHERE p.post_type = 'product'
    ";

    return (float) $wpdb->get_var($query);
}

public static function get_top_meta_keys($limit = 20) {

    global $wpdb;

    $query = $wpdb->prepare("
        SELECT 
            meta_key,
            COUNT(*) AS total_meta
        FROM {$wpdb->postmeta}
        GROUP BY meta_key
        ORDER BY total_meta DESC
        LIMIT %d
    ", $limit);

    return $wpdb->get_results($query);
}

//* Cache Layer *//

public static function get_cached_data() {

    $cached = get_transient('wmhm_scan_data');

    if ( $cached !== false ) {
        return $cached;
    }

    // Run fresh scan
    $data = [
        'total'         => self::get_total_postmeta_rows(),
        'heavy_posts'   => self::get_heaviest_posts(),
        'meta_by_type'  => self::get_meta_by_post_type(),
        'avg_meta'      => self::get_avg_meta_per_product(),
        'top_meta_keys' => self::get_top_meta_keys(),
    ];

    set_transient('wmhm_scan_data', $data, 15 * MINUTE_IN_SECONDS);

    return $data;
}

}