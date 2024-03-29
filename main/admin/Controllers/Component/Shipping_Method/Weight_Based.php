<?php

namespace Main\Admin\Controllers\Component\Shipping_Method;

class Weight_Based extends \App\Controllers\BaseController
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
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/shipping_method/Weight_Based/save');

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
            'text' => lang('Text.weight_based'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/shipping_method/weight_based'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.weight_based');

        $data['component_shipping_method_weight_based_amount'] = $this->model_system_setting->getSettingValue('component_shipping_method_weight_based_amount');

        $data['component_shipping_method_weight_based_sort_order'] = $this->model_system_setting->getSettingValue('component_shipping_method_weight_based_sort_order');

        $data['component_shipping_method_weight_based_status'] = $this->model_system_setting->getSettingValue('component_shipping_method_weight_based_status');

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/shipping_method');

        $data['administrator_token'] = $this->administrator->getToken();

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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Component\Shipping_Method\weight_based',
            'permission' => 'Component/Shipping_Method/Weight_Based',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Component/Shipping_Method/Weight_Based')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            $this->validation->setRule('component_shipping_method_weight_based_amount', lang('Entry.amount'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('component_shipping_method_weight_based', $this->request->getPost());

                $json['success']['toast'] = lang('Success.shipping_method_edit');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/shipping_method');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                if ($this->validation->hasError('component_shipping_method_weight_based_amount')) {
                    $json['error']['amount'] = $this->validation->getError('component_shipping_method_weight_based_amount');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
