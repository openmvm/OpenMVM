<?php

namespace Main\Admin\Controllers\Administrator;

class Login extends \App\Controllers\BaseController
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

        $year = $this->setting->get('setting_copyright_year');

        $data['copyrights'] = sprintf(lang('Text.copyright'), $year, $this->setting->get('setting_copyright_name'));
        
        $data['action'] = base_url(env('app.adminUrlSegment') . '/administrator/login/go');

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $data['base'] = base_url();
        $data['title'] = lang('Heading.login');

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
            'view' => 'Administrator\login',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function go()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            // Validation rules
            $this->validation->setRule('username', lang('Entry.username'), 'required');
            $this->validation->setRule('password', lang('Entry.password'), 'required');

            // Run the validation
            if ($this->validation->withRequest($this->request)->run()) {
                // Login
                $logged_in = $this->administrator->login($this->request->getPost('username'), $this->request->getPost('password'));

                if ($logged_in) {
                    // Success
                    $json['success']['toast'] = lang('Success.login', [], 'en');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.login', [], 'en');
                }

            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], 'en');

                if ($this->validation->hasError('username')) {
                    $json['error']['username'] = $this->validation->getError('username');
                }

                if ($this->validation->hasError('password')) {
                    $json['error']['password'] = $this->validation->getError('password');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}

