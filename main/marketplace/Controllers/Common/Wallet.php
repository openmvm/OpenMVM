<?php

namespace Main\Marketplace\Controllers\Common;

class Wallet extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->currency = new \App\Libraries\Currency();
        $this->customer = new \App\Libraries\Customer();
        $this->request = \Config\Services::request();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
    }

    public function index($search_params = array())
    {
        // Wallet
        $data['balance'] = $this->currency->format($this->customer->getWalletBalance(), $this->currency->getCurrentCode());

        $data['wallet'] = $this->url->customerLink('marketplace/account/wallet', '', true);

        $data['logged_in'] = $this->customer->isLoggedIn();

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Common\wallet',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
