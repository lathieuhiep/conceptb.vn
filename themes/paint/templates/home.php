<?php
/**
 * Template Name: Home
 */

get_header();

get_template_part('templates/parts/home-page/inc', 'hero');
get_template_part('templates/parts/home-page/inc', 'partners');
get_template_part('templates/parts/home-page/inc', 'group-gallery');
get_template_part('templates/parts/home-page/inc', 'about');
get_template_part('templates/parts/home-page/inc', 'services');
get_template_part('templates/parts/home-page/inc', 'product');
get_template_part('templates/parts/home-page/inc', 'project');
get_template_part('templates/parts/home-page/inc', 'volunteer');
get_template_part('templates/parts/home-page/inc', 'contact');

get_footer();