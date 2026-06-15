<?php
/*
 Template Name: Construction Page
 */

get_header();
?>

<main class="construction-page">
  <?php get_template_part('templates/parts/construction-page/inc', 'hero'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'process'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'recommendation'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'why-choose'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'workflow-gallery'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'tools'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'contact'); ?>
</main>

<?php

get_footer();
