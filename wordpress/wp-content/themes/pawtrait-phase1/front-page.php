<?php get_header(); ?>
<main id="main" class="compact-home">
<?php foreach(['hero','collection','help'] as $module) get_template_part('template-parts/home/'.$module); ?>
</main>
<?php get_footer(); ?>
