<?php

class Media_Uploader
{
    public static function enqueue_scripts(): void
    {
        wp_enqueue_media();
        wp_enqueue_style('media-uploader', get_theme_file_uri('/extension/assets/css/media-uploader.css'));
        wp_enqueue_script('media-uploader', get_theme_file_uri('/extension/assets/js/media-uploader.js'), array('jquery'), '', true);
    }

    public static function media_uploader_field($name_url, $value_url = '', $name_id = '', $value_id = ''): void
    {
        $button_text = empty( $value_url ) ? esc_html__('Thêm ảnh', 'paint') : esc_html__('Sửa ảnh', 'paint');
    ?>
        <div class="media-uploader-wrapper">
            <img class="media-uploader-preview" src="<?php echo esc_url($value_url); ?>" style="max-width:100%; <?php echo empty($value_url) ? 'display:none;' : ''; ?>" alt="">
            <input class="widefat media-uploader-url" name="<?php echo esc_attr($name_url); ?>" type="hidden" value="<?php echo esc_attr($value_url); ?>" />
            <input class="widefat media-uploader-id" name="<?php echo esc_attr($name_id); ?>" type="hidden" value="<?php echo esc_attr($value_id); ?>" />
            <button class="button media-uploader-button"><?php echo $button_text; ?></button>
            <button class="button media-uploader-remove" style="<?php echo empty($value_url) ? 'display:none;' : ''; ?>">
                <?php _e('Xóa ảnh', 'paint'); ?>
            </button>
        </div>
        <?php
    }
}

// Đăng ký script khi admin được tải
add_action('admin_enqueue_scripts', array('Media_Uploader', 'enqueue_scripts'));
