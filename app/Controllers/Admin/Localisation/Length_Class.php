<?php

namespace App\Controllers\Admin\Localisation;

class Length_Class extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \App\Models\Admin\Localisation\Language_Model();
        $this->model_localisation_length_class = new \App\Models\Admin\Localisation\Length_Class_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/localisation/length_class');

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('selected'))) {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Length_Class')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/localisation/length_class'));
            }

            foreach ($this->request->getPost('selected') as $length_class_id) {
                // Query
                $query = $this->model_localisation_length_class->deleteLengthClass($length_class_id);
            }

            $this->session->set('success', lang('Success.length_class_delete'));

            return redirect()->to($this->url->administratorLink('admin/localisation/length_class'));
        }

        return $this->get_list($data);
    }

    public function add()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink('admin/localisation/length_class/add');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Length_Class')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/localisation/length_class/add'));
            }

            $this->validation->setRule('value', lang('Entry.value'), 'required');

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('description.' . $language['language_id'] . '.title', lang('Entry.title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('description.' . $language['language_id'] . '.unit', lang('Entry.unit') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_localisation_length_class->addLengthClass($this->request->getPost());

                $this->session->set('success', lang('Success.length_class_add'));

                return redirect()->to($this->url->administratorLink('admin/localisation/Length_class'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('value')) {
                    $data['error_value'] = $this->validation->getError('value');
                } else {
                    $data['error_value'] = '';
                }

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('description.' . $language['language_id'] . '.title')) {
                        $data['error_description'][$language['language_id']]['title'] = $this->validation->getError('description.' . $language['language_id'] . '.title');
                    } else {
                        $data['error_description'][$language['language_id']]['title'] = '';
                    }

                    if ($this->validation->hasError('description.' . $language['language_id'] . '.unit')) {
                        $data['error_description'][$language['language_id']]['unit'] = $this->validation->getError('description.' . $language['language_id'] . '.unit');
                    } else {
                        $data['error_description'][$language['language_id']]['unit'] = '';
                    }
                }
            }
        }

        return $this->get_form($data);
    }

    public function edit()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink('admin/localisation/length_class/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Length_Class')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/localisation/length_class/edit/' . $this->uri->getSegment($this->uri->getTotalSegments())));
            }

            $this->validation->setRule('value', lang('Entry.value'), 'required');

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('description.' . $language['language_id'] . '.title', lang('Entry.title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('description.' . $language['language_id'] . '.unit', lang('Entry.unit') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_localisation_length_class->editLengthClass($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                $this->session->set('success', lang('Success.length_class_edit'));

                return redirect()->to($this->url->administratorLink('admin/localisation/length_class'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('value')) {
                    $data['error_value'] = $this->validation->getError('value');
                } else {
                    $data['error_value'] = '';
                }

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('description.' . $language['language_id'] . '.title')) {
                        $data['error_description'][$language['language_id']]['title'] = $this->validation->getError('description.' . $language['language_id'] . '.title');
                    } else {
                        $data['error_description'][$language['language_id']]['title'] = '';
                    }

                    if ($this->validation->hasError('description.' . $language['language_id'] . '.unit')) {
                        $data['error_description'][$language['language_id']]['unit'] = $this->validation->getError('description.' . $language['language_id'] . '.unit');
                    } else {
                        $data['error_description'][$language['language_id']]['unit'] = '';
                    }
                }
            }
        }

        return $this->get_form($data);
    }

    public function get_list($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.length_classes'),
            'href' => $this->url->administratorLink('admin/localisation/length_class'),
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

        $data['heading_title'] = lang('Heading.length_classes');

        // Get length classes
        $data['length_classes'] = [];

        $length_classes = $this->model_localisation_length_class->getLengthClasses();

        foreach ($length_classes as $length_class) {
            $data['length_classes'][] = [
                'length_class_id' => $length_class['length_class_id'],
                'title' => $length_class['title'],
                'unit' => $length_class['unit'],
                'value' => $length_class['value'],
                'href' => $this->url->administratorLink('admin/localisation/length_class/edit/' . $length_class['length_class_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_admin_length_class_id');

        $data['add'] = $this->url->administratorLink('admin/localisation/length_class/add');
        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Localisation/Length_Class')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.length_classes'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\length_class_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.length_classes'),
                'href' => $this->url->administratorLink('admin/localisation/length_class'),
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.length_classes');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.length_classes'),
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
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.length_classes'),
            'href' => $this->url->administratorLink('admin/localisation/length_class'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $length_class_info = $this->model_localisation_length_class->getLengthClass($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $length_class_info = [];
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

        $data['heading_title'] = lang('Heading.length_classes');

        if ($this->request->getPost('description')) {
            $data['description'] = $this->request->getPost('description');
        } elseif ($length_class_info) {
            $data['description'] = $this->model_localisation_length_class->getLengthClassDescriptions($length_class_info['length_class_id']);
        } else {
            $data['description'] = [];
        }

        if ($this->request->getPost('value')) {
            $data['value'] = $this->request->getPost('value');
        } elseif ($length_class_info) {
            $data['value'] = $length_class_info['value'];
        } else {
            $data['value'] = '';
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');

        if ($this->administrator->hasPermission('access', 'Localisation/Length_Class')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.length_classes'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\length_class_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.length_classes'),
                'href' => $this->url->administratorLink('admin/localisation/length_class'),
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
    
            $data['heading_title'] = lang('Heading.length_classes');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.length_classes'),
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
}