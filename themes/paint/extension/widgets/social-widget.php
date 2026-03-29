<?php
if (!defined('ABSPATH')) {
  exit;
}

class paint_social_widget extends WP_Widget
{

  /**
   * Widget setup.
   */

  public function __construct()
  {

    $paint_social_widget_ops = array(
      'description' => 'A widget that displays your social icons',
    );

    parent::__construct('social_networks', 'My Theme: Social Networks', $paint_social_widget_ops);

  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  function widget($args, $instance): void
  {
    echo $args['before_widget'];

    if (!empty($instance['title'])) {
      echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
    }

    $opt_social_networks = paint_get_option('paint_opt_social_network', []);

    if ( empty($opt_social_networks) ) {
        return;
    }
    ?>

    <div class="widget-warp">
        <div class="social-list">
            <?php
            foreach ( $opt_social_networks as $key => $network ) :
                if ( $key == 'facebook' ) {
                    $class_icon = 'fa-facebook';
                } elseif ( $key == 'youtube' ) {
                    $class_icon = 'fa-youtube';
                } elseif ( $key == 'tiktok' ) {
                    $class_icon = 'fa-tiktok';
                } elseif ( $key == 'pinterest' ) {
                    $class_icon = 'fa-pinterest-p';
                } else {
                    $class_icon = '';
                }
            ?>
                <a class="item"
                   href="<?php echo esc_url( $network ); ?>"
                   target="_blank"
                >
                    <i class="fa-brands <?php echo esc_attr( $class_icon ); ?>"></i>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    echo $args['after_widget'];
  }

  /**
   * Outputs the options form on admin
   *
   * @param array $instance The widget options
   */
  function form($instance): void
  {

    $defaults = array(
      'title' => 'Subscribe & Follow',
    );

    $instance = wp_parse_args((array)$instance, $defaults); ?>

    <!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">
        <?php esc_html_e('Title:', 'paint'); ?>
      </label>

      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
             name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"
             style="width:90%;"/>
    </p>

    <p>
      <?php esc_html_e('Mạng xã hội được thiết lập ở theme options ở mục "Mạng xã hội"', 'paint'); ?>
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
  function update($new_instance, $old_instance): array
  {
    $instance = array();

    $instance['title'] = strip_tags($new_instance['title']);

    return $instance;
  }

}

// Register social widget
function paint_social_widget_register(): void
{
  register_widget('paint_social_widget');
}

add_action('widgets_init', 'paint_social_widget_register');