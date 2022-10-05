<?php

namespace Main\Admin\Controllers\Component\Payment_Method;

class Cash_On_Delivery extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_localisation_geo_zone = new \Main\Admin\Models\Localisation\Geo_Zone_Model();
        $this->model_localisation_order_status = new \Main\Admin\Models\Localisation\Order_Status_Model();
        $this->model_system_setting = new \Main\Admin\Models\System\Setting_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/payment_method/Cash_On_Delivery/save');

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.payment_methods'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.cash_on_delivery'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/payment_method/cash_on_delivery'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.cash_on_delivery');

        $languages = $this->model_localisation_language->getlanguages();

        foreach ($languages as $language) {
            $data['component_payment_method_cash_on_delivery_instruction_' . $language['language_id']] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_instruction_' . $language['language_id']);
        }

        $data['component_payment_method_cash_on_delivery_amount'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_amount');

        $data['component_payment_method_cash_on_delivery_geo_zone_id'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_geo_zone_id');

        $data['component_payment_method_cash_on_delivery_order_status_id'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_order_status_id');

        $data['component_payment_method_cash_on_delivery_sort_order'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_sort_order');

        $data['component_payment_method_cash_on_delivery_status'] = $this->model_system_setting->getSettingValue('component_payment_method_cash_on_delivery_status');

        $data['languages'] = $languages;

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method');

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
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.payment_methods'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method'),
                'active' => false,
            );
            
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.cash_on_delivery'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/payment_method/cash_on_delivery'),
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

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Component/Payment_Method/Cash_On_Delivery')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            $this->validation->setRule('component_payment_method_cash_on_delivery_amount', lang('Entry.amount'), 'required');

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('component_payment_method_cash_on_delivery_instruction_' . $language['language_id'], lang('Entry.instructions') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('component_payment_method_cash_on_delivery', $this->request->getPost());

                $json['success']['toast'] = lang('Success.payment_method_edit');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('component_payment_method_cash_on_delivery_instruction_' . $language['language_id'])) {
                        $json['error']['instruction-' . $language['language_id']] = $this->validation->getError('component_payment_method_cash_on_delivery_instruction_' . $language['language_id']);
                    }
                }

                if ($this->validation->hasError('component_payment_method_cash_on_delivery_amount')) {
                    $json['error']['amount'] = $this->validation->getError('component_payment_method_cash_on_delivery_amount');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
