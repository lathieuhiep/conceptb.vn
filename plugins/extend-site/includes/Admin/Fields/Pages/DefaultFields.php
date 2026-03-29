<?php
namespace ExtendSite\Admin\Fields\Pages;

use Carbon_Fields\Container;
use ExtendSite\Admin\Fields\Pages\Default\MenuTab;

defined('ABSPATH') || exit;

class DefaultFields {

    public static function register(): void
    {
        Container::make('post_meta', esc_html__('Thiết lập chung', 'extend-site'))
            ->where('post_type', '=', 'page')
            ->add_tab(
                esc_html__('Menu', 'extend-site'),
                MenuTab::fields()
            );
    }
}