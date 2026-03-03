<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WMHM_Analyzer {

    public static function classify_meta_key($key) {

        if (strpos($key, '_wc_') === 0 || strpos($key, '_price') !== false) {
            return 'Commerce Data';
        }

        if (strpos($key, 'rank_math') !== false || strpos($key, 'schema') !== false) {
            return 'SEO / Schema';
        }

        if (strpos($key, '_elementor') !== false) {
            return 'Builder Data';
        }

        if (strpos($key, 'acf') !== false) {
            return 'Custom Fields';
        }

        if (strpos($key, '_') === 0) {
            return 'System Meta';
        }

        return 'Custom / Plugin Data';
    }

    public static function get_health_score($top_percent) {

        $score = max(0, min(100, 100 - $top_percent));

        if ($score >= 80) {
            $label = 'EXCELLENT';
            $color = '#46b450';
        } elseif ($score >= 60) {
            $label = 'GOOD';
            $color = '#2271b1';
        } elseif ($score >= 40) {
            $label = 'WARNING';
            $color = '#ffb900';
        } else {
            $label = 'CRITICAL';
            $color = '#dc3232';
        }

        return [
            'score' => round($score,1),
            'label' => $label,
            'color' => $color
        ];
    }
}