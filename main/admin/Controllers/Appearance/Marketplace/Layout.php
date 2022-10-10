<?php

namespace Main\Admin\Controllers\Appearance\Marketplace;

class Layout extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_appearance_layout = new \Main\Admin\Models\Appearance\Layout_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.layouts'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.layouts');

        // Get layouts
        $data['layouts'] = [];

        $layouts = $this->model_appearance_layout->getLayouts();

        foreach ($layouts as $layout) {
            $data['layouts'][] = [
                'layout_id' => $layout['layout_id'],
                'name' => $layout['name'],
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout/edit/' . $layout['layout_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
        // Header
        $header_params = array(
            'title' => lang('Heading.layouts'),
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
            'view' => 'Appearance\Marketplace\layout_list',
            'permission' => 'Appearance/Marketplace/Layout',
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
            'text' => lang('Text.layouts'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $layout_info = $this->model_appearance_layout->getLayout($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $layout_info = [];
        }

        $data['heading_title'] = lang('Heading.layouts');

        if ($layout_info) {
            $data['name'] = $layout_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($layout_info) {
            $data['routes'] = $this->model_appearance_layout->getLayoutRoutes($layout_info['layout_id']);
        } else {
            $data['routes'] = [];
        }

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout');

        // Header
        $header_params = array(
            'title' => lang('Heading.layouts'),
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
            'view' => 'Appearance\Marketplace\layout_form',
            'permission' => 'Appearance/Marketplace/Layout',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Appearance/Marketplace/Layout')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            if (!empty($this->request->getPost('selected'))) {
                foreach ($this->request->getPost('selected') as $layout_id) {
                    // Query
                    $query = $this->model_appearance_layout->deleteLayout($layout_id);
                }

                $json['success']['toast'] = lang('Success.layout_delete');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout');
            } else {
                $json['error']['toast'] = lang('Error.administrator_delete');
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Appearance/Marketplace/Layout')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                    // Query
                    $query = $this->model_appearance_layout->editLayout('marketplace', $this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                    $json['success']['toast'] = lang('Success.layout_edit');
                } else {
                    // Query
                    $query = $this->model_appearance_layout->addlayout('marketplace', $this->request->getPost());

                    $json['success']['toast'] = lang('Success.layout_add');   
                }

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/layout');
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
