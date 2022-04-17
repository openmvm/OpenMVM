<?php

namespace App\Controllers\Admin\Component\Payment_Method;

class Cash_On_Delivery extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \App\Models\Admin\Localisation\Language_Model();
        $this->model_localisation_geo_zone = new \App\Models\Admin\Localisation\Geo_Zone_Model();
        $this->model_localisation_order_status = new \App\Models\Admin\Localisation\Order_Status_Model();
        $this->model_system_setting = new \App\Models\Admin\System\Setting_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/component/payment_method/cash_on_delivery');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Component/Payment_Method/Cash_On_Delivery')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/component/component/payment_method'));
            }

            $this->validation->setRule('component_payment_method_cash_on_delivery_amount', lang('Entry.amount'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('component_payment_method_cash_on_delivery', $this->request->getPost());

                $this->session->set('success', lang('Success.payment_method_edit'));

                return redirect()->to($this->url->administratorLink('admin/component/component/payment_method'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('component_payment_method_cash_on_delivery_amount')) {
                    $data['error_component_payment_method_cash_on_delivery_amount'] = $this->validation->getError('component_payment_method_cash_on_delivery_amount');
                } else {
                    $data['error_component_payment_method_cash_on_delivery_amount'] = '';
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
            'text' => lang('Text.payment_methods'),
            'href' => $this->url->administratorLink('admin/component/component/payment_method'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.cash_on_delivery'),
            'href' => $this->url->administratorLink('admin/component/payment_method/cash_on_delivery'),
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

        $data['heading_title'] = lang('Heading.cash_on_delivery');

        $languages = $this->model_localisation_language->getlanguages();

        foreach ($languages as $language) {
            if ($this->request->getPost('component_payment_method_cash_on_delivery_instruction_' . $language['language_id'])) {
                $data['component_payment_method_cash_on_delivery_instruction_' . $language['language_id']] = $this->request->getPost('component_payment_method_cash_on_delivery_instruction_' . $language['language_id']);
            } else {
                $data['component_payment_method_cash_on_delivery_instruction_' . $language['language_id']] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_instruction_' . $language['language_id']);
            }
        }

        if ($this->request->getPost('component_payment_method_cash_on_delivery_amount')) {
            $data['component_payment_method_cash_on_delivery_amount'] = $this->request->getPost('component_payment_method_cash_on_delivery_amount');
        } else {
            $data['component_payment_method_cash_on_delivery_amount'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_amount');
        }

        if ($this->request->getPost('component_payment_method_cash_on_delivery_geo_zone_id')) {
            $data['component_payment_method_cash_on_delivery_geo_zone_id'] = $this->request->getPost('component_payment_method_cash_on_delivery_geo_zone_id');
        } else {
            $data['component_payment_method_cash_on_delivery_geo_zone_id'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_geo_zone_id');
        }

        if ($this->request->getPost('component_payment_method_cash_on_delivery_order_status_id')) {
            $data['component_payment_method_cash_on_delivery_order_status_id'] = $this->request->getPost('component_payment_method_cash_on_delivery_order_status_id');
        } else {
            $data['component_payment_method_cash_on_delivery_order_status_id'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_order_status_id');
        }

        if ($this->request->getPost('component_payment_method_cash_on_delivery_sort_order')) {
            $data['component_payment_method_cash_on_delivery_sort_order'] = $this->request->getPost('component_payment_method_cash_on_delivery_sort_order');
        } else {
            $data['component_payment_method_cash_on_delivery_sort_order'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_sort_order');
        }

        if ($this->request->getPost('component_payment_method_cash_on_delivery_status')) {
            $data['component_payment_method_cash_on_delivery_status'] = $this->request->getPost('component_payment_method_cash_on_delivery_status');
        } else {
            $data['component_payment_method_cash_on_delivery_status'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_status');
        }

        $data['languages'] = $languages;

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink('admin/component/component/payment_method');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Component/Payment_Method/Cash_On_Delivery')) {
            // Header
            $header_params = [
                'title' => lang('Heading.cash_on_delivery'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Component\Payment_Method\cash_on_delivery', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.payment_methods'),
                'href' => $this->url->administratorLink('admin/component/component/payment_method'),
                'active' => false,
            );
            
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.cash_on_delivery'),
                'href' => $this->url->administratorLink('admin/component/payment_method/cash_on_delivery'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.cash_on_delivery');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.cash_on_delivery'),
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
