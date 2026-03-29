<?php

use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Paint_Elementor_Slider extends Widget_Base {
    public function get_categories(): array {
        return array( 'my-theme' );
    }

    public function get_name(): string {
        return 'paint-slider';
    }

    public function get_title(): string {
        return esc_html__( 'Slider', 'paint' );
    }

    public function get_icon(): string {
        return 'eicon-slider-device';
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
        return ['slider', 'image' ];
    }

    protected function register_controls(): void {
        // layout
        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__( 'Bố cục', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Kiểu giao diện', 'paint' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1'  => esc_html__( 'Kiểu 1', 'paint' ),
                    'style-2'  => esc_html__( 'Kiểu 2', 'paint' ),
                ],
            ]
        );

        $this->end_controls_section();

        // list
        $this->start_controls_section(
            'list_section',
            [
                'label' => esc_html__( 'Danh sách ảnh', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'list_title', [
                'label' => esc_html__( 'Tiêu đề', 'paint' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Slider' , 'paint' ),
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
                    'url' => '#'
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
                        'list_title' => esc_html__( 'Slider #1', 'paint' ),
                    ],
                    [
                        'list_title' => esc_html__( 'Slider #2', 'paint' ),
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );

        $this->end_controls_section();

        // anchor link
        $this->start_controls_section(
            'anchor_link_section',
            [
                'label' => esc_html__( 'Điểm neo', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'style' => 'style-2',
                ],
            ]
        );

        $this->add_control(
            'anchor_link_1',
            [
                'label'     => esc_html__( 'Điểm neo 1', 'paint' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'url_anchor_link_1', [
                'label' => esc_html__( 'Url', 'paint' ),
                'type' => Controls_Manager::TEXT,
                'default' => '#',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'text_anchor_link_1', [
                'label' => esc_html__( 'Văn bản', 'paint' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Quy trình thi công', 'paint'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'anchor_link_2',
            [
                'label'     => esc_html__( 'Điểm neo 2', 'paint' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'url_anchor_link_2', [
                'label' => esc_html__( 'Url', 'paint' ),
                'type' => Controls_Manager::TEXT,
                'default' => '#',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'text_anchor_link_2', [
                'label' => esc_html__( 'Văn bản', 'paint' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Xem báo giá', 'paint'),
                'label_block' => true,
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
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $list = $settings['list'];

        if ( empty( $list ) ) {
            return;
        }

	    $owl_options = [
            'items' => 1,
            'autoHeight' => true,
            'loop' => ('yes' === $settings['loop']),
            'nav' => $settings['navigation'] == 'both' || $settings['navigation'] == 'arrows',
            'dots' => $settings['navigation'] == 'both' || $settings['navigation'] == 'dots',
            'autoplay' => ('yes' === $settings['autoplay'])
	    ];
    ?>

        <div class="element-slider">
            <div class="element-slider__warp owl-carousel owl-theme" data-owl-options='<?php echo wp_json_encode( $owl_options ); ?>'>
                <?php
                foreach ( $list as $index => $item ):
                    $imageId = $item['list_image']['id'];
                    $url = $item['list_link']['url'];
                ?>
                    <div class="item">
                        <?php echo wp_get_attachment_image( $imageId, 'full' ); ?>

                        <?php
                        if ( $settings['style'] == 'style-1' && !empty( $url ) ) :
                            $link_key = 'link_' . $index;
                            $this->add_link_attributes( $link_key, $item['list_link'] );
                        ?>
                            <a class="link btn-global" <?php $this->print_render_attribute_string( $link_key ); ?>>
                                <?php echo esc_html( $item['list_title'] ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ( $settings['style'] == 'style-2' ) : ?>
                <div class="action-anchor-link">
                    <?php if ( $settings['url_anchor_link_1'] ) : ?>
                        <a class="btn-global" href="<?php echo esc_attr( $settings['url_anchor_link_1'] ) ?>">
                            <?php echo esc_html( $settings['text_anchor_link_1'] ); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ( $settings['url_anchor_link_2'] ) : ?>
                        <a class="btn-global" href="<?php echo esc_attr( $settings['url_anchor_link_2'] ) ?>">
                            <?php echo esc_html( $settings['text_anchor_link_2'] ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    <?php
    }
}