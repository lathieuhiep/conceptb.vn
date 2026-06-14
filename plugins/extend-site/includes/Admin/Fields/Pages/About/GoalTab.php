<?php
namespace ExtendSite\Admin\Fields\Pages\About;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class GoalTab implements FieldTabIF
{
    private const KEY = 'es_about_page_goal_tab_';
    private const TITLE = self::KEY . 'title';
    private const LEAD = self::KEY . 'lead';
    private const DESCRIPTION = self::KEY . 'description';
    private const ITEMS = self::KEY . 'items';

    public static function fields(): array
    {
        return [
            Field::make('text', self::TITLE, esc_html__('Tiêu đề', 'extend-site'))
                ->set_default_value('Mục tiêu của chúng tôi')
                ->set_width(50),

            Field::make('textarea', self::LEAD, esc_html__('Mô tả nổi bật', 'extend-site'))
                ->set_default_value('Trở thành top những thương hiệu đi đầu trong công tác nghiên cứu, ứng dụng, phân phối và phát triển giải pháp phủ bảo vệ bề mặt vật liệu xây dựng, trong đó định hình sản phẩm cốt lõi là Sơn đá công nghệ tương lai xanh.')
                ->set_rows(3)
                ->set_width(50),

            Field::make('textarea', self::DESCRIPTION, esc_html__('Nội dung mô tả', 'extend-site'))
                ->set_default_value('Mang tinh thần, trí tuệ Việt kết hợp với sức vươn của thời đại để xóa đi và vượt lên khoảng cách về công nghệ, thời gian và chất lượng so với thị trường ngoại nhập. Đem lại cho thị trường nước nhà những sản phẩm ổn định nhất, phù hợp nhất với thổ nhưỡng, khí hậu, văn hóa và thị hiếu của người Việt Nam. Phát huy tối đa tinh thần trách nhiệm với chính những gì mà chúng tôi tạo ra để mọi khách hàng yên tâm đặt trọn niềm tin vào Bcolor bằng khả năng phục vụ tận tâm, dám nghĩ, dám làm, dám chịu trách nhiệm.')
                ->set_rows(5),

            Field::make('complex', self::ITEMS, esc_html__('Danh sách chỉ số', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('text', 'title', esc_html__('Tiêu đề thẻ', 'extend-site'))
                        ->set_width(25),

                    Field::make('text', 'label', esc_html__('Nhãn', 'extend-site'))
                        ->set_width(25),

                    Field::make('text', 'metric', esc_html__('Chỉ số', 'extend-site'))
                        ->set_width(25),

                    Field::make('textarea', 'description', esc_html__('Mô tả', 'extend-site'))
                        ->set_rows(2),
                ])
                ->set_default_value(self::default_items())
                ->set_header_template('
                    <% if (title) { %>
                        <%- title %>
                    <% } %>
                '),
        ];
    }

    public static function get_data(int $post_id): array
    {
        $items = carbon_get_post_meta($post_id, self::ITEMS);

        return [
            'title' => trim((string)carbon_get_post_meta($post_id, self::TITLE)),
            'lead' => trim((string)carbon_get_post_meta($post_id, self::LEAD)),
            'description' => trim((string)carbon_get_post_meta($post_id, self::DESCRIPTION)),
            'items' => !empty($items) ? $items : self::default_items(),
        ];
    }

    private static function default_items(): array
    {
        return [
            [
                'title' => 'Cho cá nhân',
                'label' => 'Kiến tạo',
                'metric' => '1000 +',
                'description' => 'Công trình trường tồn với giá trị bền vững cao trên toàn lãnh thổ Việt Nam',
            ],
            [
                'title' => 'Cho cộng đồng',
                'label' => 'Hỗ trợ',
                'metric' => '5000 +',
                'description' => 'Dự án xây dựng cộng đồng để trẻ em có cuộc sống tốt hơn bằng hoạt động từ thiện',
            ],
            [
                'title' => 'Cho hành tinh',
                'label' => 'Nỗ lực giảm thiểu',
                'metric' => 'KHÔNG',
                'description' => 'Tác động đến môi trường trong quá trình sản xuất bằng việc tối ưu sử dụng công nghệ',
            ],
        ];
    }
}
