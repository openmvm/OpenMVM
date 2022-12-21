<?php

namespace Main\Marketplace\Controllers\Seller;

class Dashboard extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.seller', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.dashboard', [], $this->language->getCurrentCode());

        // Widget
        $data['marketplace_common_widget'] = $this->marketplace_common_widget;

        // Header
        $header_params = array(
            'title' => lang('Heading.dashboard', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Seller\dashboard',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
