<?php

namespace Main\Admin\Controllers\Page;

class Page extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_page_page = new \Main\Admin\Models\Page\Page_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.pages'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.pages');

        // Get pages
        $data['pages'] = [];

        $pages = $this->model_page_page->getPages();

        foreach ($pages as $page) {
            $data['pages'][] = [
                'page_id' => $page['page_id'],
                'title' => $page['title'],
                'status' => $page['status'],
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page/edit/' . $page['page_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
        // Header
        $header_params = array(
            'title' => lang('Heading.pages'),
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
            'view' => 'Page\page_list',
            'permission' => 'Page/Page',
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
            'text' => lang('Text.pages'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $page_info = $this->model_page_page->getPage($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $page_info = [];
        }

        $data['heading_title'] = lang('Heading.pages');

        if ($page_info) {
            $data['sort_order'] = $page_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($page_info) {
            $data['status'] = $page_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($page_info) {
            $data['description'] = $this->model_page_page->getPageDescriptions($page_info['page_id']);
        } else {
            $data['description'] = [];
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page');

        // Header
        $scripts = [
            '<script src="' . base_url() . '/assets/plugins/tinymce_6.2.0/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
        ];
        $header_params = array(
            'title' => lang('Heading.pages'),
            'scripts' => $scripts,
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
            'view' => 'Page\page_form',
            'permission' => 'Page/Page',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Page/Page')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $page_id) {
                        // Query
                        $query = $this->model_page_page->deletePage($page_id);
                    }

                    $json['success']['toast'] = lang('Success.page_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page');
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
            if (!$this->administrator->hasPermission('modify', 'Page/Page')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    $this->validation->setRule('description.' . $language['language_id'] . '.title', lang('Entry.title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                    $this->validation->setRule('description.' . $language['language_id'] . '.description', lang('Entry.description') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                }

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_page_page->editPage($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.page_edit');
                    } else {
                        // Query
                        $query = $this->model_page_page->addPage($this->request->getPost());

                        $json['success']['toast'] = lang('Success.page_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/page/page');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    $languages = $this->model_localisation_language->getlanguages();

                    foreach ($languages as $language) {
                        if ($this->validation->hasError('description.' . $language['language_id'] . '.title')) {
                            $json['error']['title-' . $language['language_id']] = $this->validation->getError('description.' . $language['language_id'] . '.title');
                        }

                        if ($this->validation->hasError('description.' . $language['language_id'] . '.description')) {
                            $json['error']['description-' . $language['language_id']] = $this->validation->getError('description.' . $language['language_id'] . '.description');
                        }
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function autocomplete()
    {
        $json = [];

        if (!$this->administrator->hasPermission('access', 'Page/Page')) {
            $json['error'] = lang('Error.access_permission');
        }

        if (empty($json['error'])) {
            if (!empty($this->request->getGet('filter_name'))) {
                $filter_name = $this->request->getGet('filter_name');
            } else {
                $filter_name = '';
            }

            $filter_data = [
                'filter_name' => $filter_name,
            ];

            $pages = $this->model_page_page->getPages($filter_data);

            if ($pages) {
                foreach ($pages as $page) {
                    $json[] = [
                        'page_id' => $page['page_id'],
                        'name' => $page['title'],
                    ];
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
