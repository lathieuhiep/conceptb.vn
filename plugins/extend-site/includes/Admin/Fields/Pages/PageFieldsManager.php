<?php
namespace ExtendSite\Admin\Fields\Pages;

use ExtendSite\Admin\Fields\Pages\About\CertificationTab;

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
        CertificationTab::boot_admin_cleanup();
    }

    /**
     * Register page-specific fields.
     */
    public static function register(): void
    {
        DefaultFields::register();
        HomeFields::register();
        FaqFields::register();
        AboutFields::register();
        ConstructionFields::register();
        // ContactFields::register();
        // LandingFields::register();
    }
}
