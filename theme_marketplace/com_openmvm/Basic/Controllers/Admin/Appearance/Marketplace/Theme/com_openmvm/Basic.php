<?php

namespace ThemeMarketplace\com_openmvm\Basic\Controllers\Admin\Appearance\Marketplace\Theme\com_openmvm;

class Basic extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_appearance_layout = new \Main\Admin\Models\Appearance\Layout_Model();
        $this->model_appearance_widget = new \Main\Admin\Models\Appearance\Widget_Model();
        $this->model_system_setting = new \Main\Admin\Models\System\Setting_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/appearance/marketplace/theme/com_openmvm/basic');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Appearance/Marketplace/Theme')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/appearance/marketplace/theme/com_openmvm/basic'));
            }

            // Query
            $query = $this->model_system_setting->editSetting('theme_marketplace_com_openmvm_basic', $this->request->getPost());

            $this->session->set('success', lang('Success.theme_edit'));

            return redirect()->to($this->url->administratorLink('admin/appearance/marketplace/theme/com_openmvm/basic'));
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
            'text' => lang('Text.marketplace_themes'),
            'href' => $this->url->administratorLink('admin/appearance/marketplace/theme'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.theme_basic'),
            'href' => $this->url->administratorLink('admin/appearance/marketplace/theme/com_openmvm/basic'),
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

        $data['sub_title'] = lang('Heading.edit');

        $data['heading_title'] = lang('Heading.theme_basic');

        // Widget Layouts
        if ($this->request->getPost('theme_marketplace_com_openmvm_basic_header_widget')) {
            $data['header_widgets'] = $this->request->getPost('theme_marketplace_com_openmvm_basic_header_widget');
        } else {
            $data['header_widgets'] = $this->model_system_setting->getSettingValue('theme_marketplace_com_openmvm_basic_header_widget');
        }

        $data['layouts'] = $this->model_appearance_layout->getLayouts();

        if ($this->request->getPost('theme_marketplace_com_openmvm_basic_content_layout_widget')) {
            $data['layout_widget'] = $this->request->getPost('theme_marketplace_com_openmvm_basic_content_layout_widget');
        } else {
            $data['layout_widget'] = $this->model_system_setting->getSettingValue('theme_marketplace_com_openmvm_basic_content_layout_widget');
        }

        if ($this->request->getPost('theme_marketplace_com_openmvmm_basic_footer_column')) {
            $data['footer_columns'] = $this->request->getPost('theme_marketplace_com_openmvm_basic_footer_column');
        } else {
            $data['footer_columns'] = $this->model_system_setting->getSettingValue('theme_marketplace_com_openmvm_basic_footer_column');
        }

        $data['widgets'] = [];

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
                $widgets = $this->model_appearance_widget->getWidgets('marketplace', 'com_openmvm', $filename, [], 1);

                foreach ($widgets as $widget) {
                    $widget_data[] = [
                        'widget_id' => $widget['widget_id'],
                        'location' => $widget['location'],
                        'author' => $widget['author'],
                        'widget' => $widget['widget'],
                        'name' => $widget['name'],
                    ];
                }
            }

            $data['widgets'][] = [
                'path' => $core_widget,
                'name' => $name,
                'is_installed' => $is_installed,
                'widget' => $widget_data,
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
                $widgets = $this->model_appearance_widget->getWidgets('marketplace', $author, $filename, [], 1);

                foreach ($widgets as $widget) {
                    $widget_data[] = [
                        'widget_id' => $widget['widget_id'],
                        'location' => $widget['location'],
                        'author' => $widget['author'],
                        'widget' => $widget['widget'],
                        'name' => $widget['name'],
                    ];
                }
            }

            $data['widgets'][] = [
                'path' => $plugin_widget,
                'name' => $name,
                'is_installed' => $is_installed,
                'widget' => $widget_data,
            ];
        }

        $data['column_widths'] = [1,2,3,4,5,6,7,8,9,10,11,12];

        $data['cancel'] = $this->url->administratorLink('admin/appearance/marketplace/theme');

        if ($this->administrator->hasPermission('access', 'Appearance/Marketplace/Theme')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.themes'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeMarketplaceAdminSetting', 'com_openmvm', 'Basic', 'Admin\Appearance\Marketplace\Theme\com_openmvm\basic', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.marketplace_themes'),
                'href' => $this->url->administratorLink('admin/appearance/marketplace/theme'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.theme_basic'),
                'href' => $this->url->administratorLink('admin/appearance/marketplace/theme/com_openmvm/basic'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.themes');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.themes'),
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

    public function get_info()
    {
        $json = [];

        $json['theme'] = 'Basic';
        $json['author'] = 'com_openmvm';
        $json['link'] = 'https://openmvm.com/';
        $json['description'] = lang('Text.openmvm_theme_basic_description');
        $json['image'] = base_url() . '/assets/marketplace/theme/com_openmvm/basic/images/basic.png';

        return $this->response->setJSON($json);
    }
}
