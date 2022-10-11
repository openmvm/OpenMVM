<?php

namespace Main\Admin\Controllers\System;

class Performance extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_system_setting = new \Main\Admin\Models\System\Setting_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/system/performance/save');

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
            'text' => lang('Text.performance'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/system/performance'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.performance');

        // Cache
        $data['performance_cache_ttl'] = $this->model_system_setting->getSettingValue('performance_cache_ttl');

        $data['performance_cache_status'] = $this->model_system_setting->getSettingValue('performance_cache_status');

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
        $data['clear_cache'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/system/performance/clear_cache');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $header_params = [
            'title' => lang('Heading.performance'),
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
            'view' => 'System\performance',
            'permission' => 'System/Performance',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('performance_cache_ttl', lang('Entry.cache_ttl'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_system_setting->editSetting('performance', $this->request->getPost());

                $json['success']['toast'] = lang('Success.performance_edit');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/system/performance');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                if ($this->validation->hasError('performance_cache_ttl')) {
                    $json['error']['cache-ttl'] = $this->validation->getError('performance_cache_ttl');
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function clear_cache()
    {
        $json = [];

        delete_files(WRITEPATH . 'cache/');

        @touch(WRITEPATH . 'cache/' . 'index.html');

        $json['success']['toast'] = lang('Success.cache_clear', [], 'en');

        return $this->response->setJSON($json);
    }
}
