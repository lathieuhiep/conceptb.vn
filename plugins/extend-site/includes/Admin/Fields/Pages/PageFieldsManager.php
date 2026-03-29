<?php
namespace ExtendSite\Admin\Fields\Pages;

defined('ABSPATH') || exit;

/**
 * Manages Carbon Fields meta for Page templates.
 */
class PageFieldsManager {

    /**
     * Boot the PageFieldsManager by hooking into Carbon Fields registration.
     */
    public static function boot(): void
    {
        add_action('carbon_fields_register_fields', [self::class, 'register']);
    }

    /**
     * Register page-specific fields.
     */
    public static function register(): void
    {
        DefaultFields::register();
        HomeFields::register();
        // ContactFields::register();
        // LandingFields::register();
    }
}