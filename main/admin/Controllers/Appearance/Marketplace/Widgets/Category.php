<?php

namespace Main\Admin\Controllers\Appearance\Marketplace\Widgets;

class Category extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_appearance_widget = new \Main\Admin\Models\Appearance\Widget_Model();
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_marketplace_category = new \Main\Admin\Models\Marketplace\Category_Model();
    }

    public function index()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/Category/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        return $this->get_form($data);
    }

    public function get_form($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.marketplace_widgets'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.category'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/category'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.category');
            
        $widget_info = $this->model_appearance_widget->getWidget($this->uri->getSegment($this->uri->getTotalSegments()));

        if ($widget_info) {
            $data['name'] = $widget_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($widget_info) {
            $data['display'] = $widget_info['setting']['display'];
        } else {
            $data['display'] = '';
        }

        if ($widget_info) {
            $data['column'] = $widget_info['setting']['column'];
        } else {
            $data['column'] = '';
        }

        if ($widget_info) {
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

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $scripts = [
            '<script src="' . base_url() . '/assets/plugins/tinymce_6.2.0/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Appearance\Marketplace\Widgets\category',
            'permission' => 'Appearance/Marketplace/Widgets/Category',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Appearance/Marketplace/Widgets/Category')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_appearance_widget->editWidget('marketplace', 'com_openmvm', $this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost(), '');

                $json['success']['toast'] = lang('Success.widget_edit');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                if ($this->validation->hasError('name')) {
                    $json['error']['name'] = $this->validation->getError('name');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
