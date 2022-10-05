<?php

namespace Main\Admin\Controllers\Component\Shipping_Method;

class Zone_Based extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_localisation_geo_zone = new \Main\Admin\Models\Localisation\Geo_Zone_Model();
        $this->model_system_setting = new \Main\Admin\Models\System\Setting_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/shipping_method/Zone_Based/save');

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
            'text' => lang('Text.shipping_methods'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/shipping_method'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.zone_based'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/shipping_method/zone_based'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.zone_based');

        $data['component_shipping_method_zone_based_amount'] = $this->model_system_setting->getSettingValue('component_shipping_method_zone_based_amount');

        $data['component_shipping_method_zone_based_sort_order'] = $this->model_system_setting->getSettingValue('component_shipping_method_zone_based_sort_order');

        $data['component_shipping_method_zone_based_status'] = $this->model_system_setting->getSettingValue('component_shipping_method_zone_based_status');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/shipping_method');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Component/Shipping_Method/Zone_Based')) {
            // Header
            $header_params = [
                'title' => lang('Heading.zone_based'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Component\Shipping_Method\zone_based', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.shipping_methods'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/shipping_method'),
                'active' => false,
            );
            
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.zone_based'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/shipping_method/zone_based'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.zone_based');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.zone_based'),
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
            if (!$this->administrator->hasPermission('modify', 'Component/Shipping_Method/Zone_Based')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            $this->validation->setRule('component_shipping_method_zone_based_amount', lang('Entry.amount'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('component_shipping_method_zone_based', $this->request->getPost());

                $json['success']['toast'] = lang('Success.shipping_method_edit');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/shipping_method');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                if ($this->validation->hasError('component_shipping_method_zone_based_amount')) {
                    $json['error']['amount'] = $this->validation->getError('component_shipping_method_zone_based_amount');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
