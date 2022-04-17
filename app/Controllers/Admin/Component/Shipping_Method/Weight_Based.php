<?php

namespace App\Controllers\Admin\Component\Shipping_Method;

class Weight_Based extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \App\Models\Admin\Localisation\Language_Model();
        $this->model_localisation_geo_zone = new \App\Models\Admin\Localisation\Geo_Zone_Model();
        $this->model_system_setting = new \App\Models\Admin\System\Setting_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/component/shipping_method/weight_based');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Component/Shipping_Method/Weight_Based')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/component/component/shipping_method'));
            }

            $this->validation->setRule('component_shipping_method_weight_based_amount', lang('Entry.amount'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('component_shipping_method_weight_based', $this->request->getPost());

                $this->session->set('success', lang('Success.shipping_method_edit'));

                return redirect()->to($this->url->administratorLink('admin/component/component/shipping_method'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('component_shipping_method_weight_based_amount')) {
                    $data['error_component_shipping_method_weight_based_amount'] = $this->validation->getError('component_shipping_method_weight_based_amount');
                } else {
                    $data['error_component_shipping_method_weight_based_amount'] = '';
                }
            }
        }

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.shipping_methods'),
            'href' => $this->url->administratorLink('admin/component/component/shipping_method'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.weight_based'),
            'href' => $this->url->administratorLink('admin/component/shipping_method/weight_based'),
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

        $data['heading_title'] = lang('Heading.weight_based');

        if ($this->request->getPost('component_shipping_method_weight_based_amount')) {
            $data['component_shipping_method_weight_based_amount'] = $this->request->getPost('component_shipping_method_weight_based_amount');
        } else {
            $data['component_shipping_method_weight_based_amount'] = $this->model_system_setting->getSettingValue('component_shipping_method_weight_based_amount');
        }

        if ($this->request->getPost('component_shipping_method_weight_based_sort_order')) {
            $data['component_shipping_method_weight_based_sort_order'] = $this->request->getPost('component_shipping_method_weight_based_sort_order');
        } else {
            $data['component_shipping_method_weight_based_sort_order'] = $this->model_system_setting->getSettingValue('component_shipping_method_weight_based_sort_order');
        }

        if ($this->request->getPost('component_shipping_method_weight_based_status')) {
            $data['component_shipping_method_weight_based_status'] = $this->request->getPost('component_shipping_method_weight_based_status');
        } else {
            $data['component_shipping_method_weight_based_status'] = $this->model_system_setting->getSettingValue('component_shipping_method_weight_based_status');
        }

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink('admin/component/component/shipping_method');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Component/Shipping_Method/Weight_Based')) {
            // Header
            $header_params = [
                'title' => lang('Heading.weight_based'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Component\Shipping_Method\weight_based', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.shipping_methods'),
                'href' => $this->url->administratorLink('admin/component/component/shipping_method'),
                'active' => false,
            );
            
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.weight_based'),
                'href' => $this->url->administratorLink('admin/component/shipping_method/weight_based'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.weight_based');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.weight_based'),
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
}
