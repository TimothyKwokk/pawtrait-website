<!doctype html><html <?php language_attributes(); ?>><head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#214d3d"><?php wp_head(); ?></head><body <?php body_class(); ?>><?php wp_body_open(); ?>
<a class="skip" href="#main">Skip to content</a>
<?php if(function_exists('pt_local_preview') && pt_local_preview()): ?><div class="dev-note">Development preview · Orders are not open</div><?php endif; ?>
<div class="topline"><?php echo esc_html(pt_campaign()); ?> <span>· Closes 15 Nov, 23:59 London time</span></div>
<header class="header"><div class="wrap nav"><a class="logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Pawtrait home">pawtrait<span>✳</span></a>
<button class="menu" aria-expanded="false" aria-controls="navigation">Menu <span aria-hidden="true">☰</span></button>
<nav id="navigation" class="navlinks" aria-label="Main navigation"><?php foreach(['shop'=>'Shop All','clothing'=>'Clothing','accessories'=>'Accessories','everyday-essentials'=>'Everyday Essentials','our-story'=>'Our Story'] as $s=>$n): ?><a <?php if(is_page($s)||($s==='shop'&&function_exists('is_shop')&&is_shop())) echo 'aria-current="page"'; ?> href="<?php echo esc_url(pt_url($s)); ?>"><?php echo esc_html($n); ?></a><?php endforeach; ?></nav>
<a class="bag" href="<?php echo esc_url(wc_get_cart_url()); ?>" aria-label="View shopping bag">Bag <span class="bag-count"><?php echo WC()->cart?absint(WC()->cart->get_cart_contents_count()):0; ?></span></a></div></header>
