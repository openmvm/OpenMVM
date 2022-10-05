<?php

namespace Main\Marketplace\Controllers\Account;

class Reset_Password extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_account_reset_password = new \Main\Marketplace\Models\Account\Reset_Password_Model();
    }

    public function index()
    {
        // Logged out customer
        $this->customer->logout();
        
        $data['action'] = $this->url->customerLink('marketplace/account/reset_password');

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('email', lang('Entry.email', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_account_reset_password->addResetPassword($this->request->getPost());

                $this->session->set('success', lang('Success.reset_password', [], $this->language->getCurrentCode()));
                
                return redirect()->to('marketplace/account/reset_password');
            } else {
                if ($this->validation->hasError('email')) {
                    $data['error_email'] = $this->validation->getError('email');
                } else {
                    $data['error_email'] = '';
                }
           }
        }

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
            'text' => lang('Text.reset_password', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/reset_password'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.reset_password', [], $this->language->getCurrentCode());

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        $data['reset_password_instruction'] = sprintf(lang('Text.reset_password_instruction', [], $this->language->getCurrentCode()), $this->setting->get('setting_marketplace_name'), $this->setting->get('setting_marketplace_name'));

        // Header
        $header_params = array(
            'title' => lang('Heading.reset_password', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\reset_password', $data);
    }

    public function confirm()
    {
        if (empty($this->request->getGet('token'))) {
            return redirect()->to('marketplace/account/reset_password');
        }

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
            'text' => lang('Text.reset_password', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/reset_password'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.confirm', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/reset_password/confirm'),
            'active' => true,
        );

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('email', lang('Entry.email', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('password', lang('Entry.password', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('passconf', lang('Entry.passconf', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Verify token
                $verify_token = $this->model_account_reset_password->verifyToken($this->request->getGet('token'), $this->request->getPost('email'));

                if ($verify_token) {
                    // Set a new password
                    $query = $this->model_account_reset_password->resetPassword($this->request->getPost('email'), $this->request->getPost('password'));

                    $this->session->set('success', lang('Success.reset_password_confirm', [], $this->language->getCurrentCode()));
                } else {
                    $this->session->set('error', lang('Error.reset_password_confirm', [], $this->language->getCurrentCode()));
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

                if ($this->validation->hasError('passconf')) {
                    $data['error_passconf'] = $this->validation->getError('passconf');
                } else {
                    $data['error_passconf'] = '';
                }
            }
        }
        
        $data['action'] = $this->url->customerLink('marketplace/account/reset_password/confirm?token=' . $this->request->getGet('token'));

        $data['heading_title'] = lang('Heading.reset_password', [], $this->language->getCurrentCode());

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        $data['reset_password_confirm_instruction'] = lang('Text.reset_password_confirm_instruction', [], $this->language->getCurrentCode());

        // Header
        $header_params = array(
            'title' => lang('Heading.reset_password', [], $this->language->getCurrentCode()),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\reset_password_confirm', $data);
    }
}
