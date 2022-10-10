<?php

namespace Main\Admin\Controllers\Component\Component;

class Payment_Method extends \App\Controllers\BaseController
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
            'text' => lang('Text.payment_methods'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method'),
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

        $directory = ROOTPATH . '/main/admin/Controllers/Component/Payment_Method/';

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
                'install' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method/install', ['author' => 'com_openmvm', 'component' => $pathinfo['filename']]),
                'uninstall' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method/uninstall', ['author' => 'com_openmvm', 'component' => $pathinfo['filename']]),
                'edit' => $this->url->administratorLink(env('app.adminUrlSegment') . '/component/payment_method/' . $pathinfo['filename']),
            ];
        }
        
		// Sort the file array
		sort($data['payment_methods']);

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Component\Component\payment_method',
            'permission' => 'Component/Component/Payment_Method',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function install()
    {
        if (!empty($this->request->getGet('author')) && !empty($this->request->getGet('component'))) {
            // Install component
            $query = $this->model_component_component->installComponent('payment_method', $this->request->getGet('author'), $this->request->getGet('component'));

            $this->session->set('success', lang('Success.component_install'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method'));
    }

    public function uninstall()
    {
        if (!empty($this->request->getGet('author')) && !empty($this->request->getGet('component'))) {
            // Install component
            $query = $this->model_component_component->uninstallComponent('payment_method', $this->request->getGet('author'), $this->request->getGet('component'));

            $this->session->set('success', lang('Success.component_uninstall'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/component/component/payment_method'));
    }
}
