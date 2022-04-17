<?php

namespace ThemeMarketplace\com_bukausahaonline\Test\Controllers\Admin\Appearance\Marketplace\Theme\com_bukausahaonline;

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
            'text' => lang('Text.marketplace_themes'),
            'href' => $this->url->administratorLink('admin/appearance/marketplace/theme'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.bukausahaonline_marketplace_theme_test'),
            'href' => $this->url->administratorLink('admin/appearance/marketplace/theme/com_bukausahaonline/test'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.bukausahaonline_marketplace_theme_test');

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

            return $this->template->render('ThemeMarketplaceAdminSetting', 'com_bukausahaonline', 'Test', 'Admin\Appearance\Marketplace\Theme\com_bukausahaonline\test', $data);
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
                'href' => $this->url->administratorLink('admin/appearance/marketplace/theme/com_bukausahaonline/test'),
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

            return $this->template->render('ThemeAdmin', 'OpenMVM', 'Basic', 'Common\permission', $data);
        }
    }

    public function get_info()
    {
        $json = [];

        $json['theme'] = 'Test';
        $json['author'] = 'com_bukausahaonline';
        $json['link'] = 'https://bukausahaonline.com/';
        $json['description'] = lang('Text.bukausahaonline_marketplace_theme_test_description');
        $json['image'] = base_url() . '/assets/marketplace/theme/com_bukausahaonline/test/images/test.png';

        return $this->response->setJSON($json);
    }
}
