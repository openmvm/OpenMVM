<?php

namespace App\Controllers\Marketplace\Account;

class Register extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_customer_customer = new \App\Models\Marketplace\Customer\Customer_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->customerLink('marketplace/account/register');

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric|is_unique[customer.username]|min_length[2]|max_length[35]');
            $this->validation->setRule('firstname', lang('Entry.firstname'), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname'), 'required');
            $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email|is_unique[customer.email]');
            $this->validation->setRule('password', lang('Entry.password'), 'required');
            $this->validation->setRule('passconf', lang('Entry.passconf'), 'required|matches[password]');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_customer_customer->addCustomer($this->request->getPost());

                $this->session->set('success', lang('Success.customer_add'));

                return redirect()->to($this->url->customerLink('marketplace/account/account', '', true));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('username')) {
                    $data['error_username'] = $this->validation->getError('username');
                } else {
                    $data['error_username'] = '';
                }

                if ($this->validation->hasError('firstname')) {
                    $data['error_firstname'] = $this->validation->getError('firstname');
                } else {
                    $data['error_firstname'] = '';
                }

                if ($this->validation->hasError('lastname')) {
                    $data['error_lastname'] = $this->validation->getError('lastname');
                } else {
                    $data['error_lastname'] = '';
                }

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
            'text' => lang('Text.register'),
            'href' => $this->url->customerLink('marketplace/account/register'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.register');

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('username')) {
            $data['username'] = $this->request->getPost('username');
        } else {
            $data['username'] = '';
        }

        $data['login'] = $this->url->customerLink('marketplace/account/login');

        // Widget
        $data['marketplace_common_widget'] = $this->marketplace_common_widget;

        // Header
        $header_params = array(
            'title' => lang('Heading.register'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\register', $data);
    }
}
