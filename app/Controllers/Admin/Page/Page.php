<?php

namespace App\Controllers\Admin\Page;

class Page extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \App\Models\Admin\Localisation\Language_Model();
        $this->model_page_page = new \App\Models\Admin\Page\Page_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/page/page');

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('selected'))) {
            if (!$this->administrator->hasPermission('modify', 'Page/Page')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/page/page'));
            }

            foreach ($this->request->getPost('selected') as $page_id) {
                // Query
                $query = $this->model_page_page->deletePage($page_id);
            }

            $this->session->set('success', lang('Success.page_delete'));

            return redirect()->to($this->url->administratorLink('admin/page/page'));
        }

        return $this->get_list($data);
    }

    public function add()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink('admin/page/page/add');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Page/Page')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/page/page/add'));
            }

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('description.' . $language['language_id'] . '.title', lang('Entry.title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('description.' . $language['language_id'] . '.description', lang('Entry.description') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_page_page->addPage($this->request->getPost());

                $this->session->set('success', lang('Success.page_add'));

                return redirect()->to($this->url->administratorLink('admin/page/page'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('description.' . $language['language_id'] . '.title')) {
                        $data['error_description'][$language['language_id']]['title'] = $this->validation->getError('description.' . $language['language_id'] . '.title');
                    } else {
                        $data['error_description'][$language['language_id']]['title'] = '';
                    }

                    if ($this->validation->hasError('description.' . $language['language_id'] . '.description')) {
                        $data['error_description'][$language['language_id']]['description'] = $this->validation->getError('description.' . $language['language_id'] . '.description');
                    } else {
                        $data['error_description'][$language['language_id']]['description'] = '';
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

        $data['action'] = $this->url->administratorLink('admin/page/page/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Page/Page')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/page/page/edit/' . $this->uri->getSegment($this->uri->getTotalSegments())));
            }

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('description.' . $language['language_id'] . '.title', lang('Entry.title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('description.' . $language['language_id'] . '.description', lang('Entry.description') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_page_page->editPage($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                $this->session->set('success', lang('Success.page_edit'));

                return redirect()->to($this->url->administratorLink('admin/page/page'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('description.' . $language['language_id'] . '.title')) {
                        $data['error_description'][$language['language_id']]['title'] = $this->validation->getError('description.' . $language['language_id'] . '.title');
                    } else {
                        $data['error_description'][$language['language_id']]['title'] = '';
                    }

                    if ($this->validation->hasError('description.' . $language['language_id'] . '.description')) {
                        $data['error_description'][$language['language_id']]['description'] = $this->validation->getError('description.' . $language['language_id'] . '.description');
                    } else {
                        $data['error_description'][$language['language_id']]['description'] = '';
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
            'text' => lang('Text.pages'),
            'href' => $this->url->administratorLink('admin/page/page'),
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

        $data['heading_title'] = lang('Heading.pages');

        // Get pages
        $data['pages'] = [];

        $pages = $this->model_page_page->getPages();

        foreach ($pages as $page) {
            $data['pages'][] = [
                'page_id' => $page['page_id'],
                'title' => $page['title'],
                'status' => $page['status'],
                'href' => $this->url->administratorLink('admin/page/page/edit/' . $page['page_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink('admin/page/page/add');
        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Page/Page')) {
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

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Page\page_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.pages'),
                'href' => $this->url->administratorLink('admin/page/page'),
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.pages');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.pages'),
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
            'text' => lang('Text.pages'),
            'href' => $this->url->administratorLink('admin/page/page'),
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

        $data['heading_title'] = lang('Heading.pages');

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('description');
        } elseif ($page_info) {
            $data['sort_order'] = $page_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($page_info) {
            $data['status'] = $page_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($this->request->getPost('description')) {
            $data['description'] = $this->request->getPost('description');
        } elseif ($page_info) {
            $data['description'] = $this->model_page_page->getPageDescriptions($page_info['page_id']);
        } else {
            $data['description'] = [];
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');

        if ($this->administrator->hasPermission('access', 'Page/Page')) {
            // Header
            $scripts = [
                '<script src="' . base_url() . '/assets/plugins/tinymce-5.10.2/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
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

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Page\page_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.pages'),
                'href' => $this->url->administratorLink('admin/page/page'),
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
    
            $data['heading_title'] = lang('Heading.pages');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.pages'),
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

    public function autocomplete()
    {
        $json = [];

        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            $json['error'] = lang('Error.login');
        }

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
