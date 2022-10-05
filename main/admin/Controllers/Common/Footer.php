<?php

namespace Main\Admin\Controllers\Common;

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

    }

    public function index($footer_params = array())
    {
        if (date('Y') == '2021') {
            $year = date('Y');
        } else {
            $year = '2021 - ' . date('Y');
        }

        $data['copyright'] = sprintf(lang('Text.copyright'), $year, $this->setting->get('setting_marketplace_name'));

        $data['rendered'] = sprintf(lang('Text.rendered', [], $this->language->getCurrentCode()), '{elapsed_time}');

        return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Common\footer', $data);
    }
}
