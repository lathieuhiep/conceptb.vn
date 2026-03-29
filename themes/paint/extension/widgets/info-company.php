<?php
/**
 * Widget Name: Info Company Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class paint_info_company_widget extends WP_Widget {
	/* Widget setup */
    public function __construct() {
        $paint_info_company_widget_ops = array(
            'description'   =>  esc_html__( 'A widget that displays your info company', 'paint' ),
        );

        parent::__construct( 'info_company', 'My Theme: Thông tin công ty', $paint_info_company_widget_ops );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
	function widget( $args, $instance ): void
    {
        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        $address = paint_get_option('opt-info-company-address');
        $phones = paint_get_option('opt-info-company-phone');
        $email = paint_get_option('opt-info-company-email');
    ?>
        <div class="widget-warp">
            <?php if ( !empty( $phones ) ) : ?>
                <div class="item">
                    <div class="item__thumbnail">
                        <i class="fa-solid fa-phone"></i>
                    </div>

                    <div class="item__info">
                        <?php
                        foreach ( $phones as $index => $item ):
                            if ( !empty( $item ) ) :
                        ?>
                            <?php if ( $index + 1 > 1 ) : ?>
                                <span class="txt">|</span>
                            <?php endif; ?>

                            <a class="fw-bold" href="tel:<?php echo esc_attr( paint_preg_replace_ony_number( $item['phone'] ) ) ?>"><?php echo esc_html( $item['phone'] ); ?></a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( !empty( $address ) ) : ?>
                <div class="item">
                    <div class="item__thumbnail">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <div class="item__info">
                        <?php echo esc_html( $address ) ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( !empty( $email ) ) : ?>
                <div class="item">
                    <div class="item__thumbnail">
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div class="item__info">
                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html( $email ) ?></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php

        echo $args['after_widget'];
	}

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
	function form( $instance ): void
    {
		$defaults = array(
            'title' => ''
        );

		$instance = wp_parse_args( (array) $instance, $defaults );
        ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php esc_html_e( 'Tiêu đề:', 'paint' ); ?>
            </label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

        <p>
            <?php esc_html_e('Các giá trị trường được lấy trong theme options mục "thông tin công ty"', 'paint'); ?>
        </p>
	<?php

	}

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    function update( $new_instance, $old_instance ): array
    {
        $instance = array();

        $instance['title'] = strip_tags( $new_instance['title'] );

        return $instance;
    }
}

// Register widget
function paint_info_company_widget_register(): void {
    register_widget( 'paint_info_company_widget' );
}

add_action( 'widgets_init', 'paint_info_company_widget_register' );