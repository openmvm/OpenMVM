<?php

namespace App\Controllers\Marketplace\Seller\Localisation;

class Geo_Zone extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_seller_geo_zone = new \App\Models\Marketplace\Seller\Geo_Zone_Model();
        $this->model_localisation_country = new \App\Models\Marketplace\Localisation\Country_Model();
    }

    public function index()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['action'] = $this->url->customerLink('marketplace/seller/localisation/geo_zone', '', true);

        if ($this->request->getMethod() == 'post' && !empty($this->request->getPost('selected'))) {
            foreach ($this->request->getPost('selected') as $geo_zone_id) {
                // Query
                $query = $this->model_seller_geo_zone->deleteGeoZone($this->customer->getSellerId(), $geo_zone_id);

                $this->session->set('success', lang('Success.geo_zone_delete'));

                return redirect()->to($this->url->customerLink('marketplace/seller/localisation/geo_zone', '', true));
            }
        }

        return $this->get_list($data);
    }

    public function add()
    {
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['sub_title'] = lang('Heading.add');

        $data['action'] = $this->url->customerLink('marketplace/seller/localisation/geo_zone/add', '', true);

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_seller_geo_zone->addGeoZone($this->customer->getSellerId(), $this->request->getPost());

                $this->session->set('success', lang('Success.geo_zone_add'));

                return redirect()->to($this->url->customerLink('marketplace/seller/localisation/geo_zone', '', true));
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
        if (!$this->customer->isLoggedIn() || !$this->customer->verifyToken($this->request->getGet('customer_token'))) {
            return redirect()->to('marketplace/account/login');
        }

        $data['sub_title'] = lang('Heading.edit');

        $data['action'] = $this->url->customerLink('marketplace/seller/localisation/geo_zone/edit/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRule('name', lang('Entry.name'), 'required');

            if ($this->validation->withRequest($this->request)->run()) {
                // Query
                $query = $this->model_seller_geo_zone->editGeoZone($this->customer->getSellerId(), $this->uri->getSegment($this->uri->getTotalSegments()), $this->request->getPost());

                $this->session->set('success', lang('Success.geo_zone_edit'));

                return redirect()->to($this->url->customerLink('marketplace/seller/localisation/geo_zone', '', true));
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
        $breadcrumbs[] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.geo_zones'),
            'href' => $this->url->customerLink('marketplace/seller/localisation/geo_zone', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.geo_zones');

        // Get geo zones
        $data['seller_geo_zones'] = [];

        $seller_geo_zones = $this->model_seller_geo_zone->getGeoZones($this->customer->getSellerId());

        foreach ($seller_geo_zones as $seller_geo_zone) {
            $data['seller_geo_zones'][] = [
                'seller_geo_zone_id' => $seller_geo_zone['seller_geo_zone_id'],
                'name' => $seller_geo_zone['name'],
                'href' => $this->url->customerLink('marketplace/seller/localisation/geo_zone/edit/' . $seller_geo_zone['seller_geo_zone_id'], '', true),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->customerLink('marketplace/seller/localisation/geo_zone/add', '', true);
        $data['cancel'] = $this->url->customerLink('marketplace/seller/dashboard', '', true);
	
        // Header
        $header_params = array(
            'title' => lang('Heading.geo_zones'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Seller\Localisation\geo_zone_list', $data);
    }

    public function get_form($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.dashboard'),
            'href' => $this->url->customerLink('marketplace/seller/dashboard', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.geo_zones'),
            'href' => $this->url->customerLink('marketplace/seller/localisation/geo_zone', '', true),
            'active' => false,
        );

        if ($this->uri->getSegment($this->uri->getTotalSegments() - 1) == 'edit') {
            $breadcrumbs[] = array(
                'text' => lang('Text.edit'),
                'href' => '',
                'active' => true,
            );
            
            $seller_geo_zone_info = $this->model_seller_geo_zone->getGeoZone($this->customer->getSellerId(), $this->uri->getSegment($this->uri->getTotalSegments()));
        } else {
            $breadcrumbs[] = array(
                'text' => lang('Text.add'),
                'href' => '',
                'active' => true,
            );

            $seller_geo_zone_info = [];
        }

        $data['heading_title'] = lang('Heading.geo_zones');

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif ($seller_geo_zone_info) {
            $data['name'] = $seller_geo_zone_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('description')) {
            $data['description'] = $this->request->getPost('description');
        } elseif ($seller_geo_zone_info) {
            $data['description'] = $seller_geo_zone_info['description'];
        } else {
            $data['description'] = '';
        }

        if ($this->request->getPost('seller_zone_to_geo_zone')) {
            $data['seller_zone_to_geo_zones'] = $this->request->getPost('seller_zone_to_geo_zone');
        } elseif ($seller_geo_zone_info) {
            $data['seller_zone_to_geo_zones'] = $this->model_seller_geo_zone->getZoneToGeoZones($this->customer->getSellerId(), $seller_geo_zone_info['seller_geo_zone_id']);
        } else {
            $data['seller_zone_to_geo_zones'] = [];
        }

        $data['countries'] = $this->model_localisation_country->getCountries();
        $data['country_request'] = $this->url->customerLink('marketplace/localisation/country/get_country', '', true);

        $data['validation'] = $this->validation;
        
        $data['cancel'] = $this->url->customerLink('marketplace/seller/localisation/geo_zone', '', true);

        // Header
        $header_params = array(
            'title' => lang('Heading.geo_zones'),
            'breadcrumbs' => $breadcrumbs,
        );
        $data['header'] = $this->marketplace_header->index($header_params);
        // Footer
        $footer_params = array();
        $data['footer'] = $this->marketplace_footer->index($footer_params);

        return $this->template->render('ThemeMarketplace', 'com_openmvm', 'Basic', 'Seller\Localisation\geo_zone_form', $data);
    }
}
