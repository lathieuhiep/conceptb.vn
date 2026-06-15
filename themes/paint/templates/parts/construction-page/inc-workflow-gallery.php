<?php
use ExtendSite\Admin\Fields\Pages\Construction\WorkflowGalleryTab;

$data = paint_get_field_tab_data(WorkflowGalleryTab::class);
$title = $data['title'] ?? '';
$feature_image = $data['feature_image'] ?? 0;
$images = $data['images'] ?? [];
$gallery_images = is_array($images) ? array_values(array_filter($images)) : [];

if ($title === '' && empty($feature_image) && empty($gallery_images)) {
  return;
}
?>

<section class="construction-workflow-gallery">
  <div class="construction-container">
    <?php if ($title !== '') : ?>
      <h2 class="construction-workflow-gallery__title">
        <?php echo esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <?php if (!empty($feature_image) || !empty($gallery_images)) : ?>
      <div class="construction-workflow-gallery__layout">
        <?php if (!empty($feature_image)) : ?>
          <figure class="construction-workflow-gallery__feature">
            <?php
            echo wp_get_attachment_image(
              $feature_image,
              'full',
              false,
              [
                'class' => 'construction-workflow-gallery__image',
                'loading' => 'lazy',
              ]
            );
            ?>
          </figure>
        <?php endif; ?>

        <?php if (!empty($gallery_images)) : ?>
          <div class="construction-workflow-gallery__grid">
            <?php foreach ($gallery_images as $image_id) : ?>
              <?php
              if (empty($image_id)) {
                continue;
              }
              ?>
              <figure class="construction-workflow-gallery__item">
                <?php
                echo wp_get_attachment_image(
                  $image_id,
                  'full',
                  false,
                  [
                    'class' => 'construction-workflow-gallery__image',
                    'loading' => 'lazy',
                  ]
                );
                ?>
              </figure>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
