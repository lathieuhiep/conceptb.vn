<?php

namespace ExtendSite\Admin\Migrations;

defined('ABSPATH') || exit;

class MigrationManager
{
    public static function boot(): void
    {
        add_action('carbon_fields_fields_registered', [self::class, 'run']);
    }

    public static function run(): void
    {
        if (!is_admin()) {
            return;
        }

        ProductCmbToCarbonMigration::run();
        ColorCodeCmbToCarbonMigration::run();
        ToolCmbToCarbonMigration::run();
        ProjectCmbToCarbonMigration::run();
        DiscoverCmbToCarbonMigration::run();
    }
}
