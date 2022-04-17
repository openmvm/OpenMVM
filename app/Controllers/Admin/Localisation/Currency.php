<?php

namespace App\Controllers\Admin\Localisation;

class Currency extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_currency = new \App\Models\Admin\Localisation\Currency_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/localisation/currency');

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('selected'))) {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Currency')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/localisation/currency'));
            }

            foreach ($this->request->getPost('selected') as $currency_id) {
                // Query
                $query = $this->model_localisation_currency->deleteCurrency($currency_id);
            }

            $this->session->set('success', lang('Success.currency_delete'));

            return redirect()->to($this->url->administratorLink('admin/localisation/currency'));
        }

        return $this->get_list($data);
    }

    public function add()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink('admin/localisation/currency/add');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Currency')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/localisation/currency/add'));
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');
            $this->validation->setRule('code', lang('Entry.code'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_localisation_currency->addCurrency($this->request->getPost());

                $this->session->set('success', lang('Success.currency_add'));

                return redirect()->to($this->url->administratorLink('admin/localisation/currency'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('name')) {
                    $data['error_name'] = $this->validation->getError('name');
                } else {
                    $data['error_name'] = '';
                }

                if ($this->validation->hasError('code')) {
                    $data['error_code'] = $this->validation->getError('code');
                } else {
                    $data['error_code'] = '';
                }
            }
        }

        return $this->get_form($data);
    }

    public function edit()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink('admin/localisation/currency/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Currency')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/localisation/currency/edit/' . $this->uri->getSegment($this->uri->getTotalSegments())));
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');
            $this->validation->setRule('code', lang('Entry.code'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_localisation_currency->editCurrency($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                $this->session->set('success', lang('Success.currency_edit'));

                return redirect()->to($this->url->administratorLink('admin/localisation/currency'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('name')) {
                    $data['error_name'] = $this->validation->getError('name');
                } else {
                    $data['error_name'] = '';
                }

                if ($this->validation->hasError('code')) {
                    $data['error_code'] = $this->validation->getError('code');
                } else {
                    $data['error_code'] = '';
                }
            }
        }

        return $this->get_form($data);
    }

    public function get_list($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.currencies'),
            'href' => $this->url->administratorLink('admin/localisation/currency'),
            'active' => true,
        );

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = lang('Heading.currencies');

        // Get currencies
        $data['currencies'] = [];

        $currencies = $this->model_localisation_currency->getCurrencies();

        foreach ($currencies as $currency) {
            $data['currencies'][] = [
                'currency_id' => $currency['currency_id'],
                'name' => $currency['name'],
                'code' => $currency['code'],
                'value' => $currency['value'],
                'sort_order' => $currency['sort_order'],
                'status' => $currency['status'] ? lang('Text.enabled') : lang('Text.disabled'),
                'href' => $this->url->administratorLink('admin/localisation/currency/edit/' . $currency['currency_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_marketplace_currency_id');

        $data['refresh'] = $this->url->administratorLink('admin/localisation/currency/refresh');
        $data['add'] = $this->url->administratorLink('admin/localisation/currency/add');
        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');
        		
        if ($this->administrator->hasPermission('access', 'Localisation/Currency')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.currencies'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\currency_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.currencies'),
                'href' => $this->url->administratorLink('admin/localisation/currency'),
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.currencies');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.currencies'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Common\permission', $data);
        }
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.currencies'),
            'href' => $this->url->administratorLink('admin/localisation/currency'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $currency_info = $this->model_localisation_currency->getCurrency($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $currency_info = [];
        }

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = lang('Heading.currencies');

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif ($currency_info) {
            $data['name'] = $currency_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('code')) {
            $data['code'] = $this->request->getPost('code');
        } elseif ($currency_info) {
            $data['code'] = $currency_info['code'];
        } else {
            $data['code'] = '';
        }

        if ($this->request->getPost('symbol_left')) {
            $data['symbol_left'] = $this->request->getPost('symbol_left');
        } elseif ($currency_info) {
            $data['symbol_left'] = $currency_info['symbol_left'];
        } else {
            $data['symbol_left'] = '';
        }

        if ($this->request->getPost('symbol_right')) {
            $data['symbol_right'] = $this->request->getPost('symbol_right');
        } elseif ($currency_info) {
            $data['symbol_right'] = $currency_info['symbol_right'];
        } else {
            $data['symbol_right'] = '';
        }

        if ($this->request->getPost('decimal_place')) {
            $data['decimal_place'] = $this->request->getPost('decimal_place');
        } elseif ($currency_info) {
            $data['decimal_place'] = $currency_info['decimal_place'];
        } else {
            $data['decimal_place'] = 0;
        }

        if ($this->request->getPost('value')) {
            $data['value'] = $this->request->getPost('value');
        } elseif ($currency_info) {
            $data['value'] = $currency_info['value'];
        } else {
            $data['value'] = '';
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif ($currency_info) {
            $data['sort_order'] = $currency_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($currency_info) {
            $data['status'] = $currency_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');

        if ($this->administrator->hasPermission('access', 'Localisation/Currency')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.currencies'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\currency_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.currencies'),
                'href' => $this->url->administratorLink('admin/localisation/currency'),
                'active' => false,
            );
    
            if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
                $data['breadcrumbs'][] = array(
                    'text' => lang('Text.edit'),
                    'href' => '',
                    'active' => true,
                );
            } else {
                $data['breadcrumbs'][] = array(
                    'text' => lang('Text.add'),
                    'href' => '',
                    'active' => true,
                );
            }
    
            $data['heading_title'] = lang('Heading.currencies');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.currencies'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Common\permission', $data);
        }
    }

    public function refresh()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        // Get default marketplace currency
        $currency_id = $this->currency->getDefaultId();

        $base_currency = $this->currency->getCode($currency_id);

        // Get current currency values
        $currency_value_data = [];

        $currency_values = $this->currency->refresh($base_currency);

        if (!empty($currency_values['data'])) {
            foreach ($currency_values['data'] as $key => $value) {
                $currency_value_data[$key] = $value;
            }

            // Get currencies
            $currencies = $this->model_localisation_currency->getCurrencies();

            foreach ($currencies as $currency) {
                if ($currency['code'] != $base_currency) {
                    // Update values
                    $this->model_localisation_currency->updateValue($currency['currency_id'], $currency_value_data[$currency['code']]);
                } else {
                    // Update values
                    $this->model_localisation_currency->updateValue($currency['currency_id'], 1);
                }
            }
        }

        return redirect()->to($this->url->administratorLink('admin/localisation/currency'));
    }
}
