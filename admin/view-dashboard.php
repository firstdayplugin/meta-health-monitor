<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* ========= PREPARE DATA ========= */

$category_totals = [];

foreach ( $top_meta_keys as $row ) {
    $cat = WMHM_Analyzer::classify_meta_key( $row->meta_key );

    if ( ! isset( $category_totals[$cat] ) ) {
        $category_totals[$cat] = 0;
    }

    $category_totals[$cat] += $row->total_meta;
}

arsort( $category_totals );

$top_category = array_key_first( $category_totals );
$top_percent  = $total > 0
    ? ( $category_totals[$top_category] / $total ) * 100
    : 0;

$health_score = WMHM_Analyzer::get_health_score( $top_percent );
?>

<div class="wrap wmhm-dashboard">

<div class="wmhm-header">

    <h1><?php esc_html_e('Meta Health Monitor','wp-meta-health-monitor'); ?></h1>

    <form method="post" class="wmhm-scan-form">
        <?php wp_nonce_field('wmhm_rescan'); ?>
        <button class="button button-primary" name="wmhm_rescan">
            <?php esc_html_e('Scan Now','wp-meta-health-monitor'); ?>
        </button>
    </form>

</div>

<!-- =============================
     QUICK STATS
================================= -->

<div class="wmhm-stats-row">

    <div class="wmhm-stat-box">
        <span class="wmhm-stat-label">
            <?php esc_html_e('Total Postmeta Rows','wp-meta-health-monitor'); ?>
        </span>
        <span class="wmhm-stat-value">
            <?php echo esc_html($total); ?>
        </span>
    </div>

    <div class="wmhm-stat-box">
        <span class="wmhm-stat-label">
            <?php esc_html_e('Average Meta per Product','wp-meta-health-monitor'); ?>
        </span>
        <span class="wmhm-stat-value">
            <?php echo esc_html( round($avg_meta,2) ); ?>
        </span>
    </div>

</div>

<!-- =============================
     HEALTH SCORE
================================= -->

<div class="wmhm-health-score">

    <h2><?php esc_html_e('Meta Health Score','wp-meta-health-monitor'); ?></h2>

    <div class="wmhm-score-number"
         style="color:<?php echo esc_attr($health_score['color']); ?>;">

        <?php echo esc_html($health_score['score']); ?>/100
    </div>

    <div class="wmhm-score-label">
        <?php echo esc_html($health_score['label']); ?>
    </div>

    <div class="wmhm-progress-wrap">
        <div class="wmhm-progress-bar"
             style="
                width:<?php echo esc_attr($health_score['score']); ?>%;
                background:<?php echo esc_attr($health_score['color']); ?>;
             ">
        </div>
    </div>

</div>

<!-- =============================
     INSIGHT
================================= -->

<div class="wmhm-insight-box">

    <strong><?php esc_html_e('Primary Contributor:','wp-meta-health-monitor'); ?></strong>
    <?php echo esc_html($top_category); ?>
    (<?php echo esc_html( round($top_percent,2) ); ?>%)

</div>

<!-- =============================
     META BY POST TYPE
================================= -->

<h2><?php esc_html_e('Meta Usage by Post Type','wp-meta-health-monitor'); ?></h2>

<table class="widefat striped">
<thead>
<tr>
<th><?php esc_html_e('Post Type','wp-meta-health-monitor'); ?></th>
<th><?php esc_html_e('Total Meta','wp-meta-health-monitor'); ?></th>
</tr>
</thead>
<tbody>

<?php foreach ( $meta_by_type as $row ) : ?>
<tr>
<td><?php echo esc_html($row->post_type ?: 'NULL'); ?></td>
<td><?php echo esc_html($row->total_meta); ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<!-- =============================
     TOP HEAVY POSTS
================================= -->

<h2><?php esc_html_e('Top Heavy Posts','wp-meta-health-monitor'); ?></h2>

<table class="widefat striped">
<thead>
<tr>
<th><?php esc_html_e('Post ID','wp-meta-health-monitor'); ?></th>
<th><?php esc_html_e('Title','wp-meta-health-monitor'); ?></th>
<th><?php esc_html_e('Post Type','wp-meta-health-monitor'); ?></th>
<th><?php esc_html_e('Total Meta','wp-meta-health-monitor'); ?></th>
</tr>
</thead>
<tbody>

<?php foreach ( $heavy_posts as $post ) : ?>
<tr>
<td><?php echo esc_html($post->post_id); ?></td>
<td><?php echo esc_html($post->post_title); ?></td>
<td><?php echo esc_html($post->post_type); ?></td>
<td><?php echo esc_html($post->total_meta); ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<!-- =============================
     TOP META KEYS
================================= -->

<h2><?php esc_html_e('Top Meta Keys','wp-meta-health-monitor'); ?></h2>

<table class="widefat striped">
<thead>
<tr>
<th><?php esc_html_e('Meta Key','wp-meta-health-monitor'); ?></th>
<th><?php esc_html_e('Total Rows','wp-meta-health-monitor'); ?></th>
<th><?php esc_html_e('Category','wp-meta-health-monitor'); ?></th>
</tr>
</thead>
<tbody>

<?php foreach ( $top_meta_keys as $row ) :

    $percent = $total > 0
        ? ( $row->total_meta / $total ) * 100
        : 0;

    $row_class = $percent >= 3 ? 'wmhm-highlight' : '';
?>

<tr class="<?php echo esc_attr($row_class); ?>">
<td><?php echo esc_html($row->meta_key); ?></td>
<td><?php echo esc_html($row->total_meta . ' (' . round($percent,2) . '%)'); ?></td>
<td><?php echo esc_html(WMHM_Analyzer::classify_meta_key($row->meta_key)); ?></td>
</tr>

<?php endforeach; ?>

</tbody>
</table>

</div>