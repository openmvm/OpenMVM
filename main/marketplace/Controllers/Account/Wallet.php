<?php

namespace Main\Marketplace\Controllers\Account;

class Wallet extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_account_wallet = new \Main\Marketplace\Models\Account\Wallet_Model();
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
            'text' => lang('Text.my_wallet', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/wallet', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.my_wallet', [], $this->language->getCurrentCode());

        // Wallet
        $data['balance'] = $this->currency->format($this->customer->getWalletBalance(), $this->currency->getCurrentCode());

        // Get customer wallets
        $data['wallets'] = [];

        $wallets = $this->model_account_wallet->getWallets($this->customer->getId());

        foreach ($wallets as $wallet) {
            $data['wallets'][] = [
                'wallet_id' => $wallet['wallet_id'],
                'customer_id' => $wallet['customer_id'],
                'amount' => $wallet['amount'],
                'description' => $wallet['description'][$this->language->getCurrentId()],
                'comment' => $wallet['comment'][$this->language->getCurrentId()],
                'date_added' => $wallet['date_added'],
            ];
        }

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.my_wallet', [], $this->language->getCurrentCode()),
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
            'view' => 'Account\wallet',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
