<?php
/**
 * Plugin Name: Pawtrait Phase 1 Controls
 * Description: Reversible ready-made catalogue and pre-order release controls. No payments enabled.
 * Version: 1.0.0
 */
defined('ABSPATH') || exit;
function pt_phase1() { return get_option('pawtrait_phase1_enabled', 'yes') === 'yes'; }
function pt_local_preview() {
    return wp_get_environment_type() === 'local'
        && wp_parse_url(home_url(), PHP_URL_HOST) === 'pawtrait-dev.local'
        && (defined('WP_CLI') && WP_CLI || ($_SERVER['HTTP_HOST'] ?? '') === 'pawtrait-dev.local');
}
// Keep the stored plugin configuration and every upload file intact for Phase 2.
add_filter('option_active_plugins', function($plugins) {
    return pt_phase1() ? array_values(array_diff($plugins, ['woo-addon-uploads/woocommerce-addon-uploads.php'])) : $plugins;
});
// Preview only on the named Local development site. Coming Soon remains enabled in the database.
add_filter('woocommerce_coming_soon_exclude', fn($excluded) => $excluded || pt_local_preview());
function pt_drop_state($time = null) {
    $tz = new DateTimeZone('Europe/London');
    $now = $time === null ? time() : $time;
    $start = (new DateTimeImmutable('2026-11-01 00:00:00', $tz))->getTimestamp();
    $end = (new DateTimeImmutable('2026-11-15 23:59:59', $tz))->getTimestamp();
    return $now < $start ? 'upcoming' : ($now <= $end ? 'open' : 'closed');
}
function pt_release_open() {
    return !pt_local_preview() && get_option('pawtrait_launch_approved', 'no') === 'yes' && pt_drop_state() === 'open';
}
function pt_product_verified($product) {
    if (!$product) return false;
    $parent = $product->is_type('variation') ? wc_get_product($product->get_parent_id()) : $product;
    return $parent && $parent->get_status() === 'publish'
        && $parent->get_meta('_pawtrait_phase1_verified') === 'yes'
        && (!$product->is_type('variation') || $product->get_meta('_pawtrait_phase1_verified') === 'yes');
}
function pt_checkout_hold() { return 'Orders are not open. Our first drop is planned for 1–15 November 2026, closing 15 November at 23:59 (Europe/London). Product and delivery details must be confirmed before ordering.'; }
add_filter('woocommerce_is_purchasable', function($ok, $product) {
    return !pt_phase1() ? $ok : ($ok && pt_release_open() && pt_product_verified($product));
}, 20, 2);
add_filter('woocommerce_variation_is_purchasable', function($ok, $product) {
    return !pt_phase1() ? $ok : ($ok && pt_release_open() && pt_product_verified($product));
}, 20, 2);
add_filter('woocommerce_add_to_cart_validation', function($ok) {
    if (pt_phase1() && !pt_release_open()) { wc_add_notice(pt_checkout_hold(), 'error'); return false; }
    return $ok;
}, 20);
add_action('woocommerce_after_checkout_validation', function($data, $errors) {
    if (pt_phase1() && !pt_release_open()) $errors->add('pawtrait_launch_hold', pt_checkout_hold());
}, 20, 2);
add_action('woocommerce_store_api_checkout_update_order_from_request', function() {
    if (pt_phase1() && !pt_release_open()) throw new \Automattic\WooCommerce\StoreApi\Exceptions\RouteException('pawtrait_launch_hold', pt_checkout_hold(), 403);
});
// Only explicitly verified ready-made products enter catalogue queries; draft Phase 2 work is untouched.
add_action('woocommerce_product_query', function($query) {
    if (!pt_phase1() || is_admin()) return;
    $meta = $query->get('meta_query') ?: [];
    $meta[] = ['key'=>'_pawtrait_phase1_verified','value'=>'yes'];
    $query->set('meta_query', $meta);
});
add_action('template_redirect', function() {
    if (pt_phase1() && function_exists('is_product') && is_product() && !current_user_can('edit_products')) {
        if (!pt_product_verified(wc_get_product(get_queried_object_id()))) {
            global $wp_query; $wp_query->set_404(); status_header(404); nocache_headers();
        }
    }
});
add_action('wp_head', function() {
    if (pt_local_preview()) echo '<meta name="robots" content="noindex, nofollow">';
});
