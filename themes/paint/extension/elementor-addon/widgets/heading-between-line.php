<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Paint_Elementor_Heading_Between_Line extends Widget_Base
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
		return 'paint-heading-between-line';
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
		return esc_html__('Heading Between Line', 'paint');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-heading';
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
		return ['heading', 'line', 'between' ];
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
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'paint' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => esc_html__( 'Heading', 'paint' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'paint' ),
				'placeholder' => esc_html__( 'Type your title here', 'paint' ),
				'label_block' => true
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label' => esc_html__( 'Chiều rộng vùng chứa', 'paint' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .element-heading-between-line__warp' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_vertical_position',
			[
				'label'     =>  esc_html__( 'Alignment', 'paint' ),
				'type'      =>  Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Bắt đầu', 'paint' ),
						'icon' => 'eicon-align-start-v',
					],
					'center' => [
						'title' => esc_html__( 'Giữa', 'paint' ),
						'icon' => 'eicon-align-center-v',
					],
					'end' => [
						'title' => esc_html__( 'Kết thúc', 'paint' ),
						'icon' => 'eicon-align-end-v',
					],
					'stretch' => [
						'title' => esc_html__( 'Nới rộng', 'paint' ),
						'icon' => 'eicon-align-stretch-v',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .element-heading-between-line' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_align',
			[
				'label' => esc_html__( 'Căn chỉnh nội dung', 'paint' ),
				'type' => Controls_Manager::CHOOSE,
				'options'   =>  [
					'left'  =>  [
						'title' =>  esc_html__( 'Left', 'paint' ),
						'icon'  =>  'eicon-text-align-left',
					],

					'center' => [
						'title' =>  esc_html__( 'Center', 'paint' ),
						'icon'  =>  'eicon-text-align-center',
					],

					'right' => [
						'title' =>  esc_html__( 'Right', 'paint' ),
						'icon'  =>  'eicon-text-align-right',
					],

					'justify' => [
						'title' =>  esc_html__( 'Justify', 'paint' ),
						'icon'  =>  'eicon-text-align-justify',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .element-heading-between-line' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// style heading
		$this->start_controls_section(
			'style_heading_section',
			[
				'label' => esc_html__( 'Heading', 'paint' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'paint' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-heading-between-line__warp .heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .element-heading-between-line__warp .heading',
			]
		);

		$this->end_controls_section();

        // style line
		$this->start_controls_section(
			'style_line_section',
			[
				'label' => esc_html__( 'Line', 'paint' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'line_color',
			[
				'label' => esc_html__( 'Color', 'paint' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-heading-between-line__warp .line' => 'background-color: {{VALUE}}',
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
		?>
		<div class="element-heading-between-line">
			<div class="element-heading-between-line__warp">
                <span class="line"></span>

				<h3 class="heading">
					<?php echo esc_html( $settings['heading'] ); ?>
				</h3>

                <span class="line"></span>
			</div>
		</div>
		<?php
	}
}