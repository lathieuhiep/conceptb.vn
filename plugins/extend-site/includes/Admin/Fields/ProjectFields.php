<?php

namespace ExtendSite\Admin\Fields;

use Carbon_Fields\Container;
use ExtendSite\Admin\Fields\Project\ProjectGalleryTab;
use ExtendSite\Admin\Fields\Project\ProjectGeneralTab;

defined('ABSPATH') || exit;

class ProjectFields
{
    public static function register(string $post_type): void
    {
        Container::make('post_meta', esc_html__('Ảnh dự án', 'extend-site'))
            ->where('post_type', '=', $post_type)
            ->set_context('side')
            ->set_priority('low')
            ->add_fields(ProjectGalleryTab::fields());

        Container::make('post_meta', esc_html__('Thông tin bổ sung', 'extend-site'))
            ->where('post_type', '=', $post_type)
            ->set_context('normal')
            ->set_priority('high')
            ->add_tab(
                esc_html__('Thông tin chung', 'extend-site'),
                ProjectGeneralTab::fields()
            );
    }
}
