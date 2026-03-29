<?php
namespace ExtendSite\Admin\Fields\Pages;

use Carbon_Fields\Container;
use ExtendSite\Admin\Fields\Pages\Home\AboutTab;
use ExtendSite\Admin\Fields\Pages\Home\ContactTab;
use ExtendSite\Admin\Fields\Pages\Home\GalleryTab;
use ExtendSite\Admin\Fields\Pages\Home\HeroTab;
use ExtendSite\Admin\Fields\Pages\Home\PartnerTab;
use ExtendSite\Admin\Fields\Pages\Home\ProductTab;
use ExtendSite\Admin\Fields\Pages\Home\ProjectTab;
use ExtendSite\Admin\Fields\Pages\Home\ServicesTab;
use ExtendSite\Admin\Fields\Pages\Home\VolunteerTab;

defined('ABSPATH') || exit;

class HomeFields {

    public static function register(): void
    {
        Container::make('post_meta', esc_html__('Thiết lập trang chủ', 'extend-site'))
            ->where('post_type', '=', 'page')
            ->where('post_template', '=', 'templates/home.php')
            ->add_tab(
                esc_html__('Hero', 'extend-site'),
                HeroTab::fields()
            )->add_tab(
                esc_html__('Đối tác', 'extend-site'),
                PartnerTab::fields()
            )->add_tab(
                esc_html__('Galleries', 'extend-site'),
                GalleryTab::fields()
            )->add_tab(
                esc_html__('Về chúng tôi', 'extend-site'),
                AboutTab::fields()
            )->add_tab(
                esc_html__('Dịch vụ', 'extend-site'),
                ServicesTab::fields()
            )->add_tab(
                esc_html__('Sản phẩm', 'extend-site'),
                ProductTab::fields()
            )->add_tab(
                esc_html__('Dự án', 'extend-site'),
                ProjectTab::fields()
            )->add_tab(
                esc_html__('Thiện nguyện', 'extend-site'),
                VolunteerTab::fields()
            )->add_tab(
                esc_html__('Liên hệ', 'extend-site'),
                ContactTab::fields()
            );
    }
}
