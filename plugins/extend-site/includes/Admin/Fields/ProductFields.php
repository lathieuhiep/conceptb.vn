<?php

namespace ExtendSite\Admin\Fields;

use Carbon_Fields\Container;
use ExtendSite\Admin\Fields\Product\ProductConstructionTab;
use ExtendSite\Admin\Fields\Product\ProductGalleryTab;
use ExtendSite\Admin\Fields\Product\ProductGeneralTab;
use ExtendSite\Admin\Fields\Product\ProductMediaTab;

defined('ABSPATH') || exit;

class ProductFields
{
    public static function register(string $post_type): void
    {
        Container::make('post_meta', esc_html__('Ảnh phụ', 'extend-site'))
            ->where('post_type', '=', $post_type)
            ->set_context('side')
            ->set_priority('low')
            ->add_fields(ProductMediaTab::side_fields());

        Container::make('post_meta', esc_html__('Thông tin bổ sung', 'extend-site'))
            ->where('post_type', '=', $post_type)
            ->set_context('normal')
            ->set_priority('high')
            ->add_tab(
                esc_html__('Thông tin chung', 'extend-site'),
                ProductGeneralTab::fields()
            )
            ->add_tab(
                esc_html__('Album sản phẩm', 'extend-site'),
                ProductMediaTab::fields()
            )
            ->add_tab(
                esc_html__('Hình ảnh thực tế', 'extend-site'),
                ProductGalleryTab::fields()
            )
            ->add_tab(
                esc_html__('Quy trình thi công', 'extend-site'),
                ProductConstructionTab::fields()
            );
    }
}
