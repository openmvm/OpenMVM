<?php

namespace Main\Admin\Controllers\Localisation;

class Currency extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_currency = new \Main\Admin\Models\Localisation\Currency_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        return $this->get_form($data);
    }

    public function get_list($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.currencies'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency'),
            'active' => true,
        );

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
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency/edit/' . $currency['currency_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_marketplace_currency_id');

        $data['refresh'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency/refresh');
        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
    		
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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Localisation\currency_list',
            'permission' => 'Localisation/Currency',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.currencies'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency'),
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

        $data['heading_title'] = lang('Heading.currencies');

        if ($currency_info) {
            $data['name'] = $currency_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($currency_info) {
            $data['code'] = $currency_info['code'];
        } else {
            $data['code'] = '';
        }

        if ($currency_info) {
            $data['symbol_left'] = $currency_info['symbol_left'];
        } else {
            $data['symbol_left'] = '';
        }

        if ($currency_info) {
            $data['symbol_right'] = $currency_info['symbol_right'];
        } else {
            $data['symbol_right'] = '';
        }

        if ($currency_info) {
            $data['decimal_place'] = $currency_info['decimal_place'];
        } else {
            $data['decimal_place'] = 0;
        }

        if ($currency_info) {
            $data['value'] = $currency_info['value'];
        } else {
            $data['value'] = '';
        }

        if ($currency_info) {
            $data['sort_order'] = $currency_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($currency_info) {
            $data['status'] = $currency_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');

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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Localisation\currency_form',
            'permission' => 'Localisation/Currency',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Currency')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $currency_id) {
                        // Query
                        $query = $this->model_localisation_currency->deleteCurrency($currency_id);
                    }

                    $json['success']['toast'] = lang('Success.currency_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency');
                } else {
                    $json['error']['toast'] = lang('Error.administrator_delete');
                }                
            }

        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Currency')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $this->validation->setRule('name', lang('Entry.name'), 'required');
                $this->validation->setRule('code', lang('Entry.code'), 'required');

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_localisation_currency->editCurrency($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.currency_edit');
                    } else {
                        // Query
                        $query = $this->model_localisation_currency->addCurrency($this->request->getPost());

                        $json['success']['toast'] = lang('Success.currency_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    if ($this->validation->hasError('name')) {
                        $json['error']['name'] = $this->validation->getError('name');
                    }

                    if ($this->validation->hasError('code')) {
                        $json['error']['code'] = $this->validation->getError('code');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function refresh()
    {
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

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/currency'));
    }
}
