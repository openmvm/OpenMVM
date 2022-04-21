<?php

namespace App\Controllers\Admin\Administrator;

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
        
        $data['action'] = base_url('/admin/administrator/login');

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('username', lang('Entry.username'), 'required');
            $this->validation->setRule('password', lang('Entry.password'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Login
                $logged_in = $this->administrator->login($this->request->getPost('username'), $this->request->getPost('password'));

                if ($logged_in) {
                    return redirect()->to($this->url->administratorLink('admin/common/dashboard'));
                } else {
                    $this->session->set('error', lang('Error.login'));

                    return redirect()->to('admin/administrator/login');
                }
            }
        }

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        $data['base'] = base_url();
        $data['title'] = lang('Heading.login');

        if (!empty($this->setting->get('setting_favicon')) && is_file(ROOTPATH . 'public/assets/images/' . $this->setting->get('setting_favicon'))) {
            $data['favicon'] = $this->image->resize($this->setting->get('setting_favicon'), 100, 100, true);
        } else {
            $data['favicon'] = '';
        }

        $data['validation'] = $this->validation;

        return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Administrator\login', $data);
    }
}

