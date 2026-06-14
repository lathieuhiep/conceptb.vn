<?php
use ExtendSite\Admin\Fields\Pages\Construction\WhyChooseTab;

$data = paint_get_field_tab_data(WhyChooseTab::class);
$title = $data['title'] ?? '';
$feature_group_title = $data['feature_group_title'] ?? '';
$features = $data['features'] ?? [];
$commitments = $data['commitments'] ?? [];

if ($title === '' && $feature_group_title === '' && empty($features) && empty($commitments)) {
  return;
}
?>

<section class="construction-why-choose">
  <div class="construction-container">
    <?php if ($title !== '') : ?>
      <h2 class="construction-why-choose__title">
        <?php echo esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <?php if ($feature_group_title !== '' || !empty($features)) : ?>
      <div class="construction-why-choose__features">
        <?php if ($feature_group_title !== '') : ?>
          <h3 class="construction-why-choose__group-title">
            <?php echo esc_html($feature_group_title); ?>
          </h3>
        <?php endif; ?>

        <?php if (!empty($features)) : ?>
          <div class="construction-why-choose__feature-list">
            <?php foreach ($features as $feature) : ?>
              <?php
              $feature_image_id = $feature['image'] ?? 0;
              $feature_title = $feature['title'] ?? '';
              $feature_description = $feature['description'] ?? '';

              if (empty($feature_image_id) && $feature_title === '' && $feature_description === '') {
                continue;
              }
              ?>
              <article class="construction-feature-card">
                <?php if (!empty($feature_image_id)) : ?>
                  <figure class="construction-feature-card__image">
                    <?php
                    echo wp_get_attachment_image(
                      $feature_image_id,
                      'full',
                      false,
                      [
                        'class' => 'construction-feature-card__img',
                        'loading' => 'lazy',
                      ]
                    );
                    ?>
                  </figure>
                <?php endif; ?>

                <div class="construction-feature-card__body">
                  <?php if ($feature_title !== '') : ?>
                    <h4 class="construction-feature-card__title">
                      <?php echo esc_html($feature_title); ?>
                    </h4>
                  <?php endif; ?>

                  <?php if ($feature_description !== '') : ?>
                    <div class="construction-feature-card__desc">
                      <?php echo wp_kses_post(wpautop($feature_description)); ?>
                    </div>
                  <?php endif; ?>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($commitments)) : ?>
      <div class="construction-why-choose__commitment-list">
        <?php foreach ($commitments as $commitment) : ?>
          <?php
          $commitment_image_id = $commitment['image'] ?? 0;
          $commitment_title = $commitment['title'] ?? '';
          $commitment_description = $commitment['description'] ?? '';

          if (empty($commitment_image_id) && $commitment_title === '' && $commitment_description === '') {
            continue;
          }
          ?>
          <article class="construction-commitment-card">
            <?php if ($commitment_title !== '') : ?>
              <h3 class="construction-commitment-card__title">
                <?php echo esc_html($commitment_title); ?>
              </h3>
            <?php endif; ?>

            <?php if (!empty($commitment_image_id)) : ?>
              <figure class="construction-commitment-card__image">
                <?php
                echo wp_get_attachment_image(
                  $commitment_image_id,
                  'full',
                  false,
                  [
                    'class' => 'construction-commitment-card__img',
                    'loading' => 'lazy',
                  ]
                );
                ?>
              </figure>
            <?php endif; ?>

            <?php if ($commitment_description !== '') : ?>
              <div class="construction-commitment-card__desc">
                <?php echo wp_kses_post(wpautop($commitment_description)); ?>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
