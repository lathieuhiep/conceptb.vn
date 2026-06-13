<?php
namespace ExtendSite\Admin\Fields\Pages;

use Carbon_Fields\Container;
use ExtendSite\Admin\Fields\Pages\About\HeroTab;
use ExtendSite\Admin\Fields\Pages\About\IntroTab;
use ExtendSite\Admin\Fields\Pages\About\PublicationTab;
use ExtendSite\Admin\Fields\Pages\About\ServicesTab;
use ExtendSite\Admin\Fields\Pages\About\ValuesTab;

defined('ABSPATH') || exit;

class AboutFields
{
    public static function register(): void
    {
        Container::make('post_meta', esc_html__('Thiết lập trang About Us', 'extend-site'))
            ->where('post_type', '=', 'page')
            ->where('post_template', '=', 'templates/about-us.php')
            ->add_tab(
                esc_html__('Hero', 'extend-site'),
                HeroTab::fields()
            )->add_tab(
                esc_html__('Giá trị cốt lõi', 'extend-site'),
                ValuesTab::fields()
            )->add_tab(
                esc_html__('Giới thiệu', 'extend-site'),
                IntroTab::fields()
            )->add_tab(
                esc_html__('Ấn phẩm', 'extend-site'),
                PublicationTab::fields()
            )->add_tab(
                esc_html__('Dịch vụ', 'extend-site'),
                ServicesTab::fields()
            );
    }
}
