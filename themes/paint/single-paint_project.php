<?php
get_header();

global $current_user;
$user_id = $current_user->id;

$dataUserSave = paint_get_user_saved($user_id, get_the_ID());

// get metabox
$banner = get_post_meta(get_the_ID(), 'paint_cmb_project_banner_id', true);
$gallery = get_post_meta(get_the_ID(), 'paint_cmb_project_gallery', true);
$model = get_post_meta(get_the_ID(), 'paint_cmb_project_model', true);
$mass = get_post_meta(get_the_ID(), 'paint_cmb_project_mass', true);
$completion_time = get_post_meta(get_the_ID(), 'paint_cmb_project_completion_time', true);
$completion_construction = get_post_meta(get_the_ID(), 'paint_cmb_project_construction', true);

$config_feature = [
    'infinite' => true,
    'slidesToShow' => 1,
    'slidesToScroll' => 1,
    'arrows' => false,
    'fade' => true,
    'asNavFor' => '.slider-nav',
    'adaptiveHeight' => true
];

$config_nav_thumbnail = [
    'infinite' => true,
    'slidesToShow' => 5,
    'slidesToScroll' => 1,
    'arrows' => false,
    'asNavFor' => '.slider-for',
    'focusOnSelect' => true,
    'responsive' => [
        [
            'breakpoint' => 767,
            'settings' => [
                'slidesToShow' => 4,
            ]
        ],
        [
            'breakpoint' => 575,
            'settings' => [
                'slidesToShow' => 3,
            ]
        ],
    ],
];
?>

    <div class="site-container site-single-project">
        <div class="container">
            <div class="grid">
                <?php
                get_template_part('template-parts/project/inc', 'search-cat');

                while (have_posts()) : the_post();
                    $terms = get_the_terms(get_the_ID(), 'paint_project_cat');
                    ?>
                    <div class="banner">
                        <?php echo wp_get_attachment_image($banner, 'full') ?>

                        <div class="info d-flex align-items-center justify-content-center flex-column">
                            <p class="sub-text">
                                <?php esc_html_e('DỰ ÁN CÔNG TRÌNH', 'paint'); ?>
                            </p>

                            <h1 class="title">
                                <?php the_title() ?>
                            </h1>

                            <?php if ($terms) : ?>
                                <div class="tax">
                                    <?php foreach ($terms as $term) : ?>
                                        <a href="<?php echo esc_url(get_term_link($term->slug, 'paint_project_cat')); ?>">
                                            <?php echo esc_html($term->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="entry-content">
                        <div class="post-image">
                            <div class="post-image__feature custom-slick-carousel slider-for"
                                 data-config-slick='<?php echo wp_json_encode($config_feature); ?>'>
                                <div class="item">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>

                                <?php foreach ($gallery as $key => $item) : ?>
                                    <div class="item">
                                        <?php echo wp_get_attachment_image($key, 'large') ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="post-image__gallery custom-slick-carousel slider-nav"
                                 data-config-slick='<?php echo wp_json_encode($config_nav_thumbnail); ?>'>
                                <div class="item">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </div>

                                <?php foreach ($gallery as $key => $item) : ?>
                                    <div class="item">
                                        <?php echo wp_get_attachment_image($key) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="post-content">
                            <div id="customScrollbar" class="post-content__warp">
                                <div class="heading-box">
                                    <h3 class="post-content__heading">
                                        <?php esc_html_e('Tổng quan dự án', 'paint'); ?>
                                    </h3>

                                    <?php if ($user_id) : ?>
                                        <button type="button" class="btn-user-save border-0 p-0"
                                                data-post-id="<?php echo esc_attr(get_the_ID()) ?>">
                                            <?php if ($dataUserSave && $dataUserSave->status == 1) : ?>
                                                <i class="fa-solid fa-bookmark"></i>
                                            <?php else: ?>
                                                <i class="fa-regular fa-bookmark"></i>
                                            <?php endif; ?>
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="post-content__desc">
                                    <?php the_content(); ?>
                                </div>

                                <h3 class="post-content__heading">
                                    <?php esc_html_e('Thông tin kỹ thuât', 'paint'); ?>
                                </h3>

                                <ul class="post-content__info">
                                    <li class="model">
                                        <span class="txt-label"><?php esc_html_e('Loại sơn:', 'paint'); ?></span>
                                        <span class="txt-value"><?php echo esc_html($model); ?></span>
                                    </li>

                                    <li class="mass">
                                        <span class="txt-label"><?php esc_html_e('Khối lượng:', 'paint'); ?></span>
                                        <span class="txt-value"><?php echo esc_html($mass); ?></span>
                                    </li>

                                    <li class="completion-time">
                                        <span class="txt-label"><?php esc_html_e('Thời gian hoàn thành:', 'paint'); ?></span>
                                        <span class="txt-value"><?php echo esc_html($completion_time); ?></span>
                                    </li>

                                    <?php if ($completion_construction) : ?>
                                        <li class="completion-construction">
                                            <span class="txt-value"><?php echo esc_html($completion_construction); ?></span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <?php get_template_part('template-parts/project/inc', 'related-project'); ?>
        </div>
    </div>
<?php
get_footer();