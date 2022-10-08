<?php

namespace Main\Admin\Controllers\Localisation;

class Order_Status extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_language = new \Main\Admin\Models\Localisation\Language_Model();
        $this->model_localisation_order_status = new \Main\Admin\Models\Localisation\Order_Status_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.order_statuses'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.order_statuses');

        // Get order statuses
        $data['order_statuses'] = [];

        $order_statuses = $this->model_localisation_order_status->getOrderStatuses();

        foreach ($order_statuses as $order_status) {
            $data['order_statuses'][] = [
                'order_status_id' => $order_status['order_status_id'],
                'name' => $order_status['name'],
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status/edit/' . $order_status['order_status_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_admin_order_status_id');

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Localisation/Order_Status')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.order_statuses'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\order_status_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.order_statuses'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status'),
                'active' => true,
            );
    
            $data['heading_title'] = lang('Heading.order_statuses');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.order_statuses'),
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
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.order_statuses'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $order_status_info = $this->model_localisation_order_status->getOrderStatus($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $order_status_info = [];
        }

        $data['heading_title'] = lang('Heading.order_statuses');

        if ($order_status_info) {
            $data['description'] = $this->model_localisation_order_status->getOrderStatusDescriptions($order_status_info['order_status_id']);
        } else {
            $data['description'] = [];
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status');

        if ($this->administrator->hasPermission('access', 'Localisation/Order_Status')) {
            // Header
            $scripts = [
                '<script src="' . base_url() . '/assets/plugins/tinymce_6.1.2/js/tinymce/tinymce.min.js" type="text/javascript"></script>',
            ];
            $header_params = array(
                'title' => lang('Heading.order_statuses'),
                'scripts' => $scripts,
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\order_status_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );
    
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.order_statuses'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status'),
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
    
            $data['heading_title'] = lang('Heading.order_statuses');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.order_statuses'),
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

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Order_Status')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $order_status_id) {
                        // Query
                        $query = $this->model_localisation_order_status->deleteOrderStatus($order_status_id);
                    }

                    $json['success']['toast'] = lang('Success.order_status_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status');
                } else {
                    $json['error']['toast'] = lang('Error.order_status_delete');
                }                
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Order_Status')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $languages = $this->model_localisation_language->getlanguages();

                foreach ($languages as $language) {
                    $this->validation->setRule('description.' . $language['language_id'] . '.name', lang('Entry.name') . ' ' . lang('Text.in') . ' ' . $language['name'], 'required');
                }

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_localisation_order_status->editOrderStatus($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.order_status_edit');
                    } else {
                        // Query
                        $query = $this->model_localisation_order_status->addOrderStatus($this->request->getPost());

                        $json['success']['toast'] = lang('Success.order_status_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/order_status');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    $languages = $this->model_localisation_language->getlanguages();

                    foreach ($languages as $language) {
                        if ($this->validation->hasError('description.' . $language['language_id'] . '.name')) {
                            $json['error']['name-' . $language['language_id']] = $this->validation->getError('description.' . $language['language_id'] . '.name');
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

        if (!$this->administrator->hasPermission('access', 'Localisation/Order_Status')) {
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

            $order_statuses = $this->model_localisation_order_status->getOrderStatuses($filter_data);

            if ($order_statuses) {
                foreach ($order_statuses as $order_status) {
                    $json[] = [
                        'order_status_id' => $order_status['order_status_id'],
                        'name' => $order_status['name'],
                    ];
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
