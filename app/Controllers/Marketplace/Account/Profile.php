<?php

namespace App\Controllers\Marketplace\Account;

class Profile extends \App\Controllers\BaseController
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
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['action'] = $this->url->customerLink('marketplace/account/profile', '', true);

        if ($this->request->getMethod() == 'post') {
            if ($this->customer->getUsername() == $this->request->getPost('username')) {
                $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|min_length[2]|max_length[35]');
            } else {
                $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|is_unique[customer.username]|min_length[2]|max_length[35]');
            }

            $this->validation->setRule('firstname', lang('Entry.firstname'), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname'), 'required');
            $this->validation->setRule('telephone', lang('Entry.telephone'), 'required');

            if ($this->customer->getEmail() == $this->request->getPost('email')) {
                $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email');
            } else {
                $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email|is_unique[customer.email]');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_customer_customer->editCustomer($this->customer->getId(), $this->request->getPost());

                $this->session->set('success', lang('Success.profile_edit'));

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

                if ($this->validation->hasError('telephone')) {
                    $data['error_telephone'] = $this->validation->getError('telephone');
                } else {
                    $data['error_telephone'] = '';
                }

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
            'text' => lang('Text.edit_profile'),
            'href' => $this->url->customerLink('marketplace/account/profile', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.edit_profile');
            
        $customer_info = $this->model_customer_customer->getCustomer($this->customer->getId());

        if ($this->request->getPost('username')) {
            $data['username'] = $this->request->getPost('username');
        } elseif ($customer_info) {
            $data['username'] = $customer_info['username'];
        } else {
            $data['username'] = '';
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif ($customer_info) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif ($customer_info) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('telephone')) {
            $data['telephone'] = $this->request->getPost('telephone');
        } elseif ($customer_info) {
            $data['telephone'] = $customer_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } elseif ($customer_info) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }

        // Header
        $header_params = array(
            'title' => lang('Heading.edit_profile'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Account\profile', $data);
    }
}
