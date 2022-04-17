<?php

namespace App\Controllers\Admin\Localisation;

class Country extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_country = new \App\Models\Admin\Localisation\Country_Model();
        $this->model_localisation_zone = new \App\Models\Admin\Localisation\Zone_Model();
    }

    public function index()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['action'] = $this->url->administratorLink('admin/localisation/country');

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('selected'))) {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Country')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/localisation/country'));
            }

            foreach ($this->request->getPost('selected') as $country_id) {
                // Query
                $query = $this->model_localisation_country->deleteCountry($country_id);
            }

            $this->session->set('success', lang('Success.country_delete'));

            return redirect()->to($this->url->administratorLink('admin/localisation/country'));
        }

        return $this->get_list($data);
    }

    public function add()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink('admin/localisation/country/add');

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Country')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/localisation/country/add'));
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_localisation_country->addCountry($this->request->getPost());

                $this->session->set('success', lang('Success.country_add'));

                return redirect()->to($this->url->administratorLink('admin/localisation/country'));
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

    public function edit()
    {
        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            return redirect()->to('admin/administrator/login');
        }

        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink('admin/localisation/country/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()));

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Country')) {
                $this->session->set('error', lang('Error.modify_permission'));

                return redirect()->to($this->url->administratorLink('admin/localisation/country/edit/' . $this->uri->getSegment($this->uri->getTotalSegments())));
            }

            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_localisation_country->editCountry($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                $this->session->set('success', lang('Success.country_edit'));

                return redirect()->to($this->url->administratorLink('admin/localisation/country'));
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

    public function get_list($data)
    {
        $data['breadcrumbs'][] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->administratorLink('admin/common/dashboard'),
            'active' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('Text.countries'),
            'href' => $this->url->administratorLink('admin/localisation/country'),
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

        $data['heading_title'] = lang('Heading.countries');

        // Get countries
        $data['countries'] = [];

        $countries = $this->model_localisation_country->getCountries();

        foreach ($countries as $country) {
            $data['countries'][] = [
                'country_id' => $country['country_id'],
                'name' => $country['name'],
                'sort_order' => $country['sort_order'],
                'status' => $country['status'] ? lang('Text.enabled') : lang('Text.disabled'),
                'href' => $this->url->administratorLink('admin/localisation/country/edit/' . $country['country_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_admin_country_id');

        $data['add'] = $this->url->administratorLink('admin/localisation/country/add');
        $data['cancel'] = $this->url->administratorLink('admin/common/dashboard');
		
        if ($this->administrator->hasPermission('access', 'Localisation/Country')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.countries'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\country_list', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.countries'),
                'href' => $this->url->administratorLink('admin/localisation/country'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.countries');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.countries'),
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
            'text' => lang('Text.countries'),
            'href' => $this->url->administratorLink('admin/localisation/country'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $country_info = $this->model_localisation_country->getCountry($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $country_info = [];
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

        $data['heading_title'] = lang('Heading.countries');

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif ($country_info) {
            $data['name'] = $country_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('iso_code_2')) {
            $data['iso_code_2'] = $this->request->getPost('iso_code_2');
        } elseif ($country_info) {
            $data['iso_code_2'] = $country_info['iso_code_2'];
        } else {
            $data['iso_code_2'] = '';
        }

        if ($this->request->getPost('iso_code_3')) {
            $data['iso_code_3'] = $this->request->getPost('iso_code_3');
        } elseif ($country_info) {
            $data['iso_code_3'] = $country_info['iso_code_3'];
        } else {
            $data['iso_code_3'] = '';
        }

        if ($this->request->getPost('dialing_code')) {
            $data['dialing_code'] = $this->request->getPost('dialing_code');
        } elseif ($country_info) {
            $data['dialing_code'] = $country_info['dialing_code'];
        } else {
            $data['dialing_code'] = '';
        }

        if ($this->request->getPost('postal_code_required')) {
            $data['postal_code_required'] = $this->request->getPost('postal_code_required');
        } elseif ($country_info) {
            $data['postal_code_required'] = $country_info['postal_code_required'];
        } else {
            $data['postal_code_required'] = 0;
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif ($country_info) {
            $data['sort_order'] = $country_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($country_info) {
            $data['status'] = $country_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink('admin/localisation/country');

        if ($this->administrator->hasPermission('access', 'Localisation/Country')) {
            // Header
            $header_params = array(
                'title' => lang('Heading.countries'),
            );
            $data['header'] = $this->admin_header->index($header_params);
            // Column Left
            $column_left_params = array();
            $data['column_left'] = $this->admin_column_left->index($column_left_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->admin_footer->index($footer_params);

            return $this->template->render('ThemeAdmin', 'com_openmvm', 'Basic', 'Localisation\country_form', $data);
        } else {
            $data = [];

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.dashboard'),
                'href' => $this->url->administratorLink('admin/common/dashboard'),
                'active' => false,
            );

            $data['breadcrumbs'][] = array(
                'text' => lang('Text.countries'),
                'href' => $this->url->administratorLink('admin/localisation/country'),
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

            $data['heading_title'] = lang('Heading.countries');

            $data['code_number'] = 403;
            $data['code_text'] = lang('Text.forbidden');

            $data['message'] = lang('Error.access_permission');

            // Header
            $header_params = [
                'title' => lang('Heading.countries'),
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

    public function get_country()
    {
        $json = [];

        if (!$this->administrator->isLoggedIn() || !$this->administrator->verifyToken($this->request->getGet('administrator_token'))) {
            $json['error'] = lang('Error.login');
        }

        if (!$this->administrator->hasPermission('access', 'Localisation/Country')) {
            $json['error'] = lang('Error.access_permission');
        }

        if (empty($this->request->getGet('country_id'))) {
            $json['error'] = lang('Error.missing_parameters');
        }

        if (empty($json['error'])) {
            $country_info = $this->model_localisation_country->getCountry($this->request->getGet('country_id'));

            if ($country_info) {
                $zone_data = [];

                $zones = $this->model_localisation_zone->getZonesByCountryId($country_info['country_id']);

                if ($zones) {
                    foreach ($zones as $zone) {
                        $zone_data[] = [
                            'zone_id' => $zone['zone_id'],
                            'name' => $zone['name'],
                            'code' => $zone['code'],
                        ];
                    }
                }

                $json = [
                    'country_id' => $country_info['country_id'],
                    'name' => $country_info['name'],
                    'iso_code_2' => $country_info['iso_code_2'],
                    'iso_code_3' => $country_info['iso_code_3'],
                    'dialing_code' => $country_info['dialing_code'],
                    'postal_code_required' => $country_info['postal_code_required'],
                    'zones' => $zone_data,
                ];
            }
        }

        return $this->response->setJSON($json);
    }

    public function autocomplete()
    {
        $json = [];

        $json = [
            [
                'name' => 'Afghanistan',
                'id' => '1',
            ],
            [
                'name' => 'Argentina',
                'id' => '2',
            ],
            [
                'name' => 'Brazil',
                'id' => '3',
            ],
            [
                'name' => 'Indonesia',
                'id' => '4',
            ],
        ];

        return $this->response->setJSON($json);
    }
}
