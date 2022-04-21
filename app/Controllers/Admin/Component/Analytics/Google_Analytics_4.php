<?php

namespace App\Controllers\Admin\Component\Analytics;

class Google_Analytics_4 extends \App\Controllers\BaseController
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

        $data['action'] = $this->url->administratorLink('admin/component/analytics/google_analytics_4');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Component/Analytics/Google_Analytics_4')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/component/component/analytics'));
            }

            $this->validation->setRule('component_analytics_google_analytics_4_global_site_tag', lang('Entry.global_site_tag'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('component_analytics_google_analytics_4', $this->request->getPost());

                $this->session->set('success', lang('Success.analytics_edit'));

                return redirect()->to($this->url->administratorLink('admin/component/component/analytics'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('component_analytics_google_analytics_4_global_site_tag')) {
                    $data['error_component_analytics_google_analytics_4_global_site_tag'] = $this->validation->getError('component_analytics_google_analytics_4_global_site_tag');
                } else {
                    $data['error_component_analytics_google_analytics_4_global_site_tag'] = '';
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
            'text' => lang('Text.analytics'),
            'href' => $this->url->administratorLink('admin/component/component/analytics'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.google_analytics_4'),
            'href' => $this->url->administratorLink('admin/component/analytics/google_analytics_4'),
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

        $data['heading_title'] = lang('Heading.google_analytics_4');

        if ($this->request->getPost('component_analytics_google_analytics_4_global_site_tag')) {
            $data['component_analytics_google_analytics_4_global_site_tag'] = $this->request->getPost('component_analytics_google_analytics_4_global_site_tag');
        } else {
            $data['component_analytics_google_analytics_4_global_site_tag'] = $this->model_system_setting->getSettingValue('component_analytics_google_analytics_4_global_site_tag');
        }

        if ($this->request->getPost('component_analytics_google_analytics_4_sort_order')) {
            $data['component_analytics_google_analytics_4_sort_order'] = $this->request->getPost('component_analytics_google_analytics_4_sort_order');
        } else {
            $data['component_analytics_google_analytics_4_sort_order'] = $this->model_system_setting->getSettingValue('component_analytics_google_analytics_4_sort_order');
        }

        if ($this->request->getPost('component_analytics_google_analytics_4_status')) {
            $data['component_analytics_google_analytics_4_status'] = $this->request->getPost('component_analytics_google_analytics_4_status');
        } else {
            $data['component_analytics_google_analytics_4_status'] = $this->model_system_setting->getSettingValue('component_analytics_google_analytics_4_status');
        }

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink('admin/component/component/analytics');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Component/Analytics/Google_Analytics_4')) {
            // Header
            $header_params = [
                'title' => lang('Heading.google_analytics_4'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Component\Analytics\google_analytics_4', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.analytics'),
                'href' => $this->url->administratorLink('admin/component/component/analytics'),
                'active' => false,
            );
            
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.google_analytics_4'),
                'href' => $this->url->administratorLink('admin/component/analytics/google_analytics_4'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.google_analytics_4');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.google_analytics_4'),
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
