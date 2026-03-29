<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Paint_Elementor_Discover_Grid extends Widget_Base {

    public function get_categories(): array {
        return array( 'my-theme' );
    }

    public function get_name(): string {
        return 'paint-discover-carousel';
    }

    public function get_title(): string {
        return esc_html__( 'Danh sách khám phá', 'paint' );
    }

    public function get_icon(): string {
        return 'eicon-gallery-grid';
    }

    protected function register_controls(): void {

        // layout section
        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__( 'Layout', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label' => esc_html__( 'Cột', 'paint' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'step' => 1,
                'default' => 5,
                'selectors' => [
                    '{{WRAPPER}} .element-discover-grid__warp' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_column_gap',
            [
                'label' => esc_html__( 'Grid column gap', 'paint' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-discover-grid__warp' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_row_gap',
            [
                'label' => esc_html__( 'Grid row gap', 'paint' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-discover-grid__warp' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // query section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Query', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'select_cat',
            [
                'label'         =>  esc_html__( 'Chọn danh mục', 'paint' ),
                'type'          =>  Controls_Manager::SELECT2,
                'options'       =>  paint_check_get_cat( 'paint_discover_cat' ),
                'multiple'      =>  true,
                'label_block'   =>  true
            ]
        );

        $this->add_control(
            'limit',
            [
                'label'     =>  esc_html__( 'Số lượng bài viết', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  6,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label'     =>  esc_html__( 'Sắp xếp theo', 'paint' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'   =>  'id',
                'options'   =>  [
                    'id'    =>  esc_html__( 'ID', 'paint' ),
                    'title' =>  esc_html__( 'Title', 'paint' ),
                    'date'  =>  esc_html__( 'Date', 'paint' ),
                    'rand'  =>  esc_html__( 'Random', 'paint' ),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     =>  esc_html__( 'Sắp xếp', 'paint' ),
                'type'      =>  Controls_Manager::SELECT,
                'default'   =>  'DESC',
                'options'   =>  [
                    'ASC'   =>  esc_html__( 'Tăng dần', 'paint' ),
                    'DESC'  =>  esc_html__( 'Giảm dần', 'paint' ),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings       =   $this->get_settings_for_display();
        $cat_post       =   $settings['select_cat'];
        $limit_post     =   $settings['limit'];
        $order_by_post  =   $settings['order_by'];
        $order_post     =   $settings['order'];

        // Query
        $tax_query = [];

        if ( $cat_post ) {
            $tax_query[] = array(
                'taxonomy' => 'paint_discover_cat',
                'field' => 'term_id',
                'terms' => $cat_post
            );
        }

        $args = array(
            'post_type' => 'paint_discover',
            'posts_per_page' => $limit_post,
            'orderby' => $order_by_post,
            'order' => $order_post,
            'ignore_sticky_posts' => 1,
            'tax_query' => $tax_query
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) :
    ?>
        <div class="element-discover-grid">
            <div class="element-discover-grid__warp">
                <?php
                while ( $query->have_posts() ):
                    $query->the_post();
                ?>
                    <div class="item">
                        <a class="link" href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large'); ?>
                        </a>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    <?php
        endif;
    }
}