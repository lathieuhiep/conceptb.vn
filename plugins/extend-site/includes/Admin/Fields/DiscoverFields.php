<?php

namespace ExtendSite\Admin\Fields;

use Carbon_Fields\Container;
use ExtendSite\Admin\Fields\Discover\DiscoverGeneralTab;

defined('ABSPATH') || exit;

class DiscoverFields
{
    public static function register(string $post_type): void
    {
        Container::make('post_meta', esc_html__('Options', 'extend-site'))
            ->where('post_type', '=', $post_type)
            ->set_context('normal')
            ->set_priority('high')
            ->add_tab(
                esc_html__('Thông tin', 'extend-site'),
                DiscoverGeneralTab::fields()
            );
    }
}
