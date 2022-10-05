<?php

namespace Main\Admin\Controllers\Administrator;

class Administrator extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_administrator_administrator_group = new \Main\Admin\Models\Administrator\Administrator_Group_Model();
        $this->model_administrator_administrator = new \Main\Admin\Models\Administrator\Administrator_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        return $this->get_form($data);
    }

    public function get_list($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.administrators'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator_administrator'),
            'active' => true,
        );

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = lang('Heading.administrators');

        // Get administrators
        $data['administrators'] = [];

        $administrators = $this->model_administrator_administrator->getAdministrators();

        foreach ($administrators as $administrator) {
            $data['administrators'][] = [
                'administrator_id' => $administrator['administrator_id'],
                'firstname' => $administrator['firstname'],
                'lastname' => $administrator['lastname'],
                'email' => $administrator['email'],
                'status' => $administrator['status'] ? lang('Text.enabled') : lang('Text.disabled'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator/edit/' . $administrator['administrator_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Administrator/Administrator')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.administrators'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Administrator\administrator_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.administrators'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator_administrator'),
                'active' => true,
            );
        
            $data['heading_title'] = lang('Heading.administrators');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.administrators'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Common\permission', $data);
        }
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.administrators'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $administrator_info = $this->model_administrator_administrator->getAdministrator($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $administrator_info = [];
        }

        if ($this->session->has('error')) {
            $data['error_warning'] = $this->session->get('error');

            $this->session->remove('error');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->remove('success');
        } else {
            $data['success'] = '';
        }

        $data['heading_title'] = lang('Heading.administrators');

        $data['administrator_groups'] = $this->model_administrator_administrator_group->getAdministratorGroups();

        if ($this->request->getPost('administrator_group_id')) {
            $data['administrator_group_id'] = $this->request->getPost('administrator_group_id');
        } elseif ($administrator_info) {
            $data['administrator_group_id'] = $administrator_info['administrator_group_id'];
        } else {
            $data['administrator_group_id'] = '';
        }

        if ($this->request->getPost('avatar')) {
            $data['avatar'] = $this->request->getPost('avatar');
        } elseif ($administrator_info) {
            $data['avatar'] = $administrator_info['avatar'];
        } else {
            $data['avatar'] = '';
        }

        if (!empty($this->request->getPost('avatar')) && is_file(ROOTPATH . 'public/assets/images/' . $this->request->getPost('avatar'))) {
            $data['avatar_thumb'] = $this->image->resize($this->request->getPost('avatar'), 100, 100, true);
        } elseif (!empty($administrator_info['avatar']) && is_file(ROOTPATH . 'public/assets/images/' . $administrator_info['avatar'])) {
            $data['avatar_thumb'] = $this->image->resize($administrator_info['avatar'], 100, 100, true);
        } else {
            $data['avatar_thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        if ($this->request->getPost('username')) {
            $data['username'] = $this->request->getPost('username');
        } elseif ($administrator_info) {
            $data['username'] = $administrator_info['username'];
        } else {
            $data['username'] = '';
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif ($administrator_info) {
            $data['firstname'] = $administrator_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif ($administrator_info) {
            $data['lastname'] = $administrator_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } elseif ($administrator_info) {
            $data['email'] = $administrator_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($administrator_info) {
            $data['status'] = $administrator_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['placeholder'] = $this->image->resize('no_image.png', 100, 100, true);

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');

        if ($this->administrator->hasPermission('access', 'Administrator/Administrator')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.administrators'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Administrator\administrator_form', $data);
        } else {
            $data = [];
            
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.administrators'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator'),
                'active' => false,
            );
    
            if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
                $data['breadcrumbs'][] = array(
                    'text' => lang('Text.edit'),
                    'href' => '',
                    'active' => true,
                );
            } else {
                $data['breadcrumbs'][] = array(
                    'text' => lang('Text.add'),
                    'href' => '',
                    'active' => true,
                );
            }
        
            $data['heading_title'] = lang('Heading.administrators');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.administrators'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Common\permission', $data);
        }
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Administrator/Administrator')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            if (!empty($this->request->getPost('selected'))) {
                foreach ($this->request->getPost('selected') as $administrator_id) {
                    // Query
                    $query = $this->model_administrator_administrator->deleteAdministrator($administrator_id);
                }

                $json['success']['toast'] = lang('Success.administrator_delete');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator');
            } else {
                $json['error']['toast'] = lang('Error.administrator_delete');
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Administrator/Administrator')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                    $administrator_info = $this->model_administrator_administrator->getAdministrator($this->uri->getSegment($this->uri->getTotalSegments()));

                    if ($administrator_info['username'] == $this->request->getPost('username')) {
                        $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|min_length[2]|max_length[35]');
                    } else {
                        $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|is_unique[administrator.username]|min_length[2]|max_length[35]');
                    }

                    if ($administrator_info['email'] == $this->request->getPost('email')) {
                        $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email');
                    } else {
                        $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email|is_unique[customer.email]');
                    }

                    if (!empty($this->request->getPost('password'))) {
                        $this->validation->setRule('passconf', lang('Entry.passconf'), 'required|matches[password]');
                    }
                } else {
                    $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|is_unique[administrator.username]|min_length[2]|max_length[35]');
                    $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email|is_unique[administrator.email]');
                    $this->validation->setRule('password', lang('Entry.password'), 'required');
                    $this->validation->setRule('passconf', lang('Entry.passconf'), 'required|matches[password]');
                }

                $this->validation->setRule('firstname', lang('Entry.firstname'), 'required');
                $this->validation->setRule('lastname', lang('Entry.lastname'), 'required');

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_administrator_administrator->editAdministrator($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.administrator_edit');
                    } else {
                        // Query
                        $query = $this->model_administrator_administrator->addAdministrator($this->request->getPost());

                        $json['success']['toast'] = lang('Success.administrator_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/administrator/administrator');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    if ($this->validation->hasError('username')) {
                        $json['error']['username'] = $this->validation->getError('username');
                    }

                    if ($this->validation->hasError('firstname')) {
                        $json['error']['firstname'] = $this->validation->getError('firstname');
                    }

                    if ($this->validation->hasError('lastname')) {
                        $json['error']['lastname'] = $this->validation->getError('lastname');
                    }

                    if ($this->validation->hasError('email')) {
                        $json['error']['email'] = $this->validation->getError('email');
                    }

                    if ($this->validation->hasError('password')) {
                        $json['error']['password'] = $this->validation->getError('password');
                    }

                    if ($this->validation->hasError('passconf')) {
                        $json['error']['passconf'] = $this->validation->getError('passconf');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
