<?php
/*
 Template Name: Contact Page
 */

get_header();
?>

<div class="site-container site-contact-warp">
  <div class="container">
    <div class="top text-center">
      <h1 class="top__title">
        <?php echo get_the_title(); ?>
      </h1>

      <p class="top__heading text">
        <?php esc_html_e('Qúy khách vui lòng để lại thông tin để BColor liên hệ tư vấn miễn phí!', 'paint'); ?>
      </p>
    </div>

    <div class="entry-content">
      <?php while (have_posts()) : the_post();
        the_content();
      endwhile;
      ?>
    </div>
  </div>
</div>

<?php
get_footer();