<?php
use ExtendSite\Admin\Fields\Product\ProductGalleryTab;

$idProduct = $args['idProduct'] ?? '';

if ($idProduct) :
  $gallery = class_exists(ProductGalleryTab::class) ? ProductGalleryTab::get_gallery((int) $idProduct) : [];

  if (!empty($gallery)) :
  ?>

    <div class="product-gallery-grid">
      <?php foreach ($gallery as $item) : ?>

        <figure class="item grid-sizer-<?php echo esc_attr($item['style']); ?>">
          <?php echo wp_get_attachment_image($item['image_id'], 'full'); ?>
        </figure>

      <?php endforeach; ?>
    </div>

  <?php
  endif;
endif;
