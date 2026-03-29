<?php

use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Paint_Elementor_Introduce extends Widget_Base {
    public function get_categories(): array {
        return array( 'my-theme' );
    }

    public function get_name(): string {
        return 'paint-introduce';
    }

    public function get_title(): string {
        return esc_html__( 'Giới thiệu', 'paint' );
    }

    public function get_icon(): string {
        return 'eicon-post-list';
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
        return ['introduce', 'text', 'image', 'grid' ];
    }

    protected function register_controls(): void {

        // Content
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
            'image',
            [
                'label' => esc_html__( 'Ảnh', 'paint' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
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

        // content box style
        $this->start_controls_section(
            'content_box_style_section',
            [
                'label' => esc_html__( 'Vùng chứa nội dung', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_box_background_color',
            [
                'label' => esc_html__( 'Màu nền', 'paint' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-introduce .body-box__warp' => 'background-color: {{VALUE}}',
                ],
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
                    '{{WRAPPER}} .element-introduce .heading span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label'     =>  esc_html__( 'Màu gạch chân', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-introduce .heading span' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-introduce .heading span',
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
                    '{{WRAPPER}} .element-introduce .sub-heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_heading_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-introduce .sub-heading',
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
                    '{{WRAPPER}} .element-introduce .desc' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-introduce .desc',
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="element-introduce">
            <div class="thumbnail-box">
                <?php echo wp_get_attachment_image( $settings['image']['id'], 'large' ); ?>
            </div>

            <div class="body-box">
                <div class="body-box__warp">
                    <h3 class="heading">
                        <span class="heading__txt"><?php echo esc_html( $settings['heading'] ); ?></span>
                    </h3>

                    <p class="sub-heading">
                        <?php echo esc_html( $settings['sub_heading'] ); ?>
                    </p>

                    <div class="desc">
                        <?php echo wpautop( $settings['desc'] ); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}