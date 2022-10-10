<?php

namespace Main\Admin\Controllers\Common;

class Column_Left extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
       // Library
       $this->request = service('request');
       $this->administrator = new \App\Libraries\Administrator();
       $this->template = new \App\Libraries\Template();
       $this->url = new \App\Libraries\Url();

    }

    public function index($column_left_params = array())
    {
        $data['administrator'] = $this->administrator->getFirstname() . ' ' . $this->administrator->getLastname();

        // Menu
        $data['menus'] = [];

        // Dashboard
        $data['menus'][] = [
            'id' => 'menu-dashboard',
            'icon' => 'fas fa-tachometer-alt fa-fw',
            'text' => lang('Menu.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'children' => [],
        ];

        // Marketplace
        $marketplace = [];

        $marketplace[] = [
            'id' => 'menu-marketplace-category',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.categories'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id' => 'menu-marketplace',
            'icon' => 'fas fa-store fa-fw',
            'text' => lang('Menu.marketplace'),
            'href' => '',
            'children' => $marketplace,
        ];

        // Administrator
        $administrator = [];

        $administrator[] = [
            'id' => 'menu-administrator-administrator-group',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.administrator_groups'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator_group'),
            'children' => [],
        ];

        $administrator[] = [
            'id' => 'menu-administrator-administrator',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.administrators'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id' => 'menu-administrator',
            'icon' => 'fas fa-user-tie fa-fw',
            'text' => lang('Menu.administrators'),
            'href' => '',
            'children' => $administrator,
        ];

        // Customer
        $customer = [];

        $customer[] = [
            'id' => 'menu-customer-customer-group',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.customer_groups'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group'),
            'children' => [],
        ];

        $customer[] = [
            'id' => 'menu-customer-customer',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.customers'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id' => 'menu-customer',
            'icon' => 'fas fa-user fa-fw',
            'text' => lang('Menu.customers'),
            'href' => '',
            'children' => $customer,
        ];

        // Appearance
        $appearance = [];

        $appearance_admin = [];

        $appearance_admin[] = [
            'id' => 'menu-appearance-admin-theme',
            'icon' => 'far fa-dot-circle fa-fw',
            'text' => lang('Menu.themes'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/admin/theme'),
            'children' => [],
        ];

        $appearance[] = [
            'id' => 'menu-appearance-admin',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.admin'),
            'href' => '',
            'children' => $appearance_admin,
        ];

        $appearance_marketplace = [];

        $appearance_marketplace[] = [
            'id' => 'menu-appearance-marketplace-theme',
            'icon' => 'far fa-dot-circle fa-fw',
            'text' => lang('Menu.themes'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/theme'),
            'children' => [],
        ];

        $appearance_marketplace[] = [
            'id' => 'menu-appearance-marketplace-widget',
            'icon' => 'far fa-dot-circle fa-fw',
            'text' => lang('Menu.widgets'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget'),
            'children' => [],
        ];

        $appearance_marketplace[] = [
            'id' => 'menu-appearance-marketplace-layout',
            'icon' => 'far fa-dot-circle fa-fw',
            'text' => lang('Menu.layouts'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout'),
            'children' => [],
        ];

        $appearance[] = [
            'id' => 'menu-appearance-marketplace',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.marketplace'),
            'href' => '',
            'children' => $appearance_marketplace,
        ];

        $data['menus'][] = [
            'id' => 'menu-appearance',
            'icon' => 'fas fa-palette fa-fw',
            'text' => lang('Menu.appearance'),
            'href' => '',
            'children' => $appearance,
        ];

        // Localisation
        $localisation = [];

        $localisation[] = [
            'id' => 'menu-localisation-language',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.languages'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language'),
            'children' => [],
        ];

        $localisation[] = [
            'id' => 'menu-localisation-currency',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.currencies'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency'),
            'children' => [],
        ];

        $localisation[] = [
            'id' => 'menu-localisation-country',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.countries'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country'),
            'children' => [],
        ];

        $localisation[] = [
            'id' => 'menu-localisation-zone',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.zones'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone'),
            'children' => [],
        ];

        $localisation[] = [
            'id' => 'menu-localisation-geo-zone',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.geo_zones'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/geo_zone'),
            'children' => [],
        ];

        $localisation[] = [
            'id' => 'menu-localisation-weight-class',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.weight_classes'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class'),
            'children' => [],
        ];

        $localisation[] = [
            'id' => 'menu-localisation-length-class',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.length_classes'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class'),
            'children' => [],
        ];

        $localisation[] = [
            'id' => 'menu-localisation-order-status',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.order_statuses'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id' => 'menu-localisation',
            'icon' => 'fas fa-globe-americas fa-fw',
            'text' => lang('Menu.localisation'),
            'href' => '',
            'children' => $localisation,
        ];

        // Components
        $component = [];

        $component[] = [
            'id' => 'menu-component-analytics',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.analytics'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics'),
            'children' => [],
        ];

        $component[] = [
            'id' => 'menu-component-order-total',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.order_totals'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total'),
            'children' => [],
        ];

        $component[] = [
            'id' => 'menu-component-payment-method',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.payment_methods'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method'),
            'children' => [],
        ];

        $component[] = [
            'id' => 'menu-component-shipping-method',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.shipping_methods'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/shipping_method'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id' => 'menu-component',
            'icon' => 'fas fa-toolbox fa-fw',
            'text' => lang('Menu.components'),
            'href' => '',
            'children' => $component,
        ];

        // Plugins
        $plugin = [];

        $plugin[] = [
            'id' => 'menu-plugin-plugin',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.plugins'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/plugin/plugin'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id' => 'menu-plugin',
            'icon' => 'fas fa-puzzle-piece fa-fw',
            'text' => lang('Menu.plugins'),
            'href' => '',
            'children' => $plugin,
        ];

        // File Manager
        $file_manager = [];

        $file_manager[] = [
            'id' => 'menu-file-manager-image-manager',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.image_manager'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/file_manager/image_manager'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id' => 'menu-file-manager',
            'icon' => 'fas fa-photo-video fa-fw',
            'text' => lang('Menu.file_manager'),
            'href' => '',
            'children' => $file_manager,
        ];

        // Page
        $data['menus'][] = [
            'id' => 'menu-page',
            'icon' => 'fas fa-file fa-fw',
            'text' => lang('Menu.pages'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page'),
            'children' => [],
        ];

        // System
        $system = [];

        $system[] = [
            'id' => 'menu-system-setting',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.settings'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/system/setting'),
            'children' => [],
        ];

        $system[] = [
            'id' => 'menu-system-error-log',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.error_logs'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/system/error_log'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id' => 'menu-system',
            'icon' => 'fas fa-cogs fa-fw',
            'text' => lang('Menu.system'),
            'href' => '',
            'children' => $system,
        ];

        // Developer
        $developer = [];

        $developer[] = [
            'id' => 'menu-developer-language-editor',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.language_editor'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/language_editor'),
            'children' => [],
        ];

        $developer[] = [
            'id' => 'menu-developer-demo-manager',
            'icon' => 'fas fa-dot-circle fa-fw',
            'text' => lang('Menu.demo_manager'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/demo_manager'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id' => 'menu-developer',
            'icon' => 'fas fa-code fa-fw',
            'text' => lang('Menu.developer'),
            'href' => '',
            'children' => $developer,
        ];

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Common\column_left',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
