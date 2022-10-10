<?php

namespace Main\Marketplace\Controllers\Common;

class Home extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        $data['heading_title'] = lang('Heading.home', [], $this->language->getCurrentCode());

        // Widget
        $data['marketplace_common_widget'] = $this->marketplace_common_widget;

        // Header
        $header_params = array(
            'title' => lang('Heading.home', [], $this->language->getCurrentCode()),
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Common\home',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
