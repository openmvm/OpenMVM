<?php

namespace Main\Admin\Controllers\Component\Analytics;

class Google_Analytics_4 extends \App\Controllers\BaseController
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
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/analytics/Google_Analytics_4/save');

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
            'text' => lang('Text.analytics'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.google_analytics_4'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/analytics/google_analytics_4'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.google_analytics_4');

        $data['component_analytics_google_analytics_4_global_site_tag'] = $this->model_system_setting->getSettingValue('component_analytics_google_analytics_4_global_site_tag');

        $data['component_analytics_google_analytics_4_sort_order'] = $this->model_system_setting->getSettingValue('component_analytics_google_analytics_4_sort_order');

        $data['component_analytics_google_analytics_4_status'] = $this->model_system_setting->getSettingValue('component_analytics_google_analytics_4_status');

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics');

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
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.analytics'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics'),
                'active' => false,
            );
            
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.google_analytics_4'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/analytics/google_analytics_4'),
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

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Component/Analytics/Google_Analytics_4')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            $this->validation->setRule('component_analytics_google_analytics_4_global_site_tag', lang('Entry.global_site_tag'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('component_analytics_google_analytics_4', $this->request->getPost());

                $json['success']['toast'] = $this->session->set('success', lang('Success.analytics_edit'));

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                if ($this->validation->hasError('component_analytics_google_analytics_4_global_site_tag')) {
                    $json['error']['global-site-tag'] = $this->validation->getError('component_analytics_google_analytics_4_global_site_tag');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
