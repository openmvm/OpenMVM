<?php

namespace Main\Admin\Controllers\Localisation;

class Weight_Class extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_localisation_weight_class = new \Main\Admin\Models\Localisation\Weight_Class_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.weight_classes'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.weight_classes');

        // Get weight classes
        $data['weight_classes'] = [];

        $weight_classes = $this->model_localisation_weight_class->getWeightClasses();

        foreach ($weight_classes as $weight_class) {
            $data['weight_classes'][] = [
                'weight_class_id' => $weight_class['weight_class_id'],
                'title' => $weight_class['title'],
                'unit' => $weight_class['unit'],
                'value' => $weight_class['value'],
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class/edit/' . $weight_class['weight_class_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_admin_weight_class_id');

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Localisation/Weight_Class')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.weight_classes'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\weight_class_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.weight_classes'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class'),
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.weight_classes');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.weight_classes'),
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
            'text' => lang('Text.weight_classes'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $weight_class_info = $this->model_localisation_weight_class->getWeightClass($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $weight_class_info = [];
        }

        $data['heading_title'] = lang('Heading.weight_classes');

        if ($weight_class_info) {
            $data['description'] = $this->model_localisation_weight_class->getWeightClassDescriptions($weight_class_info['weight_class_id']);
        } else {
            $data['description'] = [];
        }

        if ($weight_class_info) {
            $data['value'] = $weight_class_info['value'];
        } else {
            $data['value'] = '';
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class');

        if ($this->administrator->hasPermission('access', 'Localisation/Weight_Class')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.weight_classes'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\weight_class_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.weight_classes'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class'),
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
    
            $data['heading_title'] = lang('Heading.weight_classes');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.weight_classes'),
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
            if (!$this->administrator->hasPermission('modify', 'Localisation/Weight_Class')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $weight_class_id) {
                        // Query
                        $query = $this->model_localisation_weight_class->deleteWeightClass($weight_class_id);
                    }

                    $json['success']['toast'] = lang('Success.weight_class_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class');
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
            if (!$this->administrator->hasPermission('modify', 'Localisation/Weight_Class')) {
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
                        $query = $this->model_localisation_weight_class->editWeightClass($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.weight_class_edit');
                    } else {
                        // Query
                        $query = $this->model_localisation_weight_class->addWeightClass($this->request->getPost());

                        $json['success']['toast'] = lang('Success.weight_class_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/weight_class');
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
