<?php

namespace Plugins\com_example\Widget_Blank\Controllers\Admin\Plugin;

class Plugin extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        return false;
    }

    public function get_info()
    {
        $json = [];

        $json['plugin'] = 'Widget Blank';
        $json['author'] = 'com_example';
        $json['link'] = 'https://example.com/';
        $json['description'] = lang('Text.example_widget_blank_description');
        $json['image'] = base_url() . '/assets/admin/plugins/com_example/Widget_Blank/images/widget_blank.png';

        return $this->response->setJSON($json);
    }
}
