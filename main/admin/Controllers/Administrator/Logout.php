<?php

namespace Main\Admin\Controllers\Administrator;

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

        if (!empty($this->setting->get('setting_favicon')) && is_file(ROOTPATH . 'public/assets/images/' . $this->setting->get('setting_favicon'))) {
            $data['favicon'] = $this->image->resize($this->setting->get('setting_favicon'), 100, 100, true);
        } else {
            $data['favicon'] = '';
        }

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Administrator\logout',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
