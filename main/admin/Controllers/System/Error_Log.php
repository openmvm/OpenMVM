<?php

namespace Main\Admin\Controllers\System;

class Error_Log extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.error_logs'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/system/error_log'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.error_logs');

		$files = [];

		// Make path into an array
		$files = array_diff(scandir(ROOTPATH . 'writable/logs/'), array('.', '..', 'index.html'));

        rsort($files);

        $data['files'] = $files;

        if ($files) {
            $data['latest_error'] = $files[0];
        } else {
            $data['latest_error'] = '';
        }

        $data['get_error'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/system/error_log/get_error');
        $data['delete_error'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/system/error_log/delete_error');

        // Header
        $header_params = array(
            'title' => lang('Heading.error_logs'),
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
            'view' => 'System\error_log',
            'permission' => 'System/Error_Log',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_error()
    {
        $json = [];

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('file'))) {
            if (is_file(ROOTPATH . 'writable/logs/' . $this->request->getPost('file'))) {
                $file_contents = file_get_contents(ROOTPATH . 'writable/logs/' . $this->request->getPost('file'));

                $json['contents'] = str_replace(array("\n","\r","\r\n"), '<br />', $file_contents);
            }
        }

        return $this->response->setJSON($json);
    }

    public function delete_error()
    {
        $json = [];

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('file'))) {
            $remove = unlink(ROOTPATH . 'writable/logs/' . $this->request->getPost('file'));

            $files = [];

            // Make path into an array
            $files = array_diff(scandir(ROOTPATH . 'writable/logs/'), array('.', '..', 'index.html'));
    
            rsort($files);
            
            if ($files) {
                $json['latest_error'] = $files[0];
            }

            $json['success'] = true;
        }

        return $this->response->setJSON($json);
    }
}
