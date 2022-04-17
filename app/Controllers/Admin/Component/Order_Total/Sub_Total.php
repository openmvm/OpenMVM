<?php

namespace App\Controllers\Admin\Component\Order_Total;

class Sub_Total extends \App\Controllers\BaseController
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

        $data['action'] = $this->url->administratorLink('admin/component/order_total/sub_total');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Component/Order_Total/Sub_Total')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/component/component/order_total'));
            }

            // Query
            $query = $this->model_system_setting->editSetting('component_order_total_sub_total', $this->request->getPost());

            $this->session->set('success', lang('Success.order_total_edit'));

            return redirect()->to($this->url->administratorLink('admin/component/component/order_total'));
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
            'text' => lang('Text.order_totals'),
            'href' => $this->url->administratorLink('admin/component/component/order_total'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.sub_total'),
            'href' => $this->url->administratorLink('admin/component/order_total/sub_total'),
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

        $data['heading_title'] = lang('Heading.sub_total');

        if ($this->request->getPost('component_order_total_sub_total_sort_order')) {
            $data['component_order_total_sub_total_sort_order'] = $this->request->getPost('component_order_total_sub_total_sort_order');
        } else {
            $data['component_order_total_sub_total_sort_order'] = $this->model_system_setting->getSettingValue('component_order_total_sub_total_sort_order');
        }

        if ($this->request->getPost('component_order_total_sub_total_status')) {
            $data['component_order_total_sub_total_status'] = $this->request->getPost('component_order_total_sub_total_status');
        } else {
            $data['component_order_total_sub_total_status'] = $this->model_system_setting->getSettingValue('component_order_total_sub_total_status');
        }

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink('admin/component/component/order_total');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Component/Order_Total/Sub_Total')) {
            // Header
            $header_params = [
                'title' => lang('Heading.sub_total'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Component\Order_Total\sub_total', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.order_totals'),
                'href' => $this->url->administratorLink('admin/component/component/order_total'),
                'active' => false,
            );
            
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.sub_total'),
                'href' => $this->url->administratorLink('admin/component/order_total/sub_total'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.sub_total');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.sub_total'),
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
