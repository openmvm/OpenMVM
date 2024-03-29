<?php

namespace Plugins\com_example\Widget_Blank\Controllers\Admin\Appearance\Marketplace\Widgets;

class Blank extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_appearance_widget = new \Main\Admin\Models\Appearance\Widget_Model();
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
    }

    public function index()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/com_example/Blank/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.blank'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget/com_example/Blank/edit' . $this->uri->getSegment($this->uri->getTotalSegments())),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.blank');
            
        $widget_info = $this->model_appearance_widget->getWidget($this->uri->getSegment($this->uri->getTotalSegments()));

        if ($widget_info) {
            $data['name'] = $widget_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($widget_info) {
            if (!empty($widget_info['setting']['height'])) {
                $data['height'] = $widget_info['setting']['height'];
            } else {
                $data['height'] = 0;
            }
        } else {
            $data['height'] = 0;
        }

        if ($widget_info) {
            if (!empty($widget_info['setting']['background_color'])) {
                $data['background_color'] = $widget_info['setting']['background_color'];
            } else {
                $data['background_color'] = '';
            }
        } else {
            $data['background_color'] = '';
        }

        if ($widget_info) {
            $data['status'] = $widget_info['status'];
        } else {
            $data['status'] = 0;
        }

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget');

        // Header
        $header_params = array(
            'title' => lang('Heading.blank'),
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
            'location' => 'Plugins',
            'author' => 'com_example',
            'theme' => 'Widget_Blank',
            'view' => 'Admin\Appearance\Marketplace\Widgets\blank',
            'permission' => 'plugins/com_example/Widget_Blank/Controllers/Admin/Appearance/Marketplace/Widgets/Blank',
            'override' => true,
        ];
        return $this->template->render($template_setting, $data);
        //return $this->template->render('Plugins', 'com_example', 'Widget_Blank', 'Admin\Appearance\Marketplace\Widgets\blank', $data, true);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'plugins/com_example/Widget_Blank/Controllers/Admin/Appearance/Marketplace/Widgets/Blank')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_appearance_widget->editWidget('marketplace', 'com_example', $this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost(), 'Widget_Blank');

                $json['success']['toast'] = lang('Success.widget_edit');

                $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/appearance/marketplace/widget');
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form');

                if ($this->validation->hasError('name')) {
                    $data['error']['name'] = $this->validation->getError('name');
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
