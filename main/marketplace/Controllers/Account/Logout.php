<?php

namespace Main\Marketplace\Controllers\Account;

class Logout extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        // Remove cart key session
        $this->session->remove('shopping_cart_key');

        // Logged out customer
        $this->customer->logout();

        $this->session->set('success', lang('Success.logout', [], $this->language->getCurrentCode()));

        return redirect()->to('marketplace/account/login');
    }
}
