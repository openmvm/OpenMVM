<?php

namespace App\Controllers\Marketplace\Account;

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
        
        $data['action'] = $this->url->customerLink('marketplace/account/login');

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('email', lang('Entry.email'), 'required');
            $this->validation->setRule('password', lang('Entry.password'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Login
                $logged_in = $this->customer->login($this->request->getPost('email'), $this->request->getPost('password'));

                if ($logged_in) {
                    return redirect()->to($this->url->customerLink('marketplace/account/account', '', true));
                } else {
                    $this->session->set('error', lang('Error.login'));

                    return redirect()->to('marketplace/account/login');
                }
            } else {
                if ($this->validation->hasError('email')) {
                    $data['error_email'] = $this->validation->getError('email');
                } else {
                    $data['error_email'] = '';
                }

                if ($this->validation->hasError('password')) {
                    $data['error_password'] = $this->validation->getError('password');
                } else {
                    $data['error_password'] = '';
                }
           }
        }

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home'),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account'),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.login'),
            'href' => $this->url->customerLink('marketplace/account/login'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.login');

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        $data['register'] = $this->url->customerLink('marketplace/account/register');

        // Header
        $header_params = array(
            'title' => lang('Heading.login'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\login', $data);
    }
}
