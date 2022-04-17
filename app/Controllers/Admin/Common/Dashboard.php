<?php

namespace App\Controllers\Admin\Common;

class Dashboard extends \App\Controllers\BaseController
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
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.dashboard');

        // Test Zip Library
        $test = false;

        if ($test) {
            $file = ROOTPATH . '/writable/uploads/jquery-ui-1.13.0.zip';
            $destination = ROOTPATH . '/writable/temp/';

            $this->zip->extractTo($file, $destination, true);
        }

        // Header
        $header_params = array(
            'title' => lang('Heading.dashboard'),
        );
        $data['header'] = $this->admin_header->index($header_params);
        // Column Left
        $column_left_params = array();
        $data['column_left'] = $this->admin_column_left->index($column_left_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->admin_footer->index($footer_params);

        return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Common\dashboard', $data);
    }
}
