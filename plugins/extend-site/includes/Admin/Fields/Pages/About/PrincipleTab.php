<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class PrincipleTab implements FieldTabIF
{
    private const KEY = 'es_about_page_principle_tab_';
    private const TITLE = self::KEY . 'title';
    private const DESCRIPTION = self::KEY . 'description';
    private const IMAGES = self::KEY . 'images';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('TÔN CHỈ SẢN XUẤT NGHIÊN CỨU')
                ->set_width(50),

            Field::make('textarea', self::DESCRIPTION, esc_html__('Mô tả', 'extend-site'))
                ->set_default_value('Phát huy tối đa tinh thần trách nhiệm với chính những gì mà chúng tôi tạo ra để mọi khách hàng yên tâm đặt trọn niềm tin vào Bcolor bằng khả năng phục vụ tận tâm, dám nghĩ, dám làm, dám chịu trách nhiệm.')
                ->set_rows(3)
                ->set_width(50),

            Field::make('media_gallery', self::IMAGES, esc_html__('Thư viện ảnh', 'extend-site')),
        ];
    }

    public static function get_data(int $post_id): array
    {
        $images = carbon_get_post_meta($post_id, self::IMAGES);

        return [
            'title' => trim((string)carbon_get_post_meta($post_id, self::TITLE)),
            'description' => trim((string)carbon_get_post_meta($post_id, self::DESCRIPTION)),
            'images' => is_array($images) ? $images : [],
        ];
    }
}
