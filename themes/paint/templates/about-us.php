<?php
/**
 * Template Name: About Us
 */

get_header();

?>

<main class="about-page">
    <?php get_template_part('templates/parts/about-page/inc', 'hero'); ?>
    <?php get_template_part('templates/parts/about-page/inc', 'values'); ?>
    <?php get_template_part('templates/parts/about-page/inc', 'intro'); ?>
    <?php get_template_part('templates/parts/about-page/inc', 'publication'); ?>
    <?php get_template_part('templates/parts/about-page/inc', 'services'); ?>
    <?php get_template_part('templates/parts/about-page/inc', 'technology'); ?>
    <?php get_template_part('templates/parts/about-page/inc', 'principle'); ?>
    <?php get_template_part('templates/parts/about-page/inc', 'goal'); ?>
    <?php get_template_part('templates/parts/about-page/inc', 'certification'); ?>
</main>

<?php

get_footer();
