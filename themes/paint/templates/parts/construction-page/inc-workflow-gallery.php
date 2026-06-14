<?php
use ExtendSite\Admin\Fields\Pages\Construction\WorkflowGalleryTab;

$data = paint_get_field_tab_data(WorkflowGalleryTab::class);
$title = $data['title'] ?? '';
$images = $data['images'] ?? [];

if ($title === '' && empty($images)) {
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

    <?php if (!empty($images)) : ?>
      <div class="construction-workflow-gallery__grid">
        <?php foreach ($images as $index => $image_id) : ?>
          <?php
          if (empty($image_id)) {
            continue;
          }
          ?>
          <figure class="construction-workflow-gallery__item<?php echo $index === 0 ? ' construction-workflow-gallery__item--large' : ''; ?>">
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
</section>
