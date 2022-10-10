<?php

namespace Main\Admin\Controllers\Localisation;

class Country extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_country = new \Main\Admin\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Admin\Models\Localisation\Zone_Model();
    }

    public function index()
    {
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.countries'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country'),
            'active' => true,
        );

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
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country/edit/' . $country['country_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_admin_country_id');

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Localisation\country_list',
            'permission' => 'Localisation/Country',
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
            'text' => lang('Text.countries'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country'),
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

        $data['heading_title'] = lang('Heading.countries');

        if ($country_info) {
            $data['name'] = $country_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($country_info) {
            $data['iso_code_2'] = $country_info['iso_code_2'];
        } else {
            $data['iso_code_2'] = '';
        }

        if ($country_info) {
            $data['iso_code_3'] = $country_info['iso_code_3'];
        } else {
            $data['iso_code_3'] = '';
        }

        if ($country_info) {
            $data['dialing_code'] = $country_info['dialing_code'];
        } else {
            $data['dialing_code'] = '';
        }

        if ($country_info) {
            $data['postal_code_required'] = $country_info['postal_code_required'];
        } else {
            $data['postal_code_required'] = 0;
        }

        if ($country_info) {
            $data['sort_order'] = $country_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($country_info) {
            $data['status'] = $country_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country');

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

        // Generate view
        $template_setting = [
            'location' => 'ThemeAdmin',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Localisation\country_form',
            'permission' => 'Localisation/Country',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Country')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $country_id) {
                        // Query
                        $query = $this->model_localisation_country->deleteCountry($country_id);
                    }

                    $json['success']['toast'] = lang('Success.country_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country');
                } else {
                    $json['error']['toast'] = lang('Error.country_delete');
                }                
            }
        }

        return $this->response->setJSON($json);
    }

    public function save()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Country')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $this->validation->setRule('name', lang('Entry.name'), 'required');

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_localisation_country->editCountry($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.country_edit');
                    } else {
                        // Query
                        $query = $this->model_localisation_country->addCountry($this->request->getPost());

                        $json['success']['toast'] = lang('Success.country_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/country');
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

    public function get_country()
    {
        $json = [];

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
