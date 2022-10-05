<?php

namespace Main\Admin\Controllers\Component\Order_Total;

class Shipping extends \App\Controllers\BaseController
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
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/order_total/Shipping/save');

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
            'text' => lang('Text.order_totals'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.shipping'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/order_total/shipping'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.shipping');

        $data['component_order_total_shipping_sort_order'] = $this->model_system_setting->getSettingValue('component_order_total_shipping_sort_order');

        $data['component_order_total_shipping_status'] = $this->model_system_setting->getSettingValue('component_order_total_shipping_status');

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Component/Order_Total/Shipping')) {
            // Header
            $header_params = [
                'title' => lang('Heading.shipping'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Component\Order_Total\shipping', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.order_totals'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total'),
                'active' => false,
            );
            
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.shipping'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/order_total/shipping'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.shipping');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.shipping'),
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
            if (!$this->administrator->hasPermission('modify', 'Component/Order_Total/Shipping')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            // Query
            $query = $this->model_system_setting->editSetting('component_order_total_shipping', $this->request->getPost());

            $json['success']['toast'] = lang('Success.order_total_edit');

            $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total');
        }

        return $this->response->setJSON($json);
    }
}
