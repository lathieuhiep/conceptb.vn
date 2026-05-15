<?php

namespace ExtendSite\Admin\Fields;

use Carbon_Fields\Container;
use ExtendSite\Admin\Fields\Tool\ToolGalleryTab;
use ExtendSite\Admin\Fields\Tool\ToolSpecificationsTab;

defined('ABSPATH') || exit;

class ToolFields
{
    public static function register(string $post_type): void
    {
        Container::make('post_meta', esc_html__('Gallery', 'extend-site'))
            ->where('post_type', '=', $post_type)
            ->set_context('side')
            ->set_priority('low')
            ->add_fields(ToolGalleryTab::fields());

        Container::make('post_meta', esc_html__('Thông tin sản phẩm', 'extend-site'))
            ->where('post_type', '=', $post_type)
            ->set_context('normal')
            ->set_priority('low')
            ->add_tab(
                esc_html__('Thông số kỹ thuật', 'extend-site'),
                ToolSpecificationsTab::fields()
            );
    }
}
