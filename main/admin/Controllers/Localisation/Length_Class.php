<?php

namespace Main\Admin\Controllers\Localisation;

class Length_Class extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_localisation_length_class = new \Main\Admin\Models\Localisation\Length_Class_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.length_classes'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class'),
            'active' => true,
        );

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
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class/edit/' . $length_class['length_class_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_admin_length_class_id');

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
		
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
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.length_classes'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class'),
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
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.length_classes'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class'),
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

        $data['heading_title'] = lang('Heading.length_classes');

        if ($length_class_info) {
            $data['description'] = $this->model_localisation_length_class->getLengthClassDescriptions($length_class_info['length_class_id']);
        } else {
            $data['description'] = [];
        }

        if ($length_class_info) {
            $data['value'] = $length_class_info['value'];
        } else {
            $data['value'] = '';
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class');

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
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.length_classes'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class'),
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

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Length_Class')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $length_class_id) {
                        // Query
                        $query = $this->model_localisation_length_class->deleteLengthClass($length_class_id);
                    }

                    $json['success']['toast'] = lang('Success.length_class_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class');
                } else {
                    $json['error']['toast'] = lang('Error.country_delete');
                }                
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Length_Class')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $this->validation->setRule('value', lang('Entry.value'), 'required');

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    $this->validation->setRule('description.' . $language['language_id'] . '.title', lang('Entry.title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                    $this->validation->setRule('description.' . $language['language_id'] . '.unit', lang('Entry.unit') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                }

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_localisation_length_class->editLengthClass($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.length_class_edit');
                    } else {
                        // Query
                        $query = $this->model_localisation_length_class->addLengthClass($this->request->getPost());

                        $json['success']['toast'] = lang('Success.length_class_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/length_class');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    $languages = $this->model_localisation_language->getlanguages();

                    foreach ($languages as $language) {
                        if ($this->validation->hasError('description.' . $language['language_id'] . '.title')) {
                            $json['error']['title-' . $language['language_id']] = $this->validation->getError('description.' . $language['language_id'] . '.title');
                        }

                        if ($this->validation->hasError('description.' . $language['language_id'] . '.unit')) {
                            $json['error']['unit-' . $language['language_id']] = $this->validation->getError('description.' . $language['language_id'] . '.unit');
                        }
                    }

                    if ($this->validation->hasError('value')) {
                        $json['error']['value'] = $this->validation->getError('value');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
