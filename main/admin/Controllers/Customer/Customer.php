<?php

namespace Main\Admin\Controllers\Customer;

class Customer extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_customer_customer_group = new \Main\Admin\Models\Customer\Customer_Group_Model();
        $this->model_customer_customer = new \Main\Admin\Models\Customer\Customer_Model();
        $this->model_localisation_country = new \Main\Admin\Models\Localisation\Country_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.customers'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer'),
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

        $data['heading_title'] = lang('Heading.customers');

        // Get customers
        $data['customers'] = [];

        $customers = $this->model_customer_customer->getCustomers();

        foreach ($customers as $customer) {
            $data['customers'][] = [
                'customer_id' => $customer['customer_id'],
                'firstname' => $customer['firstname'],
                'lastname' => $customer['lastname'],
                'email' => $customer['email'],
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer/edit/' . $customer['customer_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
        // Header
        $header_params = array(
            'title' => lang('Heading.customers'),
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
            'view' => 'Customer\customer_list',
            'permission' => 'Customer/Customer',
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
            'text' => lang('Text.customers'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $customer_info = $this->model_customer_customer->getCustomer($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $customer_info = [];
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

        $data['heading_title'] = lang('Heading.customers');

        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        if ($customer_info) {
            $data['customer_group_id'] = $customer_info['customer_group_id'];
        } else {
            $data['customer_group_id'] = '';
        }

        if ($customer_info) {
            $data['username'] = $customer_info['username'];
        } else {
            $data['username'] = '';
        }

        if ($customer_info) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($customer_info) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($customer_info) {
            $data['telephone'] = $customer_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        if ($customer_info) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($customer_info) {
            $data['status'] = $customer_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($customer_info) {
            $data['customer_addresses'] = $this->model_customer_customer->getCustomerAddresses($customer_info['customer_id']);
        } else {
            $data['customer_addresses'] = [];
        }

        $data['countries'] = $this->model_localisation_country->getCountries();

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');

        $data['administrator_token'] = $this->administrator->getToken();

        // Header
        $header_params = array(
            'title' => lang('Heading.customers'),
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
            'view' => 'Customer\customer_form',
            'permission' => 'Customer/Customer',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Customer/Customer')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $customer_id) {
                        // Query
                        $query = $this->model_customer_customer->deleteCustomer($customer_id);
                    }

                    $json['success']['toast'] = lang('Success.customer_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer');
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
            if (!$this->administrator->hasPermission('modify', 'Customer/Customer')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                    $customer_info = $this->model_customer_customer->getCustomer($this->uri->getSegment($this->uri->getTotalSegments()));

                    if ($customer_info['username'] == $this->request->getPost('username')) {
                        $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|min_length[2]|max_length[35]');
                    } else {
                        $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|is_unique[customer.username]|min_length[2]|max_length[35]');
                    }

                    if ($customer_info['email'] == $this->request->getPost('email')) {
                        $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email');
                    } else {
                        $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email|is_unique[customer.email]');
                    }

                    if (!empty($this->request->getPost('password'))) {
                        $this->validation->setRule('passconf', lang('Entry.passconf'), 'required|matches[password]');
                    }
                } else {
                    $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|is_unique[customer.username]|min_length[2]|max_length[35]');
                    $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email|is_unique[customer.email]');
                    $this->validation->setRule('password', lang('Entry.password'), 'required');
                    $this->validation->setRule('passconf', lang('Entry.passconf'), 'required|matches[password]');
                }

                $this->validation->setRule('firstname', lang('Entry.firstname'), 'required');
                $this->validation->setRule('lastname', lang('Entry.lastname'), 'required');
                $this->validation->setRule('telephone', lang('Entry.telephone'), 'required');

                if (!empty($this->request->getPost('customer_address'))) {
                    $customer_address = $this->request->getPost('customer_address');

                    foreach ($customer_address as $key => $value) {
                        $this->validation->setRule('customer_address.' . $key . '.firstname', lang('Entry.firstname'), 'required');
                        $this->validation->setRule('customer_address.' . $key . '.lastname', lang('Entry.lastname'), 'required');
                        $this->validation->setRule('customer_address.' . $key . '.address_1', lang('Entry.address_1'), 'required');
                        $this->validation->setRule('customer_address.' . $key . '.city', lang('Entry.city'), 'required');
                        $this->validation->setRule('customer_address.' . $key . '.country_id', lang('Entry.country'), 'required|greater_than[0]');
                        $this->validation->setRule('customer_address.' . $key . '.zone_id', lang('Entry.zone'), 'required|greater_than[0]');
                        $this->validation->setRule('customer_address.' . $key . '.telephone', lang('Entry.telephone'), 'required');
                    }
                }

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_customer_customer->editCustomer($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.customer_edit');
                    } else {
                        // Query
                        $query = $this->model_customer_customer->addCustomer($this->request->getPost());

                        $json['success']['toast'] = lang('Success.customer_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/customer/customer');
                } else {
                    // Errors
                    $json['error']['toast'] = lang('Error.form');

                    if ($this->validation->hasError('username')) {
                        $json['error']['username'] = $this->validation->getError('username');
                    }

                    if ($this->validation->hasError('firstname')) {
                        $json['error']['firstname'] = $this->validation->getError('firstname');
                    }

                    if ($this->validation->hasError('lastname')) {
                        $json['error']['lastname'] = $this->validation->getError('lastname');
                    }

                    if ($this->validation->hasError('telephone')) {
                        $json['error']['telephone'] = $this->validation->getError('telephone');
                    }

                    if ($this->validation->hasError('email')) {
                        $json['error']['email'] = $this->validation->getError('email');
                    }

                    if ($this->validation->hasError('passconf')) {
                        $json['error']['passconf'] = $this->validation->getError('passconf');
                    }

                    if (!empty($this->request->getPost('customer_address'))) {
                        $customer_address = $this->request->getPost('customer_address');

                        foreach ($customer_address as $key => $value) {
                            if ($this->validation->hasError('customer_address.' . $key . '.firstname')) {
                                $json['error']['firstname-' . $key] = $this->validation->getError('customer_address.' . $key . '.firstname');
                            }

                            if ($this->validation->hasError('customer_address.' . $key . '.lastname')) {
                                $json['error']['lastname-' . $key] = $this->validation->getError('customer_address.' . $key . '.lastname');
                            }

                            if ($this->validation->hasError('customer_address.' . $key . '.address_1')) {
                                $json['error']['address-1-' . $key] = $this->validation->getError('customer_address.' . $key . '.address_1');
                            }

                            if ($this->validation->hasError('customer_address.' . $key . '.city')) {
                                $json['error']['city-' . $key] = $this->validation->getError('customer_address.' . $key . '.city');
                            }

                            if ($this->validation->hasError('customer_address.' . $key . '.country_id')) {
                                $json['error']['country-' . $key] = $this->validation->getError('customer_address.' . $key . '.country_id');
                            }

                            if ($this->validation->hasError('customer_address.' . $key . '.zone_id')) {
                                $json['error']['zone-' . $key] = $this->validation->getError('customer_address.' . $key . '.zone_id');
                            }

                            if ($this->validation->hasError('customer_address.' . $key . '.telephone')) {
                                $json['error']['telephone-' . $key] = $this->validation->getError('customer_address.' . $key . '.telephone');
                            }
                        }
                    }
                }
            }
        }

        return $this->response->setJSON($json);
    }
}
