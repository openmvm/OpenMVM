<?php

namespace Main\Marketplace\Controllers\Account;

class Account extends \App\Controllers\BaseController
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
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.my_account', [], $this->language->getCurrentCode());

        // Header
        $header_params = array(
            'title' => lang('Heading.my_account', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\account', $data);
    }
}
