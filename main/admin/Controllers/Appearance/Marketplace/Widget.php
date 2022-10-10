<?php

namespace Main\Admin\Controllers\Appearance\Marketplace;

class Widget extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_appearance_widget = new \Main\Admin\Models\Appearance\Widget_Model();
    }

    public function index()
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.marketplace_widgets'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget'),
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

        $data['heading_title'] = lang('Heading.widgets');

        // Get marketplace core widgets
        $core_path = ROOTPATH . 'main/admin/Controllers/Appearance/Marketplace/Widgets/*';

        $core_widgets = array_diff(glob($core_path), array('.', '..'));

        foreach ($core_widgets as $core_widget) {
            $path_info = pathinfo($core_widget);

            $dirname = $path_info['dirname'];
            $basename = $path_info['basename'];
            $extension = $path_info['extension'];
            $filename = $path_info['filename'];

            $name = lang('Text.' . strtolower($filename));

            // Check if widget is installed
            $is_installed = $this->model_appearance_widget->isInstalled('marketplace', 'com_openmvm', $filename);

            // Get widgets
            $widget_data = [];

            if ($is_installed) {
                $widgets = $this->model_appearance_widget->getWidgets('marketplace', 'com_openmvm', $filename);

                foreach ($widgets as $widget) {
                    $widget_data[] = [
                        'widget_id' => $widget['widget_id'],
                        'location' => $widget['location'],
                        'author' => $widget['author'],
                        'widget' => $widget['widget'],
                        'name' => $widget['name'],
                        'setting' => $widget['setting'],
                        'status' => $widget['status'],
                        'edit' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/' . $filename . '/edit/' . $widget['widget_id']),
                        'delete' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/delete/com_openmvm/' . $filename . '/' . $widget['widget_id']),
                    ];
                }
            }

            $data['widgets'][] = [
                'path' => $core_widget,
                'name' => $name,
                'is_installed' => $is_installed,
                'widget' => $widget_data,
                'install' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/install/com_openmvm/' . $filename),
                'uninstall' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/uninstall/com_openmvm/' . $filename),
                'add' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/add/com_openmvm/' . $filename),
            ];
        }

        // Get marketplace plugin widgets
        $plugin_path = ROOTPATH . 'plugins/*/*/Controllers/Admin/Appearance/Marketplace/Widgets/*';

        $plugin_widgets = array_diff(glob($plugin_path), array('.', '..'));

        foreach ($plugin_widgets as $plugin_widget) {
            $path_info = pathinfo($plugin_widget);

            $dirname = $path_info['dirname'];
            $basename = $path_info['basename'];
            $extension = $path_info['extension'];
            $filename = $path_info['filename'];

            $name = lang('Text.' . strtolower($filename));

            $url_strings = str_replace(ROOTPATH, '', $plugin_widget);

            $url_string = explode('/', $url_strings);

            $author = $url_string[1];

            // Check if widget is installed
            $is_installed = $this->model_appearance_widget->isInstalled('marketplace', $author, $filename);

            // Get widgets
            $widget_data = [];

            if ($is_installed) {
                $widgets = $this->model_appearance_widget->getWidgets('marketplace', $author, $filename);

                foreach ($widgets as $widget) {
                    $widget_data[] = [
                        'widget_id' => $widget['widget_id'],
                        'location' => $widget['location'],
                        'author' => $widget['author'],
                        'widget' => $widget['widget'],
                        'name' => $widget['name'],
                        'setting' => $widget['setting'],
                        'status' => $widget['status'],
                        'edit' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/' . $author . '/' . $filename . '/edit/' . $widget['widget_id']),
                        'delete' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/delete/' . $author . '/' . $filename . '/' . $widget['widget_id']),
                    ];
                }
            }

            $data['plugin_widgets'][] = [
                'path' => $plugin_widget,
                'name' => $name,
                'is_installed' => $is_installed,
                'widget' => $widget_data,
                'install' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/install/' . $author . '/' . $filename),
                'uninstall' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/uninstall/' . $author . '/' . $filename),
                'add' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/add/' . $author . '/' . $filename),
            ];
        }
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');

        // Header
        $header_params = array(
            'title' => lang('Heading.widgets'),
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
            'view' => 'Appearance\Marketplace\widget',
            'permission' => 'Appearance/Marketplace/Widget',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function install()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(env('app.adminUrlSegment') . '/administrator/login');
        }

        if ($this->administrator->hasPermission('modify', 'Appearance/Marketplace/Widget')) {
            // Query
            $query = $this->model_appearance_widget->install('marketplace', $this->uri->getSegment($this->uri->getTotalSegments() - 1), $this->uri->getSegment($this->uri->getTotalSegments()));

            $this->session->set('success', lang('Success.widget_install'));
        } else {
            $this->session->set('error', lang('Error.modify_permission'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget'));
    }

    public function uninstall()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(env('app.adminUrlSegment') . '/administrator/login');
        }

        if ($this->administrator->hasPermission('modify', 'Appearance/Marketplace/Widget')) {
            // Query
            $query = $this->model_appearance_widget->uninstall('marketplace', $this->uri->getSegment($this->uri->getTotalSegments() - 1), $this->uri->getSegment($this->uri->getTotalSegments()));

            $this->session->set('success', lang('Success.widget_uninstall'));
        } else {
            $this->session->set('error', lang('Error.modify_permission'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget'));
    }

    public function add()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(env('app.adminUrlSegment') . '/administrator/login');
        }

        if ($this->administrator->hasPermission('modify', 'Appearance/Marketplace/Widget')) {
            // Query
            $query = $this->model_appearance_widget->addWidget('marketplace', $this->uri->getSegment($this->uri->getTotalSegments() - 1), $this->uri->getSegment($this->uri->getTotalSegments()));

            $this->session->set('success', lang('Success.widget_add'));
        } else {
            $this->session->set('error', lang('Error.modify_permission'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget'));
    }

    public function delete()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to(env('app.adminUrlSegment') . '/administrator/login');
        }

        if ($this->administrator->hasPermission('modify', 'Appearance/Marketplace/Widget')) {
            // Query
            $query = $this->model_appearance_widget->deleteWidget('marketplace', $this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments() - 1), $this->uri->getSegment($this->uri->getTotalSegments()));

            $this->session->set('success', lang('Success.widget_delete'));
        } else {
            $this->session->set('error', lang('Error.modify_permission'));
        }

        return redirect()->to($this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget'));
    }
}
