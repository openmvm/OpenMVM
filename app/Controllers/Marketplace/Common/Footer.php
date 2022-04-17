<?php

namespace App\Controllers\Marketplace\Common;

class Footer extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->language = new \App\Libraries\Language();
        // Common Controllers
        $this->marketplace_common_widget = new \App\Controllers\Marketplace\Common\Widget();
    }

    public function index($footer_params = array())
    {
        $year = $this->setting->get('setting_copyright_year');

        $data['copyrights'] = sprintf(lang('Text.copyright'), $year, $this->setting->get('setting_copyright_name'));

        $data['rendered'] = sprintf(lang('Text.rendered', [], $this->language->getCurrentCode()), '{elapsed_time}');

        // Widget
        $data['marketplace_common_widget'] = $this->marketplace_common_widget;

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Common\footer', $data);
    }
}
