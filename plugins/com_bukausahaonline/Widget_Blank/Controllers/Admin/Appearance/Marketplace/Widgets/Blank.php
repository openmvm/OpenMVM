<?php

namespace Plugins\com_bukausahaonline\Widget_Blank\Controllers\Admin\Appearance\Marketplace\Widgets;

class Blank extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_appearance_widget = new \App\Models\Admin\Appearance\Widget_Model();
        $this->model_localisation_language = new \App\Models\Admin\Localisation\Language_Model();
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

        $data['action'] = $this->url->administratorLink('admin/appearance/marketplace/widgets/com_bukausahaonline/Blank/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'plugins/com_bukausahaonline/Widget_Blank/Controllers/Admin/Appearance/Marketplace/Widgets/Blank')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/appearance/marketplace/widget'));
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_appearance_widget->editWidget('marketplace', 'com_bukausahaonline', $this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost(), 'Widget_Blank');

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
            'text' => lang('Text.blank'),
            'href' => $this->url->administratorLink('admin/appearance/marketplace/widgets/com_bukausahaonline/Blank/edit' . $this->uri->getSegment($this->uri->getTotalSegments())),
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

        $data['heading_title'] = lang('Heading.blank');
            
        $widget_info = $this->model_appearance_widget->getWidget($this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif ($widget_info) {
            $data['name'] = $widget_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('height')) {
            $data['height'] = $this->request->getPost('height');
        } elseif ($widget_info) {
            if (!empty($widget_info['setting']['height'])) {
                $data['height'] = $widget_info['setting']['height'];
            } else {
                $data['height'] = 0;
            }
        } else {
            $data['height'] = 0;
        }

        if ($this->request->getPost('background_color')) {
            $data['background_color'] = $this->request->getPost('background_color');
        } elseif ($widget_info) {
            if (!empty($widget_info['setting']['background_color'])) {
                $data['background_color'] = $widget_info['setting']['background_color'];
            } else {
                $data['background_color'] = '';
            }
        } else {
            $data['background_color'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($widget_info) {
            $data['status'] = $widget_info['status'];
        } else {
            $data['status'] = 0;
        }

        $data['cancel'] = $this->url->administratorLink('admin/appearance/marketplace/widget');

        if ($this->administrator->hasPermission('access', 'plugins/com_bukausahaonline/Widget_Blank/Controllers/Admin/Appearance/Marketplace/Widgets/Blank')) {
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

            return $this->template->render('Plugins', 'com_bukausahaonline', 'Widget_Blank', 'Admin\Appearance\Marketplace\Widgets\blank', $data, true);
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
                'text' => lang('Text.blank'),
                'href' => $this->url->administratorLink('admin/appearance/marketplace/widgets/com_bukausahaonline/Blank/edit' . $this->uri->getSegment($this->uri->getTotalSegments())),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.blank');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.blank'),
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
