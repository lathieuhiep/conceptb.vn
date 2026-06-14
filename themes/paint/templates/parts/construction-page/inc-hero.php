<?php
use ExtendSite\Admin\Fields\Pages\Construction\HeroTab;

$data = paint_get_field_tab_data(HeroTab::class);
$hero_image_id = $data['image'] ?? 0;
?>

<section class="construction-hero">
  <?php if (!empty($hero_image_id)) : ?>
    <?php
    echo wp_get_attachment_image(
      $hero_image_id,
      'full',
      false,
      [
        'class' => 'construction-hero__image',
        'loading' => 'eager',
        'fetchpriority' => 'high',
      ]
    );
    ?>
  <?php else : ?>
    <div class="construction-hero__placeholder"></div>
  <?php endif; ?>
</section>
