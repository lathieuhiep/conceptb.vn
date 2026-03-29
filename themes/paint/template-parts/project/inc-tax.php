<?php
// config slider
$data_config_slider = [
    'infinite' => false,
    'slidesToShow' => 5,
    'slidesToScroll' => 1,
    'arrows' => true,
    'autoplay' => false,
    'variableWidth' => true,
    'responsive' => [
        [
            'breakpoint' => 1199,
            'settings' => [
                'slidesToShow' => 3
            ]
        ],
        [
            'breakpoint' => 767,
            'settings' => [
                'slidesToShow' => 2
            ]
        ],
        [
            'breakpoint' => 479,
            'settings' => [
                'slidesToShow' => 1
            ]
        ],
    ],
];

$term = [];

if (is_post_type_archive('paint_project')) {
    $title = get_the_archive_title();
} else {
    $term = get_queried_object();
    $title = $term->name;
}
?>
<div class="site-container site-project-cat">
    <div class="container">
        <h1 class="heading text-center text-uppercase">
            <?php echo esc_html($title); ?>
        </h1>

        <?php
        if (have_posts()) :
            $taxonomies = get_terms(array(
                'taxonomy' => 'paint_project_cat',
                'hide_empty' => false
            ));
            ?>
            <div class="action-tax-search">
                <div class="scroll-box">
                    <div class="list-cat custom-slick-carousel"
                         data-config-slick='<?php echo wp_json_encode($data_config_slider); ?>'>
                        <div class="list-cat__item<?php echo esc_attr(is_post_type_archive('paint_project') ? ' active' : ''); ?>">
                            <a href="<?php echo esc_url(get_post_type_archive_link('paint_project')); ?>">
                                <?php esc_html_e('Tất cả', 'paint'); ?>
                            </a>
                        </div>

                        <?php
                        if ($taxonomies) :
                            foreach ($taxonomies as $taxonomy):
                                ?>
                                <div class="list-cat__item<?php echo esc_attr(!empty($term) && $term->term_id == $taxonomy->term_id ? ' active' : ''); ?>">
                                    <a href="<?php echo esc_url(get_term_link($taxonomy->slug, 'paint_project_cat')); ?>"
                                       title="<?php echo esc_attr($taxonomy->name); ?>">
                                        <?php echo esc_html($taxonomy->name); ?>
                                    </a>
                                </div>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>

                <?php get_template_part('template-parts/project/inc', 'search'); ?>
            </div>

            <div class="project-grid project-layout">
                <?php
                while (have_posts()) : the_post();

                    get_template_part('template-parts/project/inc', 'item');

                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php
            paint_pagination();
        endif;
        ?>
    </div>
</div>