<?php

namespace ExtendSite\Admin\Fields\Product;

use Carbon_Fields\Field;
use ExtendSite\Admin\Fields\FieldTabIF;

defined('ABSPATH') || exit;

class ProductConstructionTab implements FieldTabIF
{
    public const CONSTRUCTION_PROCESS = 'es_product_construction_process';

    private const CMB_CONSTRUCTION_PROCESS = 'paint_cmb_product_construction_process';

    public static function fields(): array
    {
        return [
            Field::make('complex', self::CONSTRUCTION_PROCESS, esc_html__('Quy trình thi công', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->set_collapsed(true)
                ->add_fields('_', esc_html__('Bước', 'extend-site'), [
                    Field::make('rich_text', 'content', esc_html__('Quy trình thi công', 'extend-site')),
                ])
                ->set_header_template( esc_html__('Bước', 'extend-site') . ' <%- $_index + 1 %>'),
        ];
    }

    public static function get_construction_process(int $post_id): array
    {
        $rows = function_exists('carbon_get_post_meta')
            ? carbon_get_post_meta($post_id, self::CONSTRUCTION_PROCESS)
            : [];

        if (is_array($rows) && !empty($rows)) {
            $normalized = self::normalize_rows($rows);

            if (self::has_useful_rows($normalized)) {
                return $normalized;
            }
        }

        $rows = get_post_meta($post_id, self::CMB_CONSTRUCTION_PROCESS, true);

        return is_array($rows) ? self::normalize_rows($rows) : [];
    }

    public static function get_data(int $post_id): array
    {
        return [
            'construction_process' => self::get_construction_process($post_id),
        ];
    }

    private static function normalize_rows(array $rows): array
    {
        $normalized = [];

        foreach ($rows as $index => $row) {
            if (!is_array($row)) {
                continue;
            }

            $normalized[] = [
                'step' => sprintf(esc_html__('Bước %d', 'extend-site'), $index + 1),
                'content' => isset($row['content']) ? (string) $row['content'] : '',
            ];
        }

        return $normalized;
    }

    private static function has_useful_rows(array $rows): bool
    {
        foreach ($rows as $row) {
            if (!empty(trim((string) ($row['content'] ?? '')))) {
                return true;
            }
        }

        return false;
    }
}
