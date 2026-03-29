<?php

namespace ExtendSite\Constants;

defined('ABSPATH') || exit;

final class ControlOptions
{
    /**
     * Heading tag options for selects.
     *
     * @return array<string, string>
     */
    public static function heading_tags(): array
    {
        return [
            'h1' => 'H1',
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
        ];
    }

    /**
     * Text wrapper tag options for selects.
     *
     * @return array<string, string>
     */
    public static function text_wrappers(): array
    {
        return [
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'div'  => 'div',
            'span' => 'span',
            'p'    => 'p',
        ];
    }
}