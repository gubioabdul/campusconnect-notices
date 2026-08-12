<?php
/**
 * Plugin Name: CampusConnect Notices
 * Description: Displays departmental notices using the [campus_notices] shortcode.
 * Version: 0.1.0
 * Author: CampusConnect Contributors
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) exit;

function campusconnect_register_notice_post_type() {
    register_post_type('campus_notice', [
        'labels' => ['name' => 'Campus Notices', 'singular_name' => 'Campus Notice', 'add_new_item' => 'Add Campus Notice', 'edit_item' => 'Edit Campus Notice'],
        'public' => true,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'campusconnect_register_notice_post_type');

function campusconnect_notices_shortcode() {
    $notices = get_posts(['post_type' => 'campus_notice', 'numberposts' => 5, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC']);
    if (!$notices) return '<p class="campusconnect-notices-empty">No notices available.</p>';
    $output = '<ul class="campusconnect-notices">';
    foreach ($notices as $notice) {
        $output .= '<li class="campusconnect-notice">';
        $output .= '<strong>' . esc_html($notice->post_title) . '</strong>';
        $output .= '<p>' . esc_html(wp_trim_words($notice->post_content, 30)) . '</p>';
        $output .= '</li>';
    }
    return $output . '</ul>';
}
add_shortcode('campus_notices', 'campusconnect_notices_shortcode');
