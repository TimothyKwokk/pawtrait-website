<?php get_header(); ?>
<main id="main" class="wrap page-main">
<?php while(have_posts()): the_post(); ?>
<header class="pagehero"><span class="eyebrow">PAWTRAIT / <?php echo is_page(['clothing','accessories','everyday-essentials','hoodies','t-shirts','beanies','phone-cases','earbud-pouches','stickers','insulated-bags','insulated-cups'])?'THE COLLECTION':'OUR LITTLE WORLD'; ?></span><h1><?php the_title(); ?></h1></header>
<div class="page-content <?php echo is_cart()||is_checkout()?'commerce-content':''; ?>"><?php the_content(); ?></div>
<?php endwhile; ?></main><?php get_footer(); ?>
