<?php

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Paint_Elementor_Contact_Form_7 extends Widget_Base {
	public function get_categories(): array {
		return array( 'my-theme' );
	}

	public function get_name(): string {
		return 'paint-contact-form-7';
	}

	public function get_title(): string {
		return esc_html__( 'Contact Form 7', 'paint' );
	}

	public function get_icon(): string {
		return 'eicon-form-horizontal';
	}

	protected function register_controls(): void {
		// Content section
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Contact Form', 'paint' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Tiêu đề', 'paint' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tiêu đề', 'paint' ),
				'label_block' => true
			]
		);

        $this->add_control(
            'sub_heading',
            [
                'label'       => esc_html__( 'Tiêu đề dưới', 'paint' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Bảo  mật thông tin tuyệt đối', 'paint' ),
                'label_block' => true,
            ]
        );

		$this->add_control(
			'contact_form_list',
			[
				'label'       => esc_html__( 'Chọn form liên hệ', 'paint' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => paint_get_form_cf7(),
				'default'     => '0',
			]
		);

		$this->end_controls_section();

        // style heading
        $this->start_controls_section(
            'style_heading_section',
            [
                'label' => esc_html__( 'Tiêu đề', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__( 'Màu', 'paint' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 .heading span' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .element-contact-form-7 .heading span',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'heading_stroke',
                'selector' => '{{WRAPPER}} .element-contact-form-7 .heading span',
            ]
        );

        $this->add_control(
            'show_gradient',
            [
                'label' => esc_html__( 'Show Gradient', 'paint' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'paint' ),
                'label_off' => esc_html__( 'Hide', 'paint' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .element-contact-form-7 .heading span.has-gradient',
                'condition' => [
                    'show_gradient' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // sub heading style
        $this->start_controls_section(
            'sub_heading_style_section',
            [
                'label' => esc_html__( 'Tiêu đề dưới', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'sub_heading_padding',
            [
                'label' => esc_html__( 'Padding', 'paint' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 .sub-heading .txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sub_heading_color',
            [
                'label'     =>  esc_html__( 'Màu chữ', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-contact-form-7 .sub-heading .txt' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_heading_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-contact-form-7 .sub-heading .txt',
            ]
        );

        $this->add_control(
            'sub_heading_background_color',
            [
                'label'     =>  esc_html__( 'Màu nền', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-contact-form-7 .sub-heading .txt' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sub_heading_border',
                'selector' => '{{WRAPPER}} .element-contact-form-7 .sub-heading .txt',
            ]
        );

        $this->add_control(
            'sub_heading_border_radius',
            [
                'label' => esc_html__( 'Border radius', 'paint' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 .sub-heading .txt' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // form style
        $this->start_controls_section(
            'form_style_section',
            [
                'label' => esc_html__( 'Form', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'form_background_color',
            [
                'label'     =>  esc_html__( 'Màu nền', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_padding',
            [
                'label' => esc_html__( 'Padding', 'paint' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'selector' => '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form',
            ]
        );

        $this->add_control(
            'form_border_radius',
            [
                'label' => esc_html__( 'Border radius', 'paint' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'form_box_shadow',
                'selector' => '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form',
            ]
        );

        $this->end_controls_section();

        // field style
        $this->start_controls_section(
            'field_style_section',
            [
                'label' => esc_html__( 'Field', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'field_padding',
            [
                'label' => esc_html__( 'Padding', 'paint' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-form-control-wrap .wpcf7-form-control:not(.wpcf7-submit)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'field_color',
            [
                'label'     =>  esc_html__( 'Màu chữ', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-form-control-wrap .wpcf7-form-control:not(.wpcf7-submit)' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-form-control-wrap .wpcf7-form-control:not(.wpcf7-submit)::placeholder' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-form-control-wrap .wpcf7-form-control:not(.wpcf7-submit)',
            ]
        );

        $this->add_control(
            'field_background_color',
            [
                'label'     =>  esc_html__( 'Màu nền', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-form-control-wrap .wpcf7-form-control:not(.wpcf7-submit)' => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'selector' => '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-form-control-wrap .wpcf7-form-control:not(.wpcf7-submit)',
            ]
        );

        $this->add_control(
            'field_border_radius',
            [
                'label' => esc_html__( 'Border radius', 'paint' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-form-control-wrap .wpcf7-form-control:not(.wpcf7-submit)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'field_height_input',
            [
                'label' => esc_html__( 'Chiều cao input', 'paint' ),
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
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-form-control-wrap input' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'field_height_textarea',
            [
                'label' => esc_html__( 'Chiều cao textarea', 'paint' ),
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
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-form-control-wrap textarea' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // submit style
        $this->start_controls_section(
            'submit_style_section',
            [
                'label' => esc_html__( 'Submit', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'submit_padding',
            [
                'label' => esc_html__( 'Padding', 'paint' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'submit_color',
            [
                'label'     =>  esc_html__( 'Màu chữ', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-submit' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-submit',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'submit_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-submit',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'selector' => '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-submit',
            ]
        );

        $this->add_control(
            'submit_border_radius',
            [
                'label' => esc_html__( 'Border radius', 'paint' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-contact-form-7 form.wpcf7-form .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // error style
        $this->start_controls_section(
            'error_style_section',
            [
                'label' => esc_html__( 'Thông báo lỗi', 'paint' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'error_color',
            [
                'label'     =>  esc_html__( 'Color', 'paint' ),
                'type'      =>  Controls_Manager::COLOR,
                'selectors' =>  [
                    '{{WRAPPER}} .wpcf7-not-valid-tip, {{WRAPPER}} .wpcf7-response-output' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'error_typography',
                'label' => esc_html__( 'Typography', 'paint' ),
                'selector' => '{{WRAPPER}} .wpcf7-not-valid-tip, {{WRAPPER}} .wpcf7-response-output',
            ]
        );

        $this->end_controls_section();
	}

	protected function render(): void
    {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['contact_form_list'] ) ) :
			?>

            <div class="element-contact-form-7">
                <?php if ( $settings['heading'] ) : ?>
                    <h3 class="heading text-center">
		                <span class="d-inline-block<?php echo esc_attr( $settings['show_gradient'] == 'yes' ? ' has-gradient' : '' ); ?>"><?php echo esc_html( $settings['heading'] ); ?></span>
                    </h3>
                <?php endif; ?>

                <?php if ( $settings['sub_heading'] ) : ?>
                    <div class="sub-heading text-center">
                        <p class="d-inline-block txt"><?php echo esc_html( $settings['sub_heading'] ); ?></p>
                    </div>
                <?php endif; ?>

				<?php echo do_shortcode( '[contact-form-7 id="' . $settings['contact_form_list'] . '" ]' ); ?>
            </div>

		<?php
		endif;
	}

}
