<?php

namespace Main\Admin\Controllers\Component\Component;

class Analytics extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_component_component = new \Main\Admin\Models\Component\Component_Model();
    }

    public function index()
    {
        $data = [];

        return $this->get_list($data);
    }

    public function get_list($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.analytics'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics'),
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

        $data['heading_title'] = lang('Heading.analytics');

        // Get analytics
        $data['analytics'] = [];

        $directory = ROOTPATH . '/main/admin/Controllers/Component/Analytics/';

        $analytics = array_diff(scandir($directory), array('..', '.'));

        foreach ($analytics as $analytic) {
            // Path info
            $pathinfo = pathinfo($analytic);

            $name = lang('Text.' . strtolower($pathinfo['filename']));

            // Check if installed
            $component_info = $this->model_component_component->getInstalledComponent('analytics', 'com_openmvm', $pathinfo['filename']);

            if ($component_info) {
                $installed = true;
            } else {
                $installed = false;
            }

            $data['analytics'][] = [
                'name' => $name,
                'author' => 'com_openmvm',
                'installed' => $installed,
                'install' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics/install', ['author' => 'com_openmvm', 'component' => $pathinfo['filename']]),
                'uninstall' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics/uninstall', ['author' => 'com_openmvm', 'component' => $pathinfo['filename']]),
                'edit' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/analytics/' . $pathinfo['filename']),
            ];
        }
        
		// Sort the file array
		sort($data['analytics']);

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Component/Component/Analytics')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.analytics'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Component/Component\analytics', $data);
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
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.analytics');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.analytics'),
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

    public function install()
    {
        if (!empty($this->request->getGet('author')) && !empty($this->request->getGet('component'))) {
            // Install component
            $query = $this->model_component_component->installComponent('analytics', $this->request->getGet('author'), $this->request->getGet('component'));

            $this->session->set('success', lang('Success.component_install'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics'));
    }

    public function uninstall()
    {
        if (!empty($this->request->getGet('author')) && !empty($this->request->getGet('component'))) {
            // Install component
            $query = $this->model_component_component->uninstallComponent('analytics', $this->request->getGet('author'), $this->request->getGet('component'));

            $this->session->set('success', lang('Success.component_uninstall'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/analytics'));
    }
}
