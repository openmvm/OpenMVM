<?php

namespace Main\Marketplace\Controllers\Account;

class Login extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        // Logged out customer
        $this->customer->logout();
        
        $data['action'] = $this->url->customerLink('marketplace/account/login/go');

        return $this->get_form($data);
    }

    public function get_form($data)
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
            'text' => lang('Text.login', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/login'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.login', [], $this->language->getCurrentCode());

        $data['reset_password'] = $this->url->customerLink('marketplace/account/reset_password');
        $data['register'] = $this->url->customerLink('marketplace/account/register');

        // Header
        $header_params = array(
            'title' => lang('Heading.login', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\login', $data);
    }

    public function go()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $this->validation->setRule('email', lang('Entry.email', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('password', lang('Entry.password', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                // Login
                $logged_in = $this->customer->login($json_data['email'], $json_data['password']);

                if ($logged_in) {
                    // Success
                    $json['success']['toast'] = lang('Success.login', [], $this->language->getCurrentCode());

                    $json['redirect'] = $this->url->customerLink('marketplace/account/account', '', true);
                } else {
                    $json['error']['toast'] = lang('Error.login', [], $this->language->getCurrentCode());
                }
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], 'en');

                if ($this->validation->hasError('email')) {
                    $json['error']['email'] = $this->validation->getError('email');
                }

                if ($this->validation->hasError('password')) {
                    $json['error']['password'] = $this->validation->getError('password');
                }
           }
        }

        return $this->response->setJSON($json);
    }
}
