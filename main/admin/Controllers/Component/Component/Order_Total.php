<?php

namespace Main\Admin\Controllers\Component\Component;

class Order_Total extends \App\Controllers\BaseController
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
            'text' => lang('Text.order_totals'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total'),
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

        $data['heading_title'] = lang('Heading.order_totals');

        // Get order totals
        $data['order_totals'] = [];

        $directory = ROOTPATH . '/main/admin/Controllers/Component/Order_Total/';

        $order_totals = array_diff(scandir($directory), array('..', '.'));

        foreach ($order_totals as $order_total) {
            // Path info
            $pathinfo = pathinfo($order_total);

            $name = lang('Text.' . strtolower($pathinfo['filename']));

            // Check if installed
            $component_info = $this->model_component_component->getInstalledComponent('order_total', 'com_openmvm', $pathinfo['filename']);

            if ($component_info) {
                $installed = true;
            } else {
                $installed = false;
            }

            $data['order_totals'][] = [
                'name' => $name,
                'author' => 'com_openmvm',
                'installed' => $installed,
                'install' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total/install', ['author' => 'com_openmvm', 'component' => $pathinfo['filename']]),
                'uninstall' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total/uninstall', ['author' => 'com_openmvm', 'component' => $pathinfo['filename']]),
                'edit' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/order_total/' . $pathinfo['filename']),
            ];
        }
        
		// Sort the file array
		sort($data['order_totals']);

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Component/Component/Order_Total')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.order_totals'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Component/Component\order_total', $data);
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
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.order_totals');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.order_totals'),
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
            $query = $this->model_component_component->installComponent('order_total', $this->request->getGet('author'), $this->request->getGet('component'));

            $this->session->set('success', lang('Success.component_install'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total'));
    }

    public function uninstall()
    {
        if (!empty($this->request->getGet('author')) && !empty($this->request->getGet('component'))) {
            // Install component
            $query = $this->model_component_component->uninstallComponent('order_total', $this->request->getGet('author'), $this->request->getGet('component'));

            $this->session->set('success', lang('Success.component_uninstall'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/order_total'));
    }
}
