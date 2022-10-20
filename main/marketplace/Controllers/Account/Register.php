<?php

namespace Main\Marketplace\Controllers\Account;

class Register extends \App\Controllers\BaseController
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
        $data['action'] = $this->url->customerLink('marketplace/account/register/go');

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
            'text' => lang('Text.register', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/register'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.register', [], $this->language->getCurrentCode());

        $data['login'] = $this->url->customerLink('marketplace/account/login');

        // Widget
        $data['marketplace_common_widget'] = $this->marketplace_common_widget;

        // Libraries
        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.register', [], $this->language->getCurrentCode()),
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
            'view' => 'Account\register',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function go()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $this->validation->setRule('username', lang('Entry.username', [], $this->language->getCurrentCode()), 'required|alpha_numeric|is_unique[customer.username]|min_length[2]|max_length[35]');
            $this->validation->setRule('firstname', lang('Entry.firstname', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('email', lang('Entry.email', [], $this->language->getCurrentCode()), 'required|valid_email|is_unique[customer.email]');
            $this->validation->setRule('password', lang('Entry.password', [], $this->language->getCurrentCode()), 'required');
            $this->validation->setRule('passconf', lang('Entry.passconf', [], $this->language->getCurrentCode()), 'required|matches[password]');

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                // Query
                $query = $this->model_customer_customer->addCustomer($json_data);

                $json['success']['toast'] = lang('Success.customer_add', [], $this->language->getCurrentCode());

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

                if ($this->validation->hasError('email')) {
                    $json['error']['email'] = $this->validation->getError('email');
                }

                if ($this->validation->hasError('password')) {
                    $json['error']['password'] = $this->validation->getError('password');
                }

                if ($this->validation->hasError('passconf')) {
                    $json['error']['passconf'] = $this->validation->getError('passconf');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
