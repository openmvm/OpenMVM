<?php

namespace Main\Admin\Controllers\Customer;

class Customer_Group extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_customer_customer_group = new \Main\Admin\Models\Customer\Customer_Group_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.customer_groups'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.customer_groups');

        // Get customer groups
        $data['customer_groups'] = [];

        $customer_groups = $this->model_customer_customer_group->getCustomerGroups();

        foreach ($customer_groups as $customer_group) {
            $data['customer_groups'][] = [
                'customer_group_id' => $customer_group['customer_group_id'],
                'name' => $customer_group['name'],
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group/edit/' . $customer_group['customer_group_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Customer/Customer_Group')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.customer_groups'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com.openmvm', 'Basic', 'Customer\customer_group_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.customer_groups'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.customer_groups');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.customer_groups'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com.openmvm', 'Basic', 'Common\permission', $data);
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
            'text' => lang('Text.customer_groups'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $customer_group_info = $this->model_customer_customer_group->getCustomerGroup($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $customer_group_info = [];
        }

        $data['heading_title'] = lang('Heading.customer_groups');

        if ($customer_group_info) {
            $data['name'] = $customer_group_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($customer_group_info) {
            $data['email_verification'] = $customer_group_info['email_verification'];
        } else {
            $data['email_verification'] = 0;
        }

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');

        if ($this->administrator->hasPermission('access', 'Customer/Customer_Group')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.customer_groups'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com.openmvm', 'Basic', 'Customer\customer_group_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.customer_groups'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group'),
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

            $data['heading_title'] = lang('Heading.customer_groups');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.customer_groups'),
            ];
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = [];
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = [];
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com.openmvm', 'Basic', 'Common\permission', $data);
        }
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Customer/Customer_Group')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $customer_group_id) {
                        // Query
                        $query = $this->model_customer_customer_group->deleteCustomerGroup($customer_group_id);
                    }

                    $json['success']['toast'] = lang('Success.customer_group_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group');
                } else {
                    $json['error']['toast'] = lang('Error.administrator_delete');
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Customer/Customer_Group')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $this->validation->setRule('name', lang('Entry.name'), 'required');

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_customer_customer_group->editCustomerGroup($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.customer_group_edit');
                    } else {
                        // Query
                        $query = $this->model_customer_customer_group->addCustomerGroup($this->request->getPost());

                        $json['success']['toast'] = lang('Success.customer_group_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer_group');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    if ($this->validation->hasError('name')) {
                        $json['error']['name'] = $this->validation->getError('name');
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
