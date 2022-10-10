<?php

namespace Main\Admin\Controllers\Common;

class Header extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->administrator = new \App\Libraries\Administrator();
        $this->image= new \App\Libraries\Image();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        $this->setting = new \App\Libraries\Setting();
    }

    public function index($header_params = array())
    {
        $data['base'] = base_url();
        $data['title'] = $header_params['title'];

        // Scripts
        if (!empty($header_params['scripts'])) {
            foreach ($header_params['scripts'] as $script) {
                $scripts[] = $script;
            }
        } else {
            $scripts = [];
        }

        $data['scripts'] = array_unique($scripts);

        // Styles
        if (!empty($header_params['styles'])) {
            foreach ($header_params['styles'] as $style) {
                $styles[] = $style;
            }
        } else {
            $styles = [];
        }

        $data['styles'] = array_unique($styles);

        $data['profile'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator/edit/' . $this->administrator->getId());
        $data['welcome'] = sprintf(lang('Text.welcome'), $this->administrator->getFirstname());

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
            'view' => 'Common\header',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
