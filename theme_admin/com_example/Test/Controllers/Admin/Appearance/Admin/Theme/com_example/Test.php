<?php

namespace ThemeAdmin\com_example\Test\Controllers\Admin\Appearance\Admin\Theme\com_example;

class Test extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.admin_themes'),
            'href' => $this->url->administratorLink('admin/appearance/admin/theme'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.theme_test'),
            'href' => $this->url->administratorLink('admin/appearance/admin/theme/example/test'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.theme_test');

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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_example',
            'theme' => 'Test',
            'view' => 'Appearance\Admin\Theme\com_example\test',
            'permission' => 'Appearance/Admin/Theme',
            'override' => true,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_info()
    {
        $json = [];

        $json['theme'] = 'Test';
        $json['author'] = 'com_example';
        $json['description'] = lang('Text.example_theme_test_description');
        $json['image'] = base_url() . '/assets/admin/theme/com_example/test/images/test.png';

        return $this->response->setJSON($json);
    }
}
