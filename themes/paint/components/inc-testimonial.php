<?php
$opt_heading = paint_get_option('template_home_opt_testimonial_heading', '');
$opt_customers = paint_get_option('template_home_opt_testimonial_customers', '');

$data_settings_owl = [
  'infinite' => true,
  'slidesToShow' => 3,
  'slidesToScroll' => 1,
  'arrows' => false,
  'autoplay' => true,
  'responsive' => [
    [
      'breakpoint' => 767,
      'settings' => [
        'slidesToShow' => 2,
      ]
    ],
    [
      'breakpoint' => 575,
      'settings' => [
        'slidesToShow' => 1,
      ]
    ],
  ],
];
?>

<div class="element-testimonial">
  <?php if (!empty($opt_heading)) : ?>
    <h2 class="heading text-<?php echo esc_attr($opt_heading['align']); ?>">
      <?php echo esc_html($opt_heading['title']); ?>
    </h2>
  <?php
  endif;

  if (!empty($opt_customers)) :
    ?>
    <div class="custom-slick-carousel" data-config-slick='<?php echo wp_json_encode($data_settings_owl); ?>'>
      <?php
      foreach ($opt_customers as $item) :
        $imageId = $item['image']['id'];
        ?>

        <div class="item text-center">
          <div class="item__image">
            <?php echo wp_get_attachment_image($imageId, 'full'); ?>
          </div>

          <div class="start">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>

          <h4 class="name">
            <?php echo esc_html($item['name']); ?>
          </h4>

          <p class="content">
            <?php echo esc_textarea($item['content']) ?>
          </p>
        </div>

      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
