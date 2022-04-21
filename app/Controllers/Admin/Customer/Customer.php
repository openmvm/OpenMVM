<?php

namespace App\Controllers\Admin\Customer;

class Customer extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_customer_customer_group = new \App\Models\Admin\Customer\Customer_Group_Model();
        $this->model_customer_customer = new \App\Models\Admin\Customer\Customer_Model();
        $this->model_localisation_country = new \App\Models\Admin\Localisation\Country_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/customer/customer');

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('selected'))) {
            if (!$this->administrator->hasPermission('modify', 'Customer/Customer')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/customer/customer'));
            }

            foreach ($this->request->getPost('selected') as $customer_id) {
                // Query
                $query = $this->model_customer_customer->deleteCustomer($customer_id);
            }

            $this->session->set('success', lang('Success.customer_delete'));

            return redirect()->to($this->url->administratorLink('admin/customer/customer'));
        }

        return $this->get_list($data);
    }

    public function add()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink('admin/customer/customer/add');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Customer/Customer')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/customer/customer/add'));
            }

            $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|is_unique[customer.username]|min_length[2]|max_length[35]');
            $this->validation->setRule('firstname', lang('Entry.firstname'), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname'), 'required');
            $this->validation->setRule('telephone', lang('Entry.telephone'), 'required');
            $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email|is_unique[customer.email]');
            $this->validation->setRule('password', lang('Entry.password'), 'required');
            $this->validation->setRule('passconf', lang('Entry.passconf'), 'required|matches[password]');

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
                // Query
                $query = $this->model_customer_customer->addCustomer($this->request->getPost());

                $this->session->set('success', lang('Success.customer_add'));

                return redirect()->to($this->url->administratorLink('admin/customer/customer'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('username')) {
                    $data['error_username'] = $this->validation->getError('username');
                } else {
                    $data['error_username'] = '';
                }

                if ($this->validation->hasError('firstname')) {
                    $data['error_firstname'] = $this->validation->getError('firstname');
                } else {
                    $data['error_firstname'] = '';
                }

                if ($this->validation->hasError('lastname')) {
                    $data['error_lastname'] = $this->validation->getError('lastname');
                } else {
                    $data['error_lastname'] = '';
                }

                if ($this->validation->hasError('telephone')) {
                    $data['error_telephone'] = $this->validation->getError('telephone');
                } else {
                    $data['error_telephone'] = '';
                }

                if ($this->validation->hasError('email')) {
                    $data['error_email'] = $this->validation->getError('email');
                } else {
                    $data['error_email'] = '';
                }

                if ($this->validation->hasError('password')) {
                    $data['error_password'] = $this->validation->getError('password');
                } else {
                    $data['error_password'] = '';
                }

                if ($this->validation->hasError('passconf')) {
                    $data['error_passconf'] = $this->validation->getError('passconf');
                } else {
                    $data['error_passconf'] = '';
                }

                if (!empty($this->request->getPost('customer_address'))) {
                    $customer_address = $this->request->getPost('customer_address');

                    foreach ($customer_address as $key => $value) {
                        if ($this->validation->hasError('customer_address.' . $key . '.firstname')) {
                            $data['error_customer_address_' . $key . '_firstname'] = $this->validation->getError('customer_address.' . $key . '.firstname');
                        } else {
                            $data['error_customer_address_' . $key . '_firstname'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.lastname')) {
                            $data['error_customer_address_' . $key . '_lastname'] = $this->validation->getError('customer_address.' . $key . '.lastname');
                        } else {
                            $data['error_customer_address_' . $key . '_lastname'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.address_1')) {
                            $data['error_customer_address_' . $key . '_address_1'] = $this->validation->getError('customer_address.' . $key . '.address_1');
                        } else {
                            $data['error_customer_address_' . $key . '_address_1'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.city')) {
                            $data['error_customer_address_' . $key . '_city'] = $this->validation->getError('customer_address.' . $key . '.city');
                        } else {
                            $data['error_customer_address_' . $key . '_city'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.country_id')) {
                            $data['error_customer_address_' . $$key . '_country_id'] = $this->validation->getError('customer_address.' . $key . '.country_id');
                        } else {
                            $data['error_customer_address_' . $key . '_country_id'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.zone_id')) {
                            $data['error_customer_address_' . $key . '_zone_id'] = $this->validation->getError('customer_address.' . $key . '.zone_id');
                        } else {
                            $data['error_customer_address_' . $key . '_zone_id'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.telephone')) {
                            $data['error_customer_address_' . $key . '.telephone'] = $this->validation->getError('customer_address.' . $key . '.telephone');
                        } else {
                            $data['error_customer_address_' . $key . '_telephone'] = '';
                        }
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

        $data['action'] = $this->url->administratorLink('admin/customer/customer/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Customer/Customer')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/customer/customer/edit/' . $this->uri->getSegment($this->uri->getTotalSegments())));
            }

            $customer_info = $this->model_customer_customer->getCustomer($this->uri->getSegment($this->uri->getTotalSegments()));

            if ($customer_info['username'] == $this->request->getPost('username')) {
                $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|min_length[2]|max_length[35]');
            } else {
                $this->validation->setRule('username', lang('Entry.username'), 'required|alpha_numeric_space|is_unique[customer.username]|min_length[2]|max_length[35]');
            }

            $this->validation->setRule('firstname', lang('Entry.firstname'), 'required');
            $this->validation->setRule('lastname', lang('Entry.lastname'), 'required');
            $this->validation->setRule('telephone', lang('Entry.telephone'), 'required');

            if ($customer_info['email'] == $this->request->getPost('email')) {
                $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email');
            } else {
                $this->validation->setRule('email', lang('Entry.email'), 'required|valid_email|is_unique[customer.email]');
            }

            if (!empty($this->request->getPost('password'))) {
                $this->validation->setRule('passconf', lang('Entry.passconf'), 'required|matches[password]');
            }

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
                // Query
                $query = $this->model_customer_customer->editCustomer($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                $this->session->set('success', lang('Success.customer_edit'));

                return redirect()->to($this->url->administratorLink('admin/customer/customer'));
            } else {
                // Errors
                $this->session->set('error', lang('Error.form'));

                if ($this->validation->hasError('username')) {
                    $data['error_username'] = $this->validation->getError('username');
                } else {
                    $data['error_username'] = '';
                }

                if ($this->validation->hasError('firstname')) {
                    $data['error_firstname'] = $this->validation->getError('firstname');
                } else {
                    $data['error_firstname'] = '';
                }

                if ($this->validation->hasError('lastname')) {
                    $data['error_lastname'] = $this->validation->getError('lastname');
                } else {
                    $data['error_lastname'] = '';
                }

                if ($this->validation->hasError('telephone')) {
                    $data['error_telephone'] = $this->validation->getError('telephone');
                } else {
                    $data['error_telephone'] = '';
                }

                if ($this->validation->hasError('email')) {
                    $data['error_email'] = $this->validation->getError('email');
                } else {
                    $data['error_email'] = '';
                }

                if ($this->validation->hasError('passconf')) {
                    $data['error_passconf'] = $this->validation->getError('passconf');
                } else {
                    $data['error_passconf'] = '';
                }

                if (!empty($this->request->getPost('customer_address'))) {
                    $customer_address = $this->request->getPost('customer_address');

                    foreach ($customer_address as $key => $value) {
                        if ($this->validation->hasError('customer_address.' . $key . '.firstname')) {
                            $data['error_customer_address_' . $key . '_firstname'] = $this->validation->getError('customer_address.' . $key . '.firstname');
                        } else {
                            $data['error_customer_address_' . $key . '_firstname'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.lastname')) {
                            $data['error_customer_address_' . $key . '_lastname'] = $this->validation->getError('customer_address.' . $key . '.lastname');
                        } else {
                            $data['error_customer_address_' . $key . '_lastname'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.address_1')) {
                            $data['error_customer_address_' . $key . '_address_1'] = $this->validation->getError('customer_address.' . $key . '.address_1');
                        } else {
                            $data['error_customer_address_' . $key . '_address_1'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.city')) {
                            $data['error_customer_address_' . $key . '_city'] = $this->validation->getError('customer_address.' . $key . '.city');
                        } else {
                            $data['error_customer_address_' . $key . '_city'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.country_id')) {
                            $data['error_customer_address_' . $$key . '_country_id'] = $this->validation->getError('customer_address.' . $key . '.country_id');
                        } else {
                            $data['error_customer_address_' . $key . '_country_id'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.zone_id')) {
                            $data['error_customer_address_' . $key . '_zone_id'] = $this->validation->getError('customer_address.' . $key . '.zone_id');
                        } else {
                            $data['error_customer_address_' . $key . '_zone_id'] = '';
                        }

                        if ($this->validation->hasError('customer_address.' . $key . '.telephone')) {
                            $data['error_customer_address_' . $key . '_telephone'] = $this->validation->getError('customer_address.' . $key . '.telephone');
                        } else {
                            $data['error_customer_address_' . $key . '_telephone'] = '';
                        }
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
            'text' => lang('Text.customers'),
            'href' => $this->url->administratorLink('admin/customer/customer'),
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
                'href' => $this->url->administratorLink('admin/customer/customer/edit/' . $customer['customer_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->administratorLink('admin/customer/customer/add');
        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Customer/Customer')) {
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

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Customer\customer_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.customers'),
                'href' => $this->url->administratorLink('admin/customer/customer'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.customers');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.customers'),
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
            'text' => lang('Text.customers'),
            'href' => $this->url->administratorLink('admin/customer/customer'),
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

        if ($this->request->getPost('customer_group_id')) {
            $data['customer_group_id'] = $this->request->getPost('customer_group_id');
        } elseif ($customer_info) {
            $data['customer_group_id'] = $customer_info['customer_group_id'];
        } else {
            $data['customer_group_id'] = '';
        }

        if ($this->request->getPost('username')) {
            $data['username'] = $this->request->getPost('username');
        } elseif ($customer_info) {
            $data['username'] = $customer_info['username'];
        } else {
            $data['username'] = '';
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif ($customer_info) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif ($customer_info) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('telephone')) {
            $data['telephone'] = $this->request->getPost('telephone');
        } elseif ($customer_info) {
            $data['telephone'] = $customer_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } elseif ($customer_info) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($customer_info) {
            $data['status'] = $customer_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($this->request->getPost('customer_address')) {
            $data['customer_addresses'] = $this->request->getPost('customer_address');
        } elseif ($customer_info) {
            $data['customer_addresses'] = $this->model_customer_customer->getCustomerAddresses($customer_info['customer_id']);
        } else {
            $data['customer_addresses'] = [];
        }

        $data['countries'] = $this->model_localisation_country->getCountries();

        $data['validation'] = $this->validation;

        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');

        $data['administrator_token'] = $this->administrator->getToken();

        if ($this->administrator->hasPermission('access', 'Customer/Customer')) {
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

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Customer\customer_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.customers'),
                'href' => $this->url->administratorLink('admin/customer/customer'),
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

            $data['heading_title'] = lang('Heading.customers');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.customers'),
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