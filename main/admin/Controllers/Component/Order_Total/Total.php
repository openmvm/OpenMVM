<?php

namespace Main\Admin\Controllers\Component\Order_Total;

class Total extends \App\Controllers\BaseController
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
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/order_total/Total/save');

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
            'text' => lang('Text.total'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/order_total/total'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.total');

        $data['component_order_total_total_sort_order'] = $this->model_system_setting->getSettingValue('component_order_total_total_sort_order');

        $data['component_order_total_total_status'] = $this->model_system_setting->getSettingValue('component_order_total_total_status');

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $header_params = [
            'title' => lang('Heading.total'),
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
            'view' => 'Component\Order_Total\total',
            'permission' => 'Component/Order_Total/Total',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
    
    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Component/Order_Total/Total')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            // Query
            $query = $this->model_system_setting->editSetting('component_order_total_total', $this->request->getPost());

            $json['success']['toast'] = lang('Success.order_total_edit');

            $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total');
        }

        return $this->response->setJSON($json);
    }
}
