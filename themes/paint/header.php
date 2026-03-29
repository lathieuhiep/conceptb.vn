<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?php bloginfo('description'); ?>"/>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!--Include Loading Template-->
<?php get_template_part('template-parts/inc', 'loading'); ?>
<!--End Loading Template-->

<div class="main-warp position-relative d-flex flex-column h-100">
    <?php
        if (!is_404()) {
            get_template_part('template-parts/header/inc', 'header');
        }
    ?>
    <!--Start Sticky Footer-->
    <div class="sticky-footer">



