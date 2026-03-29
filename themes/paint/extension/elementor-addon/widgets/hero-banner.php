<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;

class Paint_Hero_Banner_Widget extends Widget_Base
{

    public function get_name(): string
    {
        return 'paint-hero-banner';
    }

    public function get_title(): string
    {
        return esc_html__('Hero Banner Bold', 'paint');
    }

    public function get_icon(): string
    {
        return 'eicon-banner';
    }

    public function get_categories(): array
    {
        return array('my-theme');
    }

    protected function register_controls(): void
    {

        // --- TAB: CONTENT ---
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Nội dung', 'paint'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hero_caption',
            [
                'label' => esc_html__('Dòng chú thích (Caption)', 'paint'),
                'type' => Controls_Manager::TEXT,
                'default' => 'CHỦ ĐỘNG NGUỒN LỰC',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'hero_headline',
            [
                'label' => esc_html__('Tiêu đề chính (Headline)', 'paint'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Bứt phá tiến độ',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'headline_tag',
            [
                'label' => esc_html__('Thẻ HTML Tiêu đề', 'paint'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'div' => 'div',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Chữ trên nút', 'paint'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Năng lực thi công',
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Liên kết nút', 'paint'),
                'type' => Controls_Manager::URL,
                'default' => ['url' => '#'],
            ]
        );

        $this->end_controls_section();

        // --- TAB: STYLE ---
        $this->start_controls_section(
            'section_style_general',
            [
                'label' => esc_html__('Tổng quan & Nền', 'paint'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hero_background',
                'label' => esc_html__('Ảnh nền', 'paint'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .element-hero-banner-main',
            ]
        );

        $this->add_responsive_control(
            'hero_height',
            [
                'label' => esc_html__('Chiều cao (vh)', 'paint'),
                'type' => Controls_Manager::SLIDER,
                'range' => ['vh' => ['min' => 30, 'max' => 100]],
                'default' => ['unit' => 'vh', 'size' => 80],
                'selectors' => [
                    '{{WRAPPER}} .element-hero-banner-main' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style cho Caption (Dòng chữ trắng)
        $this->start_controls_section(
            'section_style_caption',
            [
                'label' => esc_html__('Style Chú thích', 'paint'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'caption_color',
            [
                'label' => esc_html__('Màu chữ', 'paint'),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .hero-caption' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'caption_typography',
                'selector' => '{{WRAPPER}} .hero-caption',
            ]
        );

        $this->end_controls_section();

        // Style cho Headline (Dòng chữ vàng)
        $this->start_controls_section(
            'section_style_headline',
            [
                'label' => esc_html__('Style Tiêu đề chính', 'paint'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'headline_color',
            [
                'label' => esc_html__('Màu chữ', 'paint'),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .hero-headline' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'headline_typography',
                'selector' => '{{WRAPPER}} .hero-headline',
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();

        // Xử lý thuộc tính liên kết nút
        if ( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_link_attributes( 'button_link', $settings['button_link'] );
        }

        // Lấy thẻ HTML từ settings (default là h2)
        $headline_tag = $settings['headline_tag'] ?: 'h2';
        $caption_tag  = 'div';
        ?>

        <div class="element-hero-banner-main">
            <div class="container h-100 position-relative">
                <div class="hero-content h-100">
                    <div class="hero-content__top">
                        <?php
                        // Xử lý Caption
                        if (!empty($settings['hero_caption'])) {
                            printf(
                                '<%1$s class="hero-caption">%2$s</%1$s>',
                                esc_attr($caption_tag),
                                esc_attr($settings['hero_caption'])
                            );
                        }

                        // Xử lý Headline
                        if (!empty($settings['hero_headline'])) {
                            printf(
                                '<%1$s class="hero-headline">%2$s</%1$s>',
                                esc_attr($headline_tag),
                                esc_attr($settings['hero_headline'])
                            );
                        }
                        ?>

                        <?php if (!empty($settings['button_text'])) : ?>
                            <div class="hero-action">
                                <a class="hero-btn"
                                    <?php $this->print_render_attribute_string( 'button_link' ); ?>
                                >
                                    <span><?php echo esc_html($settings['button_text']); ?></span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="hero-content__footer d-flex align-items-center justify-content-center">
                        <div class="hero-scroll-hint text-center">
                            <div class="mouse-icon">
                                <div class="wheel"></div>
                            </div>

                            <div class="arrow-down">
                                <i class="fa-solid fa-angles-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

    protected function content_template(): void
    {
        ?>
        <#
        // Đăng ký các thuộc tính cho link trong JS template
        view.addRenderAttribute( 'button_link', settings.button_link );

        var headlineTag = settings.headline_tag || 'h2';
        var captionTag  = 'div';
        #>
        <div class="element-hero-banner-main">
            <div class="container h-100 position-relative">
                <div class="hero-content h-100">
                    <div class="hero-content__top">
                        <# if ( settings.hero_caption ) { #>
                            <{{{ captionTag }}} class="hero-caption">
                                {{{ settings.hero_caption }}}
                            </{{{ captionTag }}}>
                        <# } #>

                        <# if ( settings.hero_headline ) { #>
                            <{{{ headlineTag }}} class="hero-headline">
                                {{{ settings.hero_headline }}}
                            </{{{ headlineTag }}}>
                        <# } #>

                        <# if ( settings.button_text ) { #>
                            <div class="hero-action">
                                <a class="hero-btn" {{{ view.getRenderAttributeString( 'button_link' ) }}}>
                                    <span>{{{ settings.button_text }}}</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        <# } #>
                    </div>

                    <div class="hero-content__footer d-flex align-items-center justify-content-center">
                        <div class="hero-scroll-hint text-center">
                            <div class="mouse-icon">
                                <div class="wheel"></div>
                            </div>

                            <div class="arrow-down">
                                <i class="fa-solid fa-angles-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}