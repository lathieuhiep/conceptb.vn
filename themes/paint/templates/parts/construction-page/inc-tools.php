<?php
use ExtendSite\Admin\Fields\Pages\Construction\ToolsTab;

$data = paint_get_field_tab_data(ToolsTab::class);
$title = $data['title'] ?? '';
$recommended_title = $data['recommended_title'] ?? '';
$recommended_tool_ids = $data['recommended_tool_ids'] ?? [];
$other_title = $data['other_title'] ?? '';
$other_tool_ids = $data['other_tool_ids'] ?? [];

if (empty($recommended_tool_ids) && empty($other_tool_ids)) {
  return;
}

$get_tools_query = static function (array $ids): ?WP_Query {
  if (empty($ids)) {
    return null;
  }

  $query = new WP_Query([
    'post_type' => 'paint_tool',
    'post__in' => $ids,
    'posts_per_page' => count($ids),
    'orderby' => 'post__in',
    'ignore_sticky_posts' => 1,
  ]);

  return $query->have_posts() ? $query : null;
};

$recommended_query = $get_tools_query($recommended_tool_ids);
$other_query = $get_tools_query($other_tool_ids);

if (!$recommended_query && !$other_query) {
  return;
}
?>

<section class="construction-tools" id="construction-tools">
  <div class="construction-container">
    <?php if ($title !== '') : ?>
      <h2 class="construction-tools__title">
        <?php echo esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <?php if ($recommended_query instanceof WP_Query) : ?>
    <div class="construction-tools__recommended">
      <?php if ($recommended_title !== '') : ?>
        <h3 class="construction-tools__group-title">
          <?php echo esc_html($recommended_title); ?>
        </h3>
      <?php endif; ?>

      <div class="construction-tools__slider" data-construction-tools-slider>
        <div class="construction-tools__swiper swiper" data-construction-tools-swiper>
          <div class="swiper-wrapper">
            <?php while ($recommended_query->have_posts()) : ?>
              <?php
              $recommended_query->the_post();
              $description = has_excerpt()
                ? get_the_excerpt()
                : wp_trim_words(wp_strip_all_tags(get_the_content()), 80, '...');
              ?>
              <div class="construction-tools__slide swiper-slide">
                <article class="construction-tools__recommended-card">
                  <a class="construction-tools__recommended-image" href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                      <?php the_post_thumbnail('large', ['class' => 'construction-tools__image']); ?>
                    <?php endif; ?>
                  </a>

                  <div class="construction-tools__recommended-content">
                    <h4 class="construction-tools__recommended-name">
                      <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                      </a>
                    </h4>

                    <?php if ($description !== '') : ?>
                      <div class="construction-tools__recommended-desc">
                        <?php echo esc_html($description); ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </article>
              </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
          </div>
        </div>

        <button class="construction-tools__nav construction-tools__nav--prev" type="button" aria-label="<?php esc_attr_e('Previous', 'paint'); ?>">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
        </button>
        <button class="construction-tools__nav construction-tools__nav--next" type="button" aria-label="<?php esc_attr_e('Next', 'paint'); ?>">
          <i class="fa fa-angle-right" aria-hidden="true"></i>
        </button>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($other_query instanceof WP_Query) : ?>
      <div class="construction-tools__other">
        <?php if ($other_title !== '') : ?>
          <h3 class="construction-tools__group-title">
            <?php echo esc_html($other_title); ?>
          </h3>
        <?php endif; ?>

        <div class="construction-tools__slider construction-tools__slider--other" data-construction-tools-slider data-slides-per-view="3">
          <div class="construction-tools__swiper swiper" data-construction-tools-swiper>
            <div class="swiper-wrapper">
              <?php while ($other_query->have_posts()) : ?>
                <?php $other_query->the_post(); ?>
                <div class="construction-tools__slide swiper-slide">
                  <article class="construction-tools__other-card">
                    <a class="construction-tools__other-image" href="<?php the_permalink(); ?>">
                      <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', ['class' => 'construction-tools__image']); ?>
                      <?php endif; ?>
                    </a>

                    <h4 class="construction-tools__other-name">
                      <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                      </a>
                    </h4>
                  </article>
                </div>
              <?php endwhile; ?>
              <?php wp_reset_postdata(); ?>
            </div>
          </div>

          <button class="construction-tools__nav construction-tools__nav--prev" type="button" aria-label="<?php esc_attr_e('Previous', 'paint'); ?>">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
          </button>
          <button class="construction-tools__nav construction-tools__nav--next" type="button" aria-label="<?php esc_attr_e('Next', 'paint'); ?>">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
