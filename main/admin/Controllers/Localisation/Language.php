<?php

namespace Main\Admin\Controllers\Localisation;

class Language extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.languages'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.languages');

        // Get languages
        $data['languages'] = [];

        $languages = $this->model_localisation_language->getLanguages();

        foreach ($languages as $language) {
            $data['languages'][] = [
                'language_id' => $language['language_id'],
                'name' => $language['name'],
                'code' => $language['code'],
                'sort_order' => $language['sort_order'],
                'status' => $language['status'] ? lang('Text.enabled') : lang('Text.disabled'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language/edit/' . $language['language_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_admin_language_id');

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
        // Header
        $header_params = array(
            'title' => lang('Heading.languages'),
        );
        $data['header'] = $this->admin_header->index($header_params);
        // Column Left
        $column_left_params = array();
        $data['column_left'] = $this->admin_column_left->index($column_left_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->admin_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Localisation\language_list',
            'permission' => 'Localisation/Language',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.languages'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $language_info = $this->model_localisation_language->getLanguage($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $language_info = [];
        }

        $data['heading_title'] = lang('Heading.languages');

        if ($language_info) {
            $data['name'] = $language_info['name'];
        } else {
            $data['name'] = '';
        }
		
		$data['directories'] = array();
		
		$folders = glob(APPPATH . '/Language/*', GLOB_ONLYDIR);

		foreach ($folders as $folder) {
			$data['directories'][] = basename($folder);
		}

        if ($language_info) {
            $data['code'] = $language_info['code'];
        } else {
            $data['code'] = '';
        }

        if ($language_info) {
            $data['sort_order'] = $language_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($language_info) {
            $data['status'] = $language_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');

        // Header
        $header_params = array(
            'title' => lang('Heading.languages'),
        );
        $data['header'] = $this->admin_header->index($header_params);
        // Column Left
        $column_left_params = array();
        $data['column_left'] = $this->admin_column_left->index($column_left_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->admin_footer->index($footer_params);

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Localisation\language_form',
            'permission' => 'Localisation/Language',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Language')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $language_id) {
                        // Query
                        $query = $this->model_localisation_language->deleteLanguage($language_id);
                    }

                    $json['success']['toast'] = lang('Success.language_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language');
                } else {
                    $json['error']['toast'] = lang('Error.language_delete');
                }                
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Language')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $this->validation->setRule('name', lang('Entry.name'), 'required');
                $this->validation->setRule('code', lang('Entry.code'), 'required');

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_localisation_language->editLanguage($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.language_edit');
                    } else {
                        // Query
                        $query = $this->model_localisation_language->addLanguage($this->request->getPost());

                        $json['success']['toast'] = lang('Success.language_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/language');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    if ($this->validation->hasError('name')) {
                        $json['error']['name'] = $this->validation->getError('name');
                    }

                    if ($this->validation->hasError('code')) {
                        $json['error']['code'] = $this->validation->getError('code');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
