<?php

use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Paint_Elementor_Count_Up extends Widget_Base {
    public function get_categories(): array {
        return array( 'my-theme' );
    }

    public function get_name(): string {
        return 'paint-count-up';
    }

    public function get_title(): string {
        return esc_html__( 'Đếm tăng dần', 'paint' );
    }

    public function get_icon(): string {
        return 'eicon-counter';
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
        return ['count' ];
    }

    protected function register_controls(): void {

        // Content testimonial
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Nội dung', 'paint' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'       => esc_html__( 'Tiêu đề chính', 'paint' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Tiêu đề chính', 'paint' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'sub_heading',
            [
                'label'       => esc_html__( 'Tiêu đề phụ', 'paint' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Tiêu đề phụ', 'paint' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'number_active',
            [
                'label' => esc_html__( 'Sử dụng số', 'paint' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Có', 'paint' ),
                'label_off' => esc_html__( 'Không', 'paint' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__( 'Nhập số', 'textdomain' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 9999,
                'step' => 1,
                'default' => 1000,
                'condition' => [
                    'number_active' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'text',
            [
                'label'       => esc_html__( 'Văn bản phụ trợ', 'paint' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Văn bản phụ trợ', 'paint' ),
                'label_block' => true,
                'condition' => [
                    'number_active' => '',
                ],
            ]
        );

        $this->add_control(
            'desc',
            [
                'label'     =>  esc_html__( 'Mô tả', 'paint' ),
                'type'      =>  Controls_Manager::WYSIWYG,
                'default'   =>  esc_html__( 'Mổ tả', 'paint' ),
            ]
        );

        $this->end_controls_section();

        // heading style
        $this->start_controls_section(
            'heading_style_section',
            [
                'label' => esc_html__( 'Tiêu đề', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     =>  esc_html__( 'Màu chữ', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-count-up .heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-count-up .heading',
            ]
        );

        $this->end_controls_section();

        // sub heading style
        $this->start_controls_section(
            'sub_heading_style_section',
            [
                'label' => esc_html__( 'Tiêu đề phụ', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sub_heading_color',
            [
                'label'     =>  esc_html__( 'Màu chữ', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-count-up .sub-heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_heading_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-count-up .sub-heading',
            ]
        );

        $this->end_controls_section();

        // number or text style
        $this->start_controls_section(
            'number_or_text_style_section',
            [
                'label' => esc_html__( 'Số hoặc văn bản phụ trợ', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_or_text_color',
            [
                'label'     =>  esc_html__( 'Màu chữ', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-count-up .txt' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_or_text_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-count-up .txt',
            ]
        );

        $this->end_controls_section();

        // desc style
        $this->start_controls_section(
            'desc_style_section',
            [
                'label' => esc_html__( 'Nội dung', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     =>  esc_html__( 'Màu chữ', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-count-up .desc' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-count-up .desc',
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
    ?>
        <div class="element-count-up">
            <h3 class="heading">
                <?php echo esc_html( $settings['heading'] ); ?>
            </h3>

            <p class="sub-heading">
                <?php echo esc_html( $settings['sub_heading'] ); ?>
            </p>

            <?php if ( $settings['number_active'] ) : ?>
                <div class="txt number-box">
                    <span class="count-box" data-number="<?php echo esc_attr( $settings['number'] ); ?>">0</span>
                    <span class="symbol">+</span>
                </div>
            <?php else: ?>
                <div class="txt">
                    <?php echo esc_html( $settings['text'] ); ?>
                </div>
            <?php endif; ?>

            <div class="desc">
                <?php echo wpautop( $settings['desc'] ); ?>
            </div>
        </div>
    <?php
    }
}