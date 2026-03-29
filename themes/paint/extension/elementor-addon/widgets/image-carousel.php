<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Paint_Elementor_Image_Carousel extends Widget_Base
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
        return 'paint-image-carousel';
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
        return esc_html__('Slider Ảnh', 'paint');
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
        return ['slider', 'carousel' ];
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
        // content
        $this->start_controls_section(
            'slider_section',
            [
                'label' => esc_html__( 'Slider', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label' => esc_html__( 'Thêm ảnh', 'paint' ),
                'type' => Controls_Manager::GALLERY,
                'show_label' => false,
                'default' => [],
            ]
        );

        $this->end_controls_section();

        // carousel options
        $this->start_controls_section(
            'options_section',
            [
                'label' => esc_html__( 'Tùy chọn bổ sung', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'loop',
            [
                'type'          =>  Controls_Manager::SWITCHER,
                'label'         =>  esc_html__('Lặp lại vô hạn', 'paint'),
                'label_off'     =>  esc_html__('Không', 'paint'),
                'label_on'      =>  esc_html__('Có', 'paint'),
                'return_value'  =>  'yes',
                'default'       =>  'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         =>  esc_html__('Tự động chạy', 'paint'),
                'type'          =>  Controls_Manager::SWITCHER,
                'label_off'     =>  esc_html__('Không', 'paint'),
                'label_on'      =>  esc_html__('Có', 'paint'),
                'return_value'  =>  'yes',
                'default'       =>  'no',
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label' => esc_html__( 'Thanh điều hướng', 'paint' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'arrows',
                'options' => [
                    'both'  => esc_html__( 'Mũi tên và Dấu chấm', 'paint' ),
                    'arrows'  => esc_html__( 'Mũi tên', 'paint' ),
                    'dots'  => esc_html__( 'Dấu chấm', 'paint' ),
                    'none' => esc_html__( 'Không', 'paint' ),
                ],
            ]
        );

        $this->end_controls_section();

        // responsive
        $this->start_controls_section(
            'responsive_section',
            [
                'label' => esc_html__( 'Responsive', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'margin_item',
            [
                'label'     =>  esc_html__( 'Khoảng cách', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  24,
                'min'       =>  0,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        // greater 1200px
        $this->add_control(
            'min_width_1200',
            [
                'label'     =>  esc_html__( 'Độ rộng lớn hơn 1200px', 'paint' ),
                'type'      =>  Controls_Manager::HEADING,
                'separator' =>  'before',
            ]
        );

        $this->add_control(
            'item',
            [
                'label'     =>  esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  5,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        // greater 992px
        $this->add_control(
            'min_width_992',
            [
                'label'     =>  esc_html__( 'Độ rộng lớn hơn 992px', 'paint' ),
                'type'      =>  Controls_Manager::HEADING,
                'separator' =>  'before',
            ]
        );

        $this->add_control(
            'item_992',
            [
                'label'     =>  esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  3,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        // greater 768px
        $this->add_control(
            'min_width_768',
            [
                'label'     =>  esc_html__( 'Độ rộng lớn hơn 768px', 'paint' ),
                'type'      =>  Controls_Manager::HEADING,
                'separator' =>  'before',
            ]
        );

        $this->add_control(
            'margin_item_greater_768',
            [
                'label'     =>  esc_html__( 'Khoảng cách', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  24,
                'min'       =>  0,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'item_768',
            [
                'label'     =>  esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  2,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        // greater 576px
        $this->add_control(
            'width_greater_576',
            [
                'label'     =>  esc_html__( 'Độ rộng lớn hơn 576px', 'paint' ),
                'type'      =>  Controls_Manager::HEADING,
                'separator' =>  'before',
            ]
        );

        $this->add_control(
            'item_greater_576',
            [
                'label'     =>  esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  2,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'margin_item_greater_576',
            [
                'label'     =>  esc_html__( 'Khoảng cách', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  12,
                'min'       =>  0,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        // greater 480px
        $this->add_control(
            'width_greater_480',
            [
                'label'     =>  esc_html__( 'Độ rộng lớn hơn 480px', 'paint' ),
                'type'      =>  Controls_Manager::HEADING,
                'separator' =>  'before',
            ]
        );

        $this->add_control(
            'item_greater_480',
            [
                'label'     =>  esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  2,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'margin_item_greater_480',
            [
                'label'     =>  esc_html__( 'Khoảng cách', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  12,
                'min'       =>  0,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        // less 480px
        $this->add_control(
            'max_width_item_less_480',
            [
                'label'     =>  esc_html__( 'Nhỏ hơn 480px', 'paint' ),
                'type'      =>  Controls_Manager::HEADING,
                'separator' =>  'before',
            ]
        );

        $this->add_control(
            'item_less_480',
            [
                'label'     =>  esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  1,
                'min'       =>  1,
                'max'       =>  100,
                'step'      =>  1,
            ]
        );

        $this->add_control(
            'margin_item_less_480',
            [
                'label'     =>  esc_html__( 'Khoảng cách', 'paint' ),
                'type'      =>  Controls_Manager::NUMBER,
                'default'   =>  0,
                'min'       =>  0,
                'max'       =>  100,
                'step'      =>  1,
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

        if ( empty( $settings['gallery'] ) ) {
            return;
        }

        // owl options
        $owl_options = [
            'loop' => ('yes' === $settings['loop']),
            'nav' => $settings['navigation'] == 'both' || $settings['navigation'] == 'arrows',
            'dots' => $settings['navigation'] == 'both' || $settings['navigation'] == 'dots',
            'autoplay' => ('yes' === $settings['autoplay']),
            'margin' => $settings['margin_item'],
            'responsive' => [
                '0' => array(
                    'items' => $settings['item_less_480'],
                    'margin' => $settings['margin_item_less_480']
                ),
                '480' => array(
                    'items' => $settings['item_greater_480'],
                    'margin' => $settings['margin_item_greater_480']
                ),
                '576' => array(
                    'items' => $settings['item_greater_576'],
                    'margin' => $settings['margin_item_greater_576']
                ),
                '768' => array(
                    'items' => $settings['item_768'],
                    'margin' => $settings['margin_item_greater_768']
                ),
                '992' => array(
                    'items' => $settings['item_992']
                ),
                '1200' => array(
                    'items' => $settings['item']
                ),
            ],
        ];
    ?>
        <div class="element-image-carousel">
            <div class="element-image-carousel__warp custom-owl-carousel owl-carousel owl-theme" data-owl-options='<?php echo wp_json_encode( $owl_options ); ?>'>
                <?php foreach ( $settings['gallery'] as $image  ): ?>
                    <div class="item">
                        <?php echo wp_get_attachment_image( $image['id'], 'large' ); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}