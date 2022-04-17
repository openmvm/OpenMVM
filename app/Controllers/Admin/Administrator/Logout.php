<?php

namespace App\Controllers\Admin\Administrator;

class Logout extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function index()
    {
        $this->administrator->logout();

        $data['base'] = base_url();
        $data['title'] = lang('Heading.logout');

        $year = $this->setting->get('setting_copyright_year');

        $data['copyrights'] = sprintf(lang('Text.copyright'), $year, $this->setting->get('setting_copyright_name'));

        return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Administrator\logout', $data);
    }
}
