<?php

namespace App\Controllers\Admin\Marketplace;

class Category extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_marketplace_category = new \App\Models\Admin\Marketplace\Category_Model();
        $this->model_localisation_language = new \App\Models\Admin\Localisation\Language_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/marketplace/category');

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('selected'))) {
            if (!$this->administrator->hasPermission('modify', 'Marketplace/Category')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/marketplace/category'));
            }

            foreach ($this->request->getPost('selected') as $category_id) {
                // Query
                $query = $this->model_marketplace_category->deleteCategory($category_id);
            }

            $this->session->set('success', lang('Success.category_delete'));

            return redirect()->to($this->url->administratorLink('admin/marketplace/category'));
        }

        return $this->get_list($data);
    }

    public function add()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink('admin/marketplace/category/add');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Marketplace/Category')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/marketplace/category/add'));
            }

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('category_description.' . $language['language_id'] . '.name', lang('Entry.name') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('category_description.' . $language['language_id'] . '.meta_title', lang('Entry.meta_title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_marketplace_category->addCategory($this->request->getPost());

                $this->session->set('success', lang('Success.category_add'));

                return redirect()->to($this->url->administratorLink('admin/marketplace/category'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('category_description.' . $language['language_id'] . '.name')) {
                        $data['error_category_description'][$language['language_id']]['name'] = $this->validation->getError('category_description.' . $language['language_id'] . '.name');
                    } else {
                        $data['error_category_description'][$language['language_id']]['name'] = '';
                    }

                    if ($this->validation->hasError('category_description.' . $language['language_id'] . '.meta_title')) {
                        $data['error_category_description'][$language['language_id']]['meta_title'] = $this->validation->getError('category_description.' . $language['language_id'] . '.meta_title');
                    } else {
                        $data['error_category_description'][$language['language_id']]['meta_title'] = '';
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

        $data['action'] = $this->url->administratorLink('admin/marketplace/category/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Marketplace/Category')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/marketplace/category/edit/' . $this->uri->getSegment($this->uri->getTotalSegments())));
            }

            $languages = $this->model_localisation_language->getlanguages();

            foreach ($languages as $language) {
                $this->validation->setRule('category_description.' . $language['language_id'] . '.name', lang('Entry.name') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                $this->validation->setRule('category_description.' . $language['language_id'] . '.meta_title', lang('Entry.meta_title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
            }

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_marketplace_category->editCategory($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                $this->session->set('success', lang('Success.category_edit'));

                return redirect()->to($this->url->administratorLink('admin/marketplace/category'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    if ($this->validation->hasError('category_description.' . $language['language_id'] . '.name')) {
                        $data['error_category_description'][$language['language_id']]['name'] = $this->validation->getError('category_description.' . $language['language_id'] . '.name');
                    } else {
                        $data['error_category_description'][$language['language_id']]['name'] = '';
                    }

                    if ($this->validation->hasError('category_description.' . $language['language_id'] . '.meta_title')) {
                        $data['error_category_description'][$language['language_id']]['meta_title'] = $this->validation->getError('category_description.' . $language['language_id'] . '.meta_title');
                    } else {
                        $data['error_category_description'][$language['language_id']]['meta_title'] = '';
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
            'text' => lang('Text.categories'),
            'href' => $this->url->administratorLink('admin/marketplace/category'),
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

        $data['heading_title'] = lang('Heading.categories');

        // Get categories
        $data['categories'] = [];

        $categories = $this->model_marketplace_category->getCategories();

        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name' => $category['name'],
                'sort_order' => $category['sort_order'],
                'status' => $category['status'] ? lang('Text.enabled') : lang('Text.disabled'),
                'href' => $this->url->administratorLink('admin/marketplace/category/edit/' . $category['category_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink('admin/marketplace/category/add');
        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Marketplace/Category')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.categories'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Marketplace\category_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.categories'),
                'href' => $this->url->administratorLink('admin/marketplace/category'),
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.categories');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.categories'),
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
            'text' => lang('Text.categories'),
            'href' => $this->url->administratorLink('admin/marketplace/category'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $category_info = $this->model_marketplace_category->getCategory($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $category_info = [];
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

        $data['heading_title'] = lang('Heading.categories');

        if ($this->request->getPost('category_description')) {
            $data['category_description'] = $this->request->getPost('category_description');
        } elseif ($category_info) {
            $data['category_description'] = $this->model_marketplace_category->getCategoryDescriptions($category_info['category_id']);
        } else {
            $data['category_description'] = [];
        }

        if ($this->request->getPost('parent')) {
            $data['parent'] = $this->request->getPost('parent');
        } elseif ($category_info) {
            $data['parent'] = $this->model_marketplace_category->getCategoryPath($category_info['category_id']);
        } else {
            $data['parent'] = '';
        }

        if ($this->request->getPost('parent_id')) {
            $data['parent_id'] = $this->request->getPost('parent_id');
        } elseif ($category_info) {
            $data['parent_id'] = $category_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }

        if ($this->request->getPost('image')) {
            $data['image'] = $this->request->getPost('image');
        } elseif ($category_info) {
            $data['image'] = $category_info['image'];
        } else {
            $data['image'] = '';
        }

        if ($this->request->getPost('image') !== null && is_file(ROOTPATH . 'public/assets/images/' . $this->request->getPost('image'))) {
            $data['thumb'] = $this->image->resize($this->request->getPost('image'), 100, 100, true);
        } elseif (!empty($category_info['image']) && is_file(ROOTPATH . 'public/assets/images/' . $category_info['image'])) {
            $data['thumb'] = $this->image->resize($category_info['image'], 100, 100, true);
        } else {
            $data['thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif ($category_info) {
            $data['sort_order'] = $category_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($category_info) {
            $data['status'] = $category_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['placeholder'] = $this->image->resize('no_image.png', 100, 100, true);

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink('admin/marketplace/category');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Marketplace/Category')) {
            // Header
            $scripts = [
                '<script src="' . base_url() . '/assets/plugins/tinymce-5.10.2/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
            ];
            $header_params = array(
                'title' => lang('Heading.categories'),
                'scripts' => $scripts,
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Marketplace\category_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.categories'),
                'href' => $this->url->administratorLink('admin/marketplace/category'),
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
    
            $data['heading_title'] = lang('Heading.categories');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.categories'),
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

        if (!$this->administrator->hasPermission('access', 'Marketplace/Category')) {
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

            $categories = $this->model_marketplace_category->getCategories($filter_data);

            if ($categories) {
                foreach ($categories as $category) {
                    $json[] = [
                        'category_id' => $category['category_id'],
                        'name' => $category['name'],
                    ];
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
