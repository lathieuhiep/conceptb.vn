<?php
namespace ExtendSite\Admin\Fields\Pages;

use Carbon_Fields\Container;
use ExtendSite\Admin\Fields\Pages\Faq\GeneralTab;

defined('ABSPATH') || exit;

class FaqFields
{
    public static function register(): void
    {
        Container::make('post_meta', esc_html__('Thiết lập trang FAQ', 'extend-site'))
            ->where('post_type', '=', 'page')
            ->where('post_template', '=', 'templates/faq.php')
            ->add_tab(
                esc_html__('Nội dung đầu trang', 'extend-site'),
                GeneralTab::fields()
            );
    }
}
