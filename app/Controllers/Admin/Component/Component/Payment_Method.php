<?php

namespace App\Controllers\Admin\Component\Component;

class Payment_Method extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \App\Models\Admin\Localisation\Language_Model();
        $this->model_component_component = new \App\Models\Admin\Component\Component_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data = [];

        return $this->get_list($data);
    }

    public function get_list($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.payment_methods'),
            'href' => $this->url->administratorLink('admin/component/component/payment_method'),
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

        $data['heading_title'] = lang('Heading.payment_methods');

        // Get payment methods
        $data['payment_methods'] = [];

        $directory = ROOTPATH . '/app/Controllers/Admin/Component/Payment_Method/';

        $payment_methods = array_diff(scandir($directory), array('..', '.'));

        foreach ($payment_methods as $payment_method) {
            // Path info
            $pathinfo = pathinfo($payment_method);

            $name = lang('Text.' . strtolower($pathinfo['filename']));

            // Check if installed
            $component_info = $this->model_component_component->getInstalledComponent('payment_method', 'com_openmvm', $pathinfo['filename']);

            if ($component_info) {
                $installed = true;
            } else {
                $installed = false;
            }

            $data['payment_methods'][] = [
                'name' => $name,
                'author' => 'com_openmvm',
                'installed' => $installed,
                'install' => $this->url->administratorLink('admin/component/component/payment_method/install', ['author' => 'com_openmvm', 'component' => $pathinfo['filename']]),
                'uninstall' => $this->url->administratorLink('admin/component/component/payment_method/uninstall', ['author' => 'com_openmvm', 'component' => $pathinfo['filename']]),
                'edit' => $this->url->administratorLink('admin/component/payment_method/' . strtolower($pathinfo['filename'])),
            ];
        }
        
		// Sort the file array
		sort($data['payment_methods']);

        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Component/Component/Payment_Method')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.payment_methods'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Component/Component\payment_method', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.payment_methods'),
                'href' => $this->url->administratorLink('admin/component/component/payment_method'),
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.payment_methods');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.payment_methods'),
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
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        if (!empty($this->request->getGet('author')) && !empty($this->request->getGet('component'))) {
            // Install component
            $query = $this->model_component_component->installComponent('payment_method', $this->request->getGet('author'), $this->request->getGet('component'));

            $this->session->set('success', lang('Success.component_install'));
        }

        return redirect()->to($this->url->administratorLink('admin/component/component/payment_method'));
    }

    public function uninstall()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        if (!empty($this->request->getGet('author')) && !empty($this->request->getGet('component'))) {
            // Install component
            $query = $this->model_component_component->uninstallComponent('payment_method', $this->request->getGet('author'), $this->request->getGet('component'));

            $this->session->set('success', lang('Success.component_uninstall'));
        }

        return redirect()->to($this->url->administratorLink('admin/component/component/payment_method'));
    }
}
