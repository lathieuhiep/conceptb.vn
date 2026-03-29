<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Paint_Elementor_Procedure_Carousel extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve oEmbed widget name.
     *
     * @access public
     * @return string Widget name.
     */
    public function get_name(): string
    {
        return 'paint-procedure-carousel';
    }

    /**
     * Get widget title.
     *
     * Retrieve oEmbed widget title.
     *
     * @access public
     * @return string Widget title.
     */
    public function get_title(): string
    {
        return esc_html__('Quy trình slider', 'paint');
    }

    /**
     * Get widget icon.
     *
     * Retrieve oEmbed widget icon.
     *
     * @access public
     * @return string Widget icon.
     */
    public function get_icon(): string
    {
        return 'eicon-slider-push';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the oEmbed widget belongs to.
     *
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords(): array
    {
        return ['slider', 'procedure' ];
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @access public
     * @return array Widget categories.
     */
    public function get_categories(): array
    {
        return ['my-theme'];
    }

    /**
     * Register oEmbed widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @access protected
     */
    protected function register_controls(): void
    {
        // list
        $this->start_controls_section(
            'list_section',
            [
                'label' => esc_html__( 'Danh sách', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'list_title', [
                'label' => esc_html__( 'Tiêu đề', 'paint' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'List Title' , 'paint' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_sub_title', [
                'label' => esc_html__( 'Tiêu đề phụ', 'paint' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_image',
            [
                'label' => esc_html__( 'Ảnh', 'paint' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'list_content', [
                'label' => esc_html__( 'Nội dung', 'paint' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Nội dung' , 'paint' ),
                'show_label' => false,
            ]
        );

        // title options
        $repeater->add_control(
            'list_title_options',
            [
                'label' => esc_html__( 'Tiêu đề', 'paint' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'list_show_gradient',
            [
                'label' => esc_html__( 'Dùng Gradient', 'paint' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'paint' ),
                'label_off' => esc_html__( 'Hide', 'paint' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $repeater->add_control(
            'list_title_color', [
                'label' => esc_html__( 'Màu tiêu đề', 'paint' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-procedure-carousel .procedure-slider-main {{CURRENT_ITEM}}.item .title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'list_show_gradient' => '',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'list_title_background',
                'types' => ['gradient' ],
                'selector' => '{{WRAPPER}} .element-procedure-carousel .procedure-slider-main {{CURRENT_ITEM}}.item .title',
                'condition' => [
                    'list_show_gradient' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Danh sách', 'paint' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => esc_html__( 'Tiêu đề #1', 'paint' ),
                    ],
                    [
                        'list_title' => esc_html__( 'Tiêu đề #2', 'paint' ),
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );

        $this->end_controls_section();

        // style title
        $this->start_controls_section(
            'style_title_section',
            [
                'label' => esc_html__( 'Tiêu đề', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'show_gradient',
            [
                'label' => esc_html__( 'Dùng Gradient', 'paint' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'paint' ),
                'label_off' => esc_html__( 'Hide', 'paint' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Màu', 'paint' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-procedure-carousel .procedure-slider-main .item .title' => 'color: {{VALUE}}'
                ],
                'condition' => [
                    'show_gradient' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .element-procedure-carousel .procedure-slider-main .item .title',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'title_background',
                'types' => ['gradient' ],
                'selector' => '{{WRAPPER}} .element-procedure-carousel .procedure-slider-main .item .title',
                'condition' => [
                    'show_gradient' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render(): void
    {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['list']) ) {
            return;
        }
    ?>
        <div class="element-procedure-carousel">
            <div class="grid-item">
                <div class="procedure-slider-main owl-carousel owl-theme">
                    <?php
                    foreach ( $settings['list'] as $index => $item ) :
                        $imageId = $item['list_image']['id'];

                        $class_gradient = $item['list_show_gradient'] || $settings['show_gradient'] == 'yes' ? ' show-gradient' : '';
                    ?>
                        <div class="item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>" data-index="<?php echo esc_html__( $index ); ?>">
                            <div class="item__thumbnail">
                                <?php
                                if ( $imageId ) :
                                    echo wp_get_attachment_image( $imageId, 'large' );
                                endif;
                                ?>
                            </div>

                            <div class="item__body">
                                <div class="top-box">
                                    <div class="top-box__inner">
                                        <h3 class="title<?php echo esc_attr( $class_gradient ); ?>">
                                            <?php echo esc_html( $item['list_title'] ); ?>
                                        </h3>

                                        <?php if ( $item['list_sub_title'] ) : ?>
                                            <p class="sub-title">
                                                <?php echo esc_html( $item['list_sub_title'] ); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="desc">
                                    <?php echo wpautop( $item['list_content'] ); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="grid-item d-flex flex-column">
                <div class="custom-nav">
                    <button class="prev-btn"><i class="fa-solid fa-arrow-left-long"></i></button>
                    <button class="next-btn"><i class="fa-solid fa-arrow-right-long"></i></button>
                </div>

                <div class="procedure-slider-number owl-carousel owl-theme flex-grow-1">
                    <?php foreach ( $settings['list'] as $index => $item ) : ?>
                    <div class="item thumb" data-index="<?php echo esc_html__( $index ); ?>">
                        <span class="number"><?php echo esc_html( addZeroBeforeNumber( $index + 1 ) ); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }
}