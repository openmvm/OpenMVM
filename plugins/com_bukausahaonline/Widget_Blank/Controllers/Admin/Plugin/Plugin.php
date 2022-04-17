<?php

namespace Plugins\com_bukausahaonline\Widget_Blank\Controllers\Admin\Plugin;

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
        $json['author'] = 'com_bukausahaonline';
        $json['link'] = 'https://bukausahaonline.com/';
        $json['description'] = lang('Text.bukausahaonline_widget_blank_description');
        $json['image'] = base_url() . '/assets/admin/theme/com_openmvm/basic/images/basic.png';

        return $this->response->setJSON($json);
    }
}
