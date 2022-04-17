<?php

namespace App\Controllers\Admin\Appearance\Marketplace\Widgets;

class Category extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_appearance_widget = new \App\Models\Admin\Appearance\Widget_Model();
        $this->model_localisation_language = new \App\Models\Admin\Localisation\Language_Model();
        $this->model_marketplace_category = new \App\Models\Admin\Marketplace\Category_Model();
    }

    public function index()
    {
        return false;
    }

    public function edit()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink('admin/appearance/marketplace/widgets/Category/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Appearance/Marketplace/Widgets/Category')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/appearance/marketplace/widget'));
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_appearance_widget->editWidget('marketplace', 'com_openmvm', $this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost(), '');

                $this->session->set('success', lang('Success.widget_edit'));

                return redirect()->to($this->url->administratorLink('admin/appearance/marketplace/widget'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('name')) {
                    $data['error_name'] = $this->validation->getError('name');
                } else {
                    $data['error_name'] = '';
                }
            }
        }

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.marketplace_widgets'),
            'href' => $this->url->administratorLink('admin/appearance/marketplace/widget'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.category'),
            'href' => $this->url->administratorLink('admin/appearance/marketplace/widgets/category'),
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

        $data['heading_title'] = lang('Heading.category');
            
        $widget_info = $this->model_appearance_widget->getWidget($this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif ($widget_info) {
            $data['name'] = $widget_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('display')) {
            $data['display'] = $this->request->getPost('display');
        } elseif ($widget_info) {
            $data['display'] = $widget_info['setting']['display'];
        } else {
            $data['display'] = '';
        }

        if ($this->request->getPost('column')) {
            $data['column'] = $this->request->getPost('column');
        } elseif ($widget_info) {
            $data['column'] = $widget_info['setting']['column'];
        } else {
            $data['column'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($widget_info) {
            $data['status'] = $widget_info['status'];
        } else {
            $data['status'] = 0;
        }

        if ($this->request->getPost('category')) {
            $data['categories'] = $this->request->getPost('category');
        } elseif ($widget_info) {
            if (!empty($widget_info['setting']['category'])) {
                $categories = $widget_info['setting']['category'];

                foreach ($categories as $category) {
                    // Get category info
                    $category_info = $this->model_marketplace_category->getCategory($category['category_id']);

                    if ($category_info) {
                        // Get category description
                        $category_description = $this->model_marketplace_category->getCategoryDescription($category_info['category_id']);

                        $category_id = $category_info['category_id'];
                        $name = $category_description['name'];
                    } else {
                        $category_id = 0;
                        $name = lang('Text.none', [], $this->language->getCurrentCode(true));
                    }

                    $data['categories'][] = [
                        'category_id' => $category_id,
                        'name' => $name,
                        'image' => $category['image'],
                        'width' => $category['width'],
                        'sort_order' => $category['sort_order'],
                        'show_sub_categories' => $category['show_sub_categories'],
                        'limit_sub_categories' => $category['limit_sub_categories'],
                        'image_sub_categories' => $category['image_sub_categories'],
                    ];
                }
            } else {
                $data['categories'] = [];
            }
        } else {
            $data['categories'] = [];
        }

        $sort_order = array();

        foreach ($data['categories'] as $key => $row)
        {
            $sort_order[$key] = $row['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $data['categories']);

        $data['column_widths'] = [1,2,3,4,5,6,7,8,9,10,11,12];

        $data['cancel'] = $this->url->administratorLink('admin/appearance/marketplace/widget');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Appearance/Marketplace/Widgets/Category')) {
            // Header
            $scripts = [
                '<script src="' . base_url() . '/assets/plugins/tinymce-5.10.2/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
            ];
            $header_params = array(
                'title' => lang('Heading.category'),
                'scripts' => $scripts,
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Appearance\Marketplace\Widgets\category', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.marketplace_widgets'),
                'href' => $this->url->administratorLink('admin/appearance/marketplace/widget'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.category'),
                'href' => $this->url->administratorLink('admin/appearance/marketplace/widgets/category'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.category');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.category'),
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
