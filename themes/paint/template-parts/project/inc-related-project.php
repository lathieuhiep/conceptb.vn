<?php
// config slider
$data_config_slider = [
    'infinite' => true,
    'slidesToShow' => 3,
    'arrows' => false,
    'autoplay' => true,
    'dots' => false,
    'responsive' => [
        [
            'breakpoint' => 1023,
            'settings' => [
                'slidesToShow' => 3,
            ]
        ],
        [
            'breakpoint' => 767,
            'settings' => [
                'slidesToShow' => 2,
            ]
        ],
        [
            'breakpoint' => 479,
            'settings' => [
                'slidesToShow' => 1,
            ]
        ],
    ],
];

$term_ids = wp_get_post_terms(get_the_ID(), 'paint_project_cat', array('fields' => 'ids'));

if (!empty($term_ids)) :
    $limit = 8;

    $arg = array(
        'post_type' => 'paint_project',
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => $limit,
        'orderby' => 'id',
        'order' => 'DESC',
        'ignore_sticky_posts' => 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'paint_project_cat',
                'field' => 'term_id',
                'terms' => $term_ids
            ),
        )
    );

    $query = new WP_Query($arg);

    if ($query->have_posts()) :
    ?>

        <div class="site-single-project-related">
            <h3 class="title text-center">
                <?php
                get_template_part('components/inc', 'heading-line', [
                    'title' => esc_html__('XEM THÊM DỰ ÁN', 'paint')
                ]);
                ?>
            </h3>

            <div class="project-layout custom-slick-carousel"
                 data-config-slick='<?php echo wp_json_encode($data_config_slider); ?>'>
                <?php
                while ($query->have_posts()): $query->the_post();
                    get_template_part('template-parts/project/inc', 'item');
                endwhile;
                ?>
            </div>

            <?php
            $link = get_term_link($term_ids[0], 'paint_project_cat');

            if ( $link ) :
            ?>
                <div class="action-box">
                    <a href="<?php echo esc_url( $link ); ?>" class="btn link-cate">
                        <?php esc_html_e('Xem toàn bộ Dự án', 'paint'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

    <?php
    endif;
endif;
