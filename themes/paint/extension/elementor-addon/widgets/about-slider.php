<?php

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Paint_Elementor_About_Slider extends Widget_Base
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
        return 'paint-about-slider';
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
        return esc_html__('About slider', 'paint');
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
        return ['slider', 'about' ];
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
            'list_link',
            [
                'label'         =>  esc_html__( 'Link', 'paint' ),
                'type'          =>  Controls_Manager::URL,
                'label_block'   =>  true,
                'placeholder'   =>  esc_html__( 'https://your-link.com', 'paint' ),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
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

        $this->add_control(
            'responsive_active',
            [
                'label' => esc_html__( 'Sử dụng responsive', 'paint' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Có', 'paint' ),
                'label_off' => esc_html__( 'Không', 'paint' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'items',
            [
                'label'   => esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
                'min'     => 1,
                'max'     => 10,
                'step'    => 1,
                'condition' => [
                    'responsive_active' => '',
                ],
            ]
        );

        $this->add_control(
            'margin_item',
            [
                'label'   => esc_html__( 'Khoảng cách', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 24,
                'min'     => 0,
                'max'     => 100,
                'step'    => 1,
                'condition' => [
                    'responsive_active' => '',
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
                'condition' => [
                    'responsive_active' => 'yes',
                ],
            ]
        );

        // min width 1200
        $this->add_control(
            'min_width_1200',
            [
                'label'     => esc_html__( 'Min Width 1200px', 'paint' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_1200',
            [
                'label'   => esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 4,
                'min'     => 1,
                'max'     => 10,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'margin_item_1200',
            [
                'label'   => esc_html__( 'Khoảng cách', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 24,
                'min'     => 0,
                'max'     => 100,
                'step'    => 1,
            ]
        );

        // min width 992
        $this->add_control(
            'min_width_992',
            [
                'label'     => esc_html__( 'Min Width 992px', 'paint' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_992',
            [
                'label'   => esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 10,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'margin_item_992',
            [
                'label'   => esc_html__( 'Khoảng cách', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 24,
                'min'     => 0,
                'max'     => 100,
                'step'    => 1,
            ]
        );

        // min width 768
        $this->add_control(
            'min_width_768',
            [
                'label'     => esc_html__( 'Min Width 768px', 'paint' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_768',
            [
                'label'   => esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 10,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'margin_item_768',
            [
                'label'   => esc_html__( 'Khoảng cách', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 12,
                'min'     => 0,
                'max'     => 100,
                'step'    => 1,
            ]
        );

        // min width 576
        $this->add_control(
            'min_width_576',
            [
                'label'     => esc_html__( 'Min Width 576px', 'paint' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_576',
            [
                'label'   => esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 10,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'margin_item_576',
            [
                'label'   => esc_html__( 'Space Between Item', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 12,
                'min'     => 0,
                'max'     => 100,
                'step'    => 1,
            ]
        );

        // max width 575
        $this->add_control(
            'max_width_575',
            [
                'label'     => esc_html__( 'Max Width 575px', 'paint' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_575',
            [
                'label'   => esc_html__( 'Số lượng hiển thị', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
                'min'     => 1,
                'max'     => 10,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'margin_item_575',
            [
                'label'   => esc_html__( 'Khoảng cách', 'paint' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 12,
                'min'     => 0,
                'max'     => 100,
                'step'    => 1,
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

        // owl options
        if ( $settings['responsive_active'] ) {
            $owl_options = [
                'loop'       => ( 'yes' === $settings['loop'] ),
                'nav'        => $settings['navigation'] == 'both' || $settings['navigation'] == 'arrows',
                'dots'       => $settings['navigation'] == 'both' || $settings['navigation'] == 'dots',
                'autoplay'   => ( 'yes' === $settings['autoplay'] ),
                'responsive' => [
                    '0' => array(
                        'items'  => $settings['item_575'],
                        'margin' => $settings['margin_item_575']
                    ),

                    '576' => array(
                        'items'  => $settings['item_576'],
                        'margin' => $settings['margin_item_576']
                    ),

                    '768' => array(
                        'items' => $settings['item_768'],
                        'margin' => $settings['margin_item_768'],
                    ),

                    '992' => array(
                        'items' => $settings['item_992'],
                        'margin' => $settings['margin_item_992'],
                    ),

                    '1200' => array(
                        'items' => $settings['item_1200'],
                        'margin' => $settings['margin_item_1200'],
                    ),
                ],
            ];
        } else {
            $owl_options = [
                'loop'       => ( 'yes' === $settings['loop'] ),
                'nav'        => $settings['navigation'] == 'both' || $settings['navigation'] == 'arrows',
                'dots'       => $settings['navigation'] == 'both' || $settings['navigation'] == 'dots',
                'autoplay'   => ( 'yes' === $settings['autoplay'] ),
                'items' => $settings['items'],
                'margin' => $settings['margin_item'],
            ];
        }
    ?>
        <div class="element-about-slider">
            <div class="element-about-slider__warp owl-carousel owl-theme" data-owl-options='<?php echo wp_json_encode( $owl_options ); ?>'>
                <?php
                foreach ( $settings['list'] as $index => $item ) :
                    $imageId = $item['list_image']['id'];
                ?>
                    <div class="item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                        <div class="item__thumbnail">
                            <?php
                            if ( $imageId ) :
                                echo wp_get_attachment_image( $imageId, 'large' );
                            endif;
                            ?>
                        </div>

                        <div class="item__body">
                            <h3 class="title-box">
                                <?php
                                if ( ! empty( $item['list_link']['url'] ) ) :
                                    $link_key = 'link_' . $index;
                                    $this->add_link_attributes( $link_key, $item['list_link'] );
                                ?>
                                    <a class="link" <?php $this->print_render_attribute_string( $link_key ); ?>>
                                        <?php echo esc_html( $item['list_title'] ); ?>
                                    </a>
                                <?php
                                else:
                                    echo esc_html( $item['list_title'] );
                                endif;
                                ?>
                            </h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php
    }
}