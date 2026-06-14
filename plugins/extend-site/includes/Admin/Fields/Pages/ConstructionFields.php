<?php
namespace ExtendSite\Admin\Fields\Pages;

use Carbon_Fields\Container;
use ExtendSite\Admin\Fields\Pages\Construction\HeroTab;
use ExtendSite\Admin\Fields\Pages\Construction\ProcessTab;
use ExtendSite\Admin\Fields\Pages\Construction\RecommendationTab;
use ExtendSite\Admin\Fields\Pages\Construction\WorkflowGalleryTab;
use ExtendSite\Admin\Fields\Pages\Construction\WhyChooseTab;

defined('ABSPATH') || exit;

class ConstructionFields
{
    public static function register(): void
    {
        Container::make('post_meta', esc_html__('Thiết lập trang thi công', 'extend-site'))
            ->where('post_type', '=', 'page')
            ->where('post_template', '=', 'templates/construction.php')
            ->add_tab(
                esc_html__('Hero', 'extend-site'),
                HeroTab::fields()
            )->add_tab(
                esc_html__('Quy trình thi công', 'extend-site'),
                ProcessTab::fields()
            )->add_tab(
                esc_html__('Định mức khuyến nghị', 'extend-site'),
                RecommendationTab::fields()
            )->add_tab(
                esc_html__('Vì sao chọn ConceptB', 'extend-site'),
                WhyChooseTab::fields()
            )->add_tab(
                esc_html__('Quy trình làm việc', 'extend-site'),
                WorkflowGalleryTab::fields()
            );
    }
}
