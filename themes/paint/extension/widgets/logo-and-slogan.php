<?php
class Logo_And_Slogan_Widget extends WP_Widget {

    /**
     * Widget setup.
     */
    public function __construct() {
        parent::__construct(
            'logo_and_slogan',
            __('My Theme: Logo And Slogan', 'paint'),
            array('description' => __('A widget that displays your logo and slogan', 'paint'))
        );
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance): void
    {
        $defaults = array(
            'image_url' => '',
            'image_id' => '',
            'slogan' => esc_html__('BCOLOR VIỆT NAM', 'paint'),
        );

        $instance = wp_parse_args((array)$instance, $defaults);
    ?>
        <p>
            <span class="note"><?php esc_html_e('Chọn ảnh làm logo', 'paint'); ?></span>
            <?php Media_Uploader::media_uploader_field($this->get_field_name('image_url'), $instance['image_url'], $this->get_field_name('image_id'), $instance['image_id']); ?>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'slogan' ); ?>">
                <?php esc_html_e( 'Khẩu hiệu:', 'paint' ); ?>
            </label>

            <input class="widefat" id="<?php echo $this->get_field_id( 'slogan' ); ?>" name="<?php echo $this->get_field_name( 'slogan' ); ?>" value="<?php echo esc_attr( $instance['slogan'] ); ?>" />
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
    public function update($new_instance, $old_instance): array
    {
        $instance = array();

        $instance['image_url'] = (!empty($new_instance['image_url'])) ? strip_tags($new_instance['image_url']) : '';
        $instance['image_id'] = (!empty($new_instance['image_id'])) ? strip_tags($new_instance['image_id']) : '';
        $instance['slogan'] = strip_tags( $new_instance['slogan'] );

        return $instance;
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance): void
    {
        echo $args['before_widget'];

        $image_id = $instance['image_id'];
        $slogan = $instance['slogan'];
    ?>
        <div class="widget-warp">
            <?php if ( !empty( $image_id ) ) :  ?>
            <div class="widget-warp__thumbnail">
                <?php echo wp_get_attachment_image( $image_id, 'medium' ); ?>
            </div>

            <div class="widget-warp__body">
                <p class="slogan"><?php echo esc_html( $slogan ); ?></p>
            </div>
            <?php endif; ?>
        </div>
    <?php
        echo $args['after_widget'];
    }
}

// Đăng ký widget
function paint_register_logo_and_slogan_widget(): void
{
    register_widget('Logo_And_Slogan_Widget');
}
add_action('widgets_init', 'paint_register_logo_and_slogan_widget');
