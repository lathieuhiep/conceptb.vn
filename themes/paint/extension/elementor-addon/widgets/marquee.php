<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

defined('ABSPATH') || exit;

class Paint_Elementor_Marquee extends Widget_Base {

    public function get_name(): string {
        return 'paint-marquee';
    }

    public function get_title(): string {
        return esc_html__('ES Marquee', 'extend-site');
    }

    public function get_icon(): string {
        return 'eicon-slider-album';
    }

    public function get_categories(): array {
        return ['my-theme'];
    }

    public function get_keywords(): array {
        return ['marquee', 'logo', 'gallery', 'splide'];
    }

    public function get_style_depends(): array {
        return [ 'swiper' ];
    }

    // widget scripts dependencies
    public function get_script_depends(): array {
        return [ 'swiper', 'paint-elementor-script' ];
    }

    /* =======================
     * REGISTER CONTROLS
     * ======================= */
    protected function register_controls(): void {

        /* ---------- CONTENT ---------- */
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'extend-site'),
            ]
        );

        $this->add_control(
            'mode',
            [
                'label' => esc_html__('Mode', 'extend-site'),
                'type' => Controls_Manager::SELECT,
                'default' => 'logo',
                'options' => [
                    'logo'    => esc_html__('Logo', 'extend-site'),
                    'gallery' => esc_html__('Gallery', 'extend-site'),
                ],
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label' => esc_html__( 'Chọn ảnh', 'text-domain' ),
                'type' => Controls_Manager::GALLERY,
                'default' => [],
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => esc_html__('Scroll Direction', 'extend-site'),
                'type' => Controls_Manager::SELECT,
                'default' => 'ltr',
                'options' => [
                    'ltr' => esc_html__('Left → Right', 'extend-site'),
                    'rtl' => esc_html__('Right → Left', 'extend-site'),
                ],
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__( 'Tốc độ chạy (ms)', 'text-domain' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 20000,
                'step' => 500,
                'default' => 5000,
                'frontend_available' => true, // Cho phép JS truy cập nếu cần
            ]
        );

        $this->end_controls_section();

        /* ---------- STYLE: ITEM ---------- */
        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'extend-site'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_width',
            [
                'label' => esc_html__('Item Width', 'extend-site'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 40, 'max' => 400],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-marquee .splide__slide' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_height',
            [
                'label' => esc_html__('Item Height', 'extend-site'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 20, 'max' => 300],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-marquee img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Gap', 'extend-site'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .element-marquee' => '--element-marquee-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .element-marquee img',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'selector' => '{{WRAPPER}} .element-marquee img',
            ]
        );

        $this->end_controls_section();
    }

    /* =======================
     * RENDER
     * ======================= */
    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $gallery = $settings['gallery'];

        if ( empty( $gallery ) ) return;

        $speed = !empty($settings['speed']) ? $settings['speed'] : 5000;
        $direction = !empty($settings['direction']) ? $settings['direction'] : 'ltr';

        ?>
        <div class="element-marquee swiper"
             data-speed="<?php echo esc_attr($speed); ?>"
             data-direction="<?php echo esc_attr($direction); ?>">
            <div class="swiper-wrapper">
                <?php
                // Lặp lại mảng ảnh để đảm bảo loop mượt mà
                $slides = array_merge($gallery, $gallery);
                foreach ( $slides as $image ) :
                    ?>
                    <div class="swiper-slide">
                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="Partner Logo">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}