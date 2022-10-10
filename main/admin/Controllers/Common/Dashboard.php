<?php

namespace Main\Admin\Controllers\Common;

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
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.dashboard');

        // Test Zip Library
        $test = false;

        if ($test) {
            $file = ROOTPATH . '/writable/uploads/jquery-ui-1.13.2.zip';
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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Common\dashboard',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
