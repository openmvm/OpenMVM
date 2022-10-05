<?php

namespace Main\Marketplace\Controllers\Localisation;

class Country extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->model_localisation_country = new \Main\Marketplace\Models\Localisation\Country_Model();
        $this->model_localisation_zone = new \Main\Marketplace\Models\Localisation\Zone_Model();
    }

    public function index()
    {
        return false;
    }

    public function get_country()
    {
        $json = [];

        if ($this->request->getGet('country_id')) {
            $country_id = $this->request->getGet('country_id');
        } else {
            $country_id = 0;
        }

        $country_info = $this->model_localisation_country->getCountry($country_id);

        if (!empty($country_info)) {
            $json = [
                'country_id' => $country_info['country_id'],
                'name' => $country_info['name'],
                'iso_code_2' => $country_info['iso_code_2'],
                'iso_code_3' => $country_info['iso_code_3'],
                'dialing_code' => $country_info['dialing_code'],
                'postal_code_required' => $country_info['postal_code_required'],
                'address_format' => $country_info['address_format'],
                'zones' => $this->model_localisation_zone->getZonesbyCountryId($country_info['country_id']),
            ];
        }

        return $this->response->setJSON($json);
    }
}
