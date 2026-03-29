<?php
$url_product = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_url', true);
$price = get_post_meta(get_the_ID(), 'paint_cmb_tool_specifications_price', true);
?>

<div class="item">
  <div class="item__thumbnail">
    <a class="icon-image" href="<?php echo esc_url($url_product); ?>" target="_blank">
      <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/icon-shopee.png')); ?>" alt="shopee">
    </a>

    <a class="image-box" href="<?php the_permalink(); ?>">
      <?php the_post_thumbnail('medium_large'); ?>
    </a>
  </div>

  <div class="item__info<?php echo esc_attr(has_term('', 'paint_tool_tag') ? ' align-items-center' : ''); ?>">
    <div class="left-box">
      <h2 class="title">
        <a href="<?php the_permalink(); ?>" title="<?php the_title() ?>">
          <?php the_title(); ?>
        </a>
      </h2>

      <?php if (has_term('', 'paint_tool_tag')) : ?>
        <div class="meta">
          <?php the_terms(get_the_ID(), 'paint_tool_tag', '', ', '); ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="right-box">
      <span class="price"><?php echo esc_html(number_format($price, 0, '', '.')); ?></span>
      <span class="currency">đ</span>
    </div>
  </div>
</div>