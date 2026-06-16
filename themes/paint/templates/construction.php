<?php
/*
 Template Name: Construction Page
 */

get_header();
?>

<main class="construction-page">
  <?php get_template_part('templates/parts/construction-page/inc', 'hero'); ?>
  <nav class="construction-anchor-nav" aria-label="<?php esc_attr_e('Construction page navigation', 'paint'); ?>" data-construction-anchor-nav>
    <a class="construction-anchor-nav__link" href="#construction-workflow-gallery">
      <?php esc_html_e('Quy trình làm việc', 'paint'); ?>
    </a>
    <a class="construction-anchor-nav__link" href="#construction-tools">
      <?php esc_html_e('Dụng cụ thi công', 'paint'); ?>
    </a>
    <a class="construction-anchor-nav__link" href="#construction-contact">
      <?php esc_html_e('Xem báo giá', 'paint'); ?>
    </a>
  </nav>
  <?php get_template_part('templates/parts/construction-page/inc', 'process'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'recommendation'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'why-choose'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'workflow-gallery'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'tools'); ?>
  <?php get_template_part('templates/parts/construction-page/inc', 'contact'); ?>
</main>

<?php

get_footer();
