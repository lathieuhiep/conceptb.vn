<?php
/*
 Template Name: FAQs Page
 */

use ExtendSite\Admin\Fields\Pages\Faq\GeneralTab;

get_header();

$faq_header = paint_get_field_tab_data(GeneralTab::class);
$faq_title = $faq_header['title'] ?? 'FAQs';
$faq_subtitle = $faq_header['subtitle'] ?? '';
$faq_terms = get_terms([
  'taxonomy' => paint_get_faq_taxonomy(),
  'hide_empty' => true,
]);

$faq_response = paint_get_faq_response();
?>

  <main class="site-container faq-wrap" data-faq-page>
    <div class="container">
      <header class="faq-hero text-center">
        <h1 class="faq-hero__title">
          <?php echo esc_html($faq_title); ?>
        </h1>

        <?php if (!empty($faq_subtitle)) : ?>
          <p class="faq-hero__desc">
            <?php echo esc_html($faq_subtitle); ?>
          </p>
        <?php endif; ?>

        <div class="faq-search">
          <label class="screen-reader-text" for="faq-search-input">
            <?php esc_html_e('Tìm kiếm câu hỏi', 'paint'); ?>
          </label>

          <i class="faq-search__icon fa-solid fa-magnifying-glass" aria-hidden="true"></i>
          <input id="faq-search-input" class="faq-search__input" type="search" placeholder="<?php esc_attr_e('Nhập câu hỏi...', 'paint'); ?>" autocomplete="off" data-faq-search>
          <div class="faq-search__dropdown" data-faq-suggestions hidden></div>
        </div>

        <div class="faq-filters" data-faq-filters>
          <button class="faq-filter is-active" type="button" data-term-id="0">
            <span class="faq-filter__label"><?php esc_html_e('Tất cả', 'paint'); ?></span>
            <span class="faq-filter__count" data-filter-count hidden></span>
          </button>

          <?php if (!empty($faq_terms) && !is_wp_error($faq_terms)) : ?>
            <?php foreach ($faq_terms as $term) : ?>
              <button class="faq-filter" type="button" data-term-id="<?php echo esc_attr($term->term_id); ?>">
                <span class="faq-filter__label"><?php echo esc_html($term->name); ?></span>
                <span class="faq-filter__count" data-filter-count hidden></span>
              </button>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </header>

      <section class="faq-panel" aria-live="polite" aria-busy="false" data-faq-results>
        <div class="faq-panel__head">
          <span data-faq-section-title><?php echo esc_html($faq_response['section_title']); ?></span>
        </div>

        <div class="faq-loading" data-faq-loading hidden>
          <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
          <span><?php esc_html_e('Đang tìm kiếm...', 'paint'); ?></span>
        </div>

        <div class="faq-list" id="faq-list" data-faq-list>
          <?php echo $faq_response['items_html']; ?>
        </div>
      </section>
    </div>
  </main>

<?php
get_footer();
