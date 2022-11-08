<?php

namespace Main\Admin\Controllers\Marketplace;

class Category extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_marketplace_category = new \Main\Admin\Models\Marketplace\Category_Model();
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.categories'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category'),
            'active' => true,
        );

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
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category/edit/' . $category['category_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Marketplace\category_list',
            'permission' => 'Marketplace/Category',
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
            'text' => lang('Text.categories'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category'),
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

        $data['heading_title'] = lang('Heading.categories');

        if ($category_info) {
            $data['category_description'] = $this->model_marketplace_category->getCategoryDescriptions($category_info['category_id']);
        } else {
            $data['category_description'] = [];
        }

        if ($category_info) {
            $data['parent'] = $this->model_marketplace_category->getCategoryPath($category_info['category_id']);
        } else {
            $data['parent'] = '';
        }

        if ($category_info) {
            $data['parent_id'] = $category_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }

        if ($category_info) {
            $data['image'] = $category_info['image'];
        } else {
            $data['image'] = '';
        }

        if (!empty($category_info['image']) && is_file(ROOTPATH . 'public/assets/images/' . $category_info['image'])) {
            $data['thumb'] = $this->image->resize($category_info['image'], 100, 100, true);
        } else {
            $data['thumb'] = $this->image->resize('no_image.png', 100, 100, true);
        }

        if ($category_info) {
            $data['sort_order'] = $category_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($category_info) {
            $data['status'] = $category_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['placeholder'] = $this->image->resize('no_image.png', 100, 100, true);

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $scripts = [
            '<script src="' . base_url() . '/assets/plugins/tinymce_6.2.0/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Marketplace\category_form',
            'permission' => 'Marketplace/Category',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Marketplace/Category')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $category_id) {
                        // Query
                        $query = $this->model_marketplace_category->deleteCategory($category_id);
                    }

                    $json['success']['toast'] = lang('Success.category_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category');
                } else {
                    $json['error']['toast'] = lang('Error.category_delete');
                }                
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Marketplace/Category')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    $this->validation->setRule('category_description.' . $language['language_id'] . '.name', lang('Entry.name') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                    $this->validation->setRule('category_description.' . $language['language_id'] . '.meta_title', lang('Entry.meta_title') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                }

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_marketplace_category->editCategory($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.category_edit');
                    } else {
                        // Query
                        $query = $this->model_marketplace_category->addCategory($this->request->getPost());

                        $json['success']['toast'] = lang('Success.category_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/marketplace/category');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    $languages = $this->model_localisation_language->getlanguages();

                    foreach ($languages as $language) {
                        if ($this->validation->hasError('category_description.' . $language['language_id'] . '.name')) {
                            $json['error']['name-' . $language['language_id']] = $this->validation->getError('category_description.' . $language['language_id'] . '.name');
                        }

                        if ($this->validation->hasError('category_description.' . $language['language_id'] . '.meta_title')) {
                            $json['error']['meta-title-' . $language['language_id']] = $this->validation->getError('category_description.' . $language['language_id'] . '.meta_title');
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
