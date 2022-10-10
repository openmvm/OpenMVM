<?php

namespace Main\Admin\Controllers\Developer;

class Demo_Manager extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_developer_demo_manager = new \Main\Admin\Models\Developer\Demo_Manager_Model();
    }

    public function index()
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => true,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.demo_manager'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/demo_manager'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.demo_manager');

        $data['upload'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/demo_manager/upload');
        $data['extract'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/demo_manager/extract');
        $data['import_sql'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/developer/demo_manager/import_sql');

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');

        $data['administrator_token'] = $this->administrator->getToken();

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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Developer\demo_manager',
            'permission' => 'Developer/Demo_Manager',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
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
