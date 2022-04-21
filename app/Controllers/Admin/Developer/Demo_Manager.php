<?php

namespace App\Controllers\Admin\Developer;

class Demo_Manager extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_developer_demo_manager = new \App\Models\Admin\Developer\Demo_Manager_Model();
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

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.demo_manager'),
            'href' => $this->url->administratorLink('admin/developer/demo_manager'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.demo_manager');

        $data['upload'] = $this->url->administratorLink('admin/developer/demo_manager/upload');
        $data['extract'] = $this->url->administratorLink('admin/developer/demo_manager/extract');
        $data['import_sql'] = $this->url->administratorLink('admin/developer/demo_manager/import_sql');

        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Developer/Demo_Manager')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.demo_manager'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Developer\demo_manager', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.demo_manager'),
                'href' => $this->url->administratorLink('admin/developer/demo_manager'),
                'active' => true,
            );
        
            $data['heading_title'] = lang('Heading.demo_manager');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.demo_manager'),
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

    public function upload()
    {
        $json = [];

        $dir_temp = ROOTPATH . 'writable/temp/';

        $zip = $this->request->getFile('file');
        $newName = $zip->getRandomName();

        if (!$zip->hasMoved()) {
            $zip->move($dir_temp, $newName);

            $json['zipfile'] = $newName;
        }

        return $this->response->setJSON($json);
    }

    public function extract()
    {
        $json = [];

        if (!empty($this->request->getPost('zipfile'))) {
            $zipfile = $this->request->getPost('zipfile');
            $destination = ROOTPATH;

            if (file_exists(ROOTPATH . 'writable/temp/' . $zipfile)) {
                if (!$this->zip->extractTo(ROOTPATH . 'writable/temp/' . $zipfile, $destination, true)) {
                    $json['error'] = 'Extract failed!';
                }
            } else {
                $json['error'] = 'Zipfile not found!';
            }
        } else {
            $json['error'] = 'Empty zipfile input!';
        }

        return $this->response->setJSON($json);
    }

    public function import_sql()
    {
        $json = [];

        // Check Module database.sql
        if (file_exists(ROOTPATH . 'writable/temp/openmvm_demo_data.sql')) {
            // Import SQL file into the database
            $this->model_developer_demo_manager->import();
        } else {
            $json['error'] = 'SQL file not found! Skipping...';
        }

        return $this->response->setJSON($json);
    }
}
