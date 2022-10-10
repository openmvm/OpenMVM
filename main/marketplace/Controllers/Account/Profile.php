<?php

namespace Main\Marketplace\Controllers\Account;

class Profile extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->customerLink('marketplace/account/profile/save', '', true);

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
            'text' => lang('Text.edit_profile', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/profile', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.edit_profile', [], $this->language->getCurrentCode());
            
        $customer_info = $this->model_customer_customer->getCustomer($this->customer->getId());

        $data['username'] = $customer_info['username'];

        $data['firstname'] = $customer_info['firstname'];

        $data['lastname'] = $customer_info['lastname'];

        if (!empty($customer_info['telephone'])) {
            $data['telephone'] = $customer_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        $data['email'] = $customer_info['email'];

        // Header
        $header_params = array(
            'title' => lang('Heading.edit_profile', [], $this->language->getCurrentCode()),
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
            'view' => 'Account\profile',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            if ($this->customer->getUsername() == $json_data['username']) {
                $this->validation->setRule('username', lang('Entry.username', [], $this->language->getCurrentCode()), 'required|alpha_numeric_space|min_length[2]|max_length[35]');
            } else {
                $this->validation->setRule('username', lang('Entry.username', [], $this->language->getCurrentCode()), 'required|alpha_numeric_space|is_unique[customer.username]|min_length[2]|max_length[35]');
            }

            $this->validation->setRule('firstname', lang('Entry.firstname', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('telephone', lang('Entry.telephone', [], $this->language->getCurrentCode()), 'required');

            if ($this->customer->getEmail() == $json_data['email']) {
                $this->validation->setRule('email', lang('Entry.email', [], $this->language->getCurrentCode()), 'required|valid_email');
            } else {
                $this->validation->setRule('email', lang('Entry.email', [], $this->language->getCurrentCode()), 'required|valid_email|is_unique[customer.email]');
            }

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                // Query
                $query = $this->model_customer_customer->editCustomer($this->customer->getId(), $json_data);

                $json['success']['toast'] = lang('Success.profile_edit', [], $this->language->getCurrentCode());

                $json['redirect'] = $this->url->customerLink('marketplace/account/account', '', true);
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());

                if ($this->validation->hasError('username')) {
                    $json['error']['username'] = $this->validation->getError('username');
                }

                if ($this->validation->hasError('firstname')) {
                    $json['error']['firstname'] = $this->validation->getError('firstname');
                }

                if ($this->validation->hasError('lastname')) {
                    $json['error']['lastname'] = $this->validation->getError('lastname');
                }

                if ($this->validation->hasError('telephone')) {
                    $json['error']['telephone'] = $this->validation->getError('telephone');
                }

                if ($this->validation->hasError('email')) {
                    $json['error']['email'] = $this->validation->getError('email');
                }
           }
        }

        return $this->response->setJSON($json);
    }
}
