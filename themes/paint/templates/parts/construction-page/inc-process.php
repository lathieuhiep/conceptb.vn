<?php
use ExtendSite\Admin\Fields\Pages\Construction\ProcessTab;

$data = paint_get_field_tab_data(ProcessTab::class);
$title = $data['title'] ?? '';
$image_id = $data['image'] ?? 0;
$video_url = $data['video_url'] ?? '';

if (empty($title) && empty($image_id)) {
  return;
}
?>

<section class="construction-process" id="construction-process">
  <div class="construction-container">
    <?php if (!empty($title)) : ?>
      <h2 class="construction-process__title">
        <?php echo esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <?php if (!empty($image_id)) : ?>
      <?php if (!empty($video_url)) : ?>
        <a class="construction-process__video" href="<?php echo esc_url($video_url); ?>" data-lity>
      <?php else : ?>
        <div class="construction-process__video">
      <?php endif; ?>

        <?php
        echo wp_get_attachment_image(
          $image_id,
          'full',
          false,
          [
            'class' => 'construction-process__image',
            'loading' => 'lazy',
          ]
        );
        ?>

        <?php if (!empty($video_url)) : ?>
          <span class="construction-process__play" aria-hidden="true">
            <i class="fa-solid fa-play"></i>
          </span>
        <?php endif; ?>

      <?php if (!empty($video_url)) : ?>
        </a>
      <?php else : ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
