<?php
defined('ABSPATH') || exit;
add_action('after_setup_theme', function() {
    add_theme_support('title-tag'); add_theme_support('post-thumbnails'); add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom'); add_theme_support('wc-product-gallery-lightbox'); add_theme_support('wc-product-gallery-slider');
    add_theme_support('html5', ['search-form','gallery','caption','style','script']);
    register_nav_menus(['primary'=>'Primary navigation','footer'=>'Footer navigation']);
});
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('pawtrait',get_stylesheet_uri(),[],filemtime(get_template_directory().'/style.css'));
    wp_enqueue_script('pawtrait',get_template_directory_uri().'/assets/store.js',[],filemtime(get_template_directory().'/assets/store.js'),true);
});
remove_action('woocommerce_before_main_content','woocommerce_output_content_wrapper',10);
remove_action('woocommerce_after_main_content','woocommerce_output_content_wrapper_end',10);
remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);
add_action('woocommerce_before_main_content',fn()=>print('<main id="main" class="wrap shop-main">'),10);
add_action('woocommerce_after_main_content',fn()=>print('</main>'),10);
add_filter('loop_shop_columns',fn()=>3);
add_filter('woocommerce_product_add_to_cart_text',fn($text)=>function_exists('pt_release_open') && !pt_release_open()?'View details':$text);
add_action('woocommerce_before_single_product_summary',function(){echo '<div class="notice">'.esc_html(pt_checkout_hold()).'</div>';},5);
add_action('woocommerce_single_product_summary',function(){echo '<p class="micro">Standard ready-made design. Choose only the listed options. <a href="'.esc_url(pt_url('size-guide')).'">Size guide</a> · <a href="'.esc_url(pt_url('delivery-returns')).'">Delivery &amp; returns</a></p>';},25);
add_action('woocommerce_before_cart',function(){echo '<p class="notice">'.esc_html(pt_checkout_hold()).'</p>';});
add_action('woocommerce_before_checkout_form',function(){echo '<p class="notice">'.esc_html(pt_checkout_hold()).'</p>';});
function pt_url($slug='') { return home_url('/'.($slug?trim($slug,'/').'/':'')); }
function pt_asset($file) { return get_template_directory_uri().'/assets/'.$file; }
function pt_link($slug,$label,$class='') { return '<a class="'.esc_attr($class).'" href="'.esc_url(pt_url($slug)).'">'.esc_html($label).'</a>'; }
function pt_campaign() {
    $state=function_exists('pt_drop_state')?pt_drop_state():'upcoming';
    return $state==='closed'?'The first drop has closed.':($state==='open'?'First drop · 1–15 November 2026':'First drop planned · 1–15 November 2026');
}
function pt_empty($heading='The collection is on its way.') {
    echo '<div class="collection-empty"><span class="eyebrow">FIRST DROP / NOVEMBER 2026</span><h3>'.esc_html($heading).'</h3><p>We’re getting the pieces ready. Confirmed designs, product photos, sizes and prices will appear here before orders open.</p><p class="micro">Planned pre-order window: 1–15 November 2026.<br>Deadline: 15 November, 23:59 (Europe/London).</p></div>';
}
function pt_products($category='', $featured=false) {
    if (!function_exists('WC')) { pt_empty(); return; }
    $meta=[['key'=>'_pawtrait_phase1_verified','value'=>'yes']];
    $args=['post_type'=>'product','post_status'=>'publish','posts_per_page'=>$featured?4:24,'meta_query'=>$meta];
    if (is_page('shop-by-design') && !empty($_GET['artwork'])) {
        $design=sanitize_title(wp_unslash($_GET['artwork']));
        $args['tax_query'][]=['taxonomy'=>'product_tag','field'=>'slug','terms'=>$design];
    }
    if($category) $args['tax_query']=[['taxonomy'=>'product_cat','field'=>'slug','terms'=>$category]];
    if($featured) $args['tax_query'][]=['taxonomy'=>'product_visibility','field'=>'name','terms'=>'featured'];
    $q=new WP_Query($args);
    if(!$q->have_posts()) { pt_empty($featured?'First-drop favourites, coming soon.':'The collection is on its way.'); return; }
    woocommerce_product_loop_start();
    while($q->have_posts()){ $q->the_post(); wc_get_template_part('content','product'); }
    woocommerce_product_loop_end(); wp_reset_postdata();
}
add_filter('woocommerce_show_page_title','__return_true');
add_action('woocommerce_archive_description',function(){
    echo '<p class="muted">Pet-inspired pieces for the everyday. Ready-made designs, with the available options listed on each product.</p>';
    pt_shop_filters();
},15);
function pt_shop_filters() {
    echo '<nav class="filters" aria-label="Shop categories">';
    foreach(['shop'=>'Shop All','clothing'=>'Clothing','accessories'=>'Accessories','everyday-essentials'=>'Everyday Essentials'] as $s=>$n) echo pt_link($s,$n,'filter');
    echo '</nav>';
}
remove_action('woocommerce_no_products_found','wc_no_products_found');
add_action('woocommerce_no_products_found',fn()=>pt_empty());
add_shortcode('pawtrait_products',function($atts){$a=shortcode_atts(['category'=>''],$atts);ob_start();pt_products(sanitize_title($a['category']));return ob_get_clean();});
add_shortcode('pawtrait_filters',function(){ob_start();pt_shop_filters();return ob_get_clean();});
add_shortcode('pawtrait_qq',function(){return '<figure class="design-photo"><img src="'.esc_url(pt_asset('qq-profile.jpg')).'" alt="QQ, Pawtrait’s first pet model, photographed in profile" loading="lazy" width="1200" height="1600"><figcaption>01 / QQ · Our first pet model</figcaption></figure>';});

// Artwork filters are populated only from tags attached to verified published products.
add_shortcode('pawtrait_designs',function(){
    $products=get_posts(['post_type'=>'product','post_status'=>'publish','numberposts'=>-1,'fields'=>'ids','meta_query'=>[['key'=>'_pawtrait_phase1_verified','value'=>'yes']]]);
    if(!$products) return '';
    $terms=wp_get_object_terms($products,'product_tag');
    if(is_wp_error($terms)||!$terms) return '';
    $out='<nav class="filters" aria-label="Artwork designs">'.pt_link('shop-by-design','All designs','filter');
    foreach($terms as $term) $out.='<a class="filter" href="'.esc_url(add_query_arg('artwork',$term->slug,pt_url('shop-by-design'))).'">'.esc_html($term->name).'</a>';
    return $out.'</nav>';
});
