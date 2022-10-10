<?php

namespace Main\Admin\Controllers\Localisation;

class Zone extends \App\Controllers\BaseController
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
        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone/delete');

        return $this->get_list($data);
    }

    public function add()
    {
        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone/save');

        return $this->get_form($data);
    }

    public function edit()
    {
        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone/save/' . $this->uri->getSegment($this->uri->getTotalSegments()));

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
            'text' => lang('Text.zones'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone'),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.zones');

        // Get zones
        $data['zones'] = [];

        $zones = $this->model_localisation_zone->getZones();

        foreach ($zones as $zone) {
            $country_info = $this->model_localisation_country->getCountry($zone['country_id']);

            if ($country_info) {
                $country = $country_info['name'];
            } else {
                $country = '';
            }

            $data['zones'][] = [
                'zone_id' => $zone['zone_id'],
                'name' => $zone['name'],
                'country' => $country,
                'sort_order' => $zone['sort_order'],
                'status' => $zone['status'] ? lang('Text.enabled') : lang('Text.disabled'),
                'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone/edit/' . $zone['zone_id']),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['default'] = $this->setting->get('setting_admin_zone_id');

        $data['add'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone/add');
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/common/dashboard');
	
        // Header
        $header_params = array(
            'title' => lang('Heading.zones'),
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
            'view' => 'Localisation\zone_list',
            'permission' => 'Localisation/Zone',
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
            'text' => lang('Text.zones'),
            'href' => $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone'),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $zone_info = $this->model_localisation_zone->getZone($this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $data['breadcrumbs'][] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $zone_info = [];
        }

        $data['heading_title'] = lang('Heading.zones');

        if ($zone_info) {
            $data['name'] = $zone_info['name'];
        } else {
            $data['name'] = '';
        }

        $data['countries'] = $this->model_localisation_country->getCountries();

        if ($zone_info) {
            $data['country_id'] = $zone_info['country_id'];
        } else {
            $data['country_id'] = '';
        }

        if ($zone_info) {
            $data['code'] = $zone_info['code'];
        } else {
            $data['code'] = '';
        }

        if ($zone_info) {
            $data['sort_order'] = $zone_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($zone_info) {
            $data['status'] = $zone_info['status'];
        } else {
            $data['status'] = 1;
        }

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone');

        // Header
        $header_params = array(
            'title' => lang('Heading.zones'),
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
            'view' => 'Localisation\zone_form',
            'permission' => 'Localisation/Zone',
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function delete()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (!$this->administrator->hasPermission('modify', 'Localisation/Zone')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                if (!empty($this->request->getPost('selected'))) {
                    foreach ($this->request->getPost('selected') as $zone_id) {
                        // Query
                        $query = $this->model_localisation_zone->deleteZone($zone_id);
                    }

                    $json['success']['toast'] = lang('Success.zone_delete');

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone');
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
            if (!$this->administrator->hasPermission('modify', 'Localisation/Zone')) {
                $json['error']['toast'] = lang('Error.modify_permission');
            } else {
                $this->validation->setRule('name', lang('Entry.name'), 'required');

                if ($this->validation->withRequest($this->request)->run()) {
                    if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'save') {
                        // Query
                        $query = $this->model_localisation_zone->editZone($this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                        $json['success']['toast'] = lang('Success.zone_edit');
                    } else {
                        // Query
                        $query = $this->model_localisation_zone->addZone($this->request->getPost());

                        $json['success']['toast'] = lang('Success.zone_add');
                    }

                    $json['redirect'] = $this->url->administratorLink(env('app.adminUrlSegment') . '/localisation/zone');
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
