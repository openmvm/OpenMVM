<?php

namespace Modules\OpenMVM\Localisation\Controllers\FrontEnd;

use Modules\OpenMVM\Localisation\Models\CountryModel;
use Modules\OpenMVM\Localisation\Models\StateModel;

class Localisation extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->countryModel = new \Modules\OpenMVM\Localisation\Models\CountryModel();
		$this->stateModel = new \Modules\OpenMVM\Localisation\Models\StateModel();
		$this->cityModel = new \Modules\OpenMVM\Localisation\Models\CityModel();
		$this->districtModel = new \Modules\OpenMVM\Localisation\Models\DistrictModel();
	}

	public function getCountries()
	{
    $json = array();

    // Get Countries
    $filter_data = array();

    $json['countries'] = $this->countryModel->getCountries($filter_data);

    return $this->response->setJSON($json);
	}

	public function getCountry()
	{
    $json = array();

    // Get Country Info
    if ($this->request->getPost('country_id') !== null) {
	    $country_info = $this->countryModel->getCountry($this->request->getPost('country_id'));

	    if ($country_info) {
	    	$json['name'] = $country_info['name'];
	    	$json['iso_code_2'] = $country_info['iso_code_2'];
	    	$json['iso_code_3'] = $country_info['iso_code_3'];
	    	$json['iso_code_numeric'] = $country_info['iso_code_numeric'];
	    	$json['code_dial_in'] = $country_info['code_dial_in'];
	    	$json['state_input_type'] = $country_info['state_input_type'];
	    	$json['city_input_type'] = $country_info['city_input_type'];
	    	$json['district_input_type'] = $country_info['district_input_type'];
	    	$json['district_required'] = $country_info['district_required'];

	    	// Get States by Country ID
	    	$filter_data = array(
	    		'filter_country' => $country_info['country_id'],
	    	);

	    	$json['states'] = $this->stateModel->getStates($filter_data);
	    }
    }

    return $this->response->setJSON($json);
	}

	public function getStates()
	{
    $json = array();

    // Get Countries
    $filter_data = array();

    $json['states'] = $this->stateModel->getStates($filter_data);

    return $this->response->setJSON($json);
	}

	public function getState()
	{
    $json = array();

    // Get State Info
    if ($this->request->getPost('state_id') !== null) {
	    $state_info = $this->stateModel->getState($this->request->getPost('state_id'));

	    if ($state_info) {
	    	$json['name'] = $state_info['name'];
	    	$json['code'] = $state_info['code'];
	    	$json['country_id'] = $state_info['country_id'];

	    	// Get Cities by State ID
	    	$filter_data = array(
	    		'filter_state' => $state_info['state_id'],
	    	);

	    	$json['cities'] = $this->cityModel->getCities($filter_data);
	    }
    }

    return $this->response->setJSON($json);
	}

	public function getCities()
	{
    $json = array();

    // Get Countries
    $filter_data = array();

    $json['cities'] = $this->cityModel->getCities($filter_data);

    return $this->response->setJSON($json);
	}

	public function getCity()
	{
    $json = array();

    // Get State Info
    if ($this->request->getPost('city_id') !== null) {
	    $city_info = $this->cityModel->getCity($this->request->getPost('city_id'));

	    if ($city_info) {
	    	$json['name'] = $city_info['name'];
	    	$json['code'] = $city_info['code'];
	    	$json['country_id'] = $city_info['country_id'];
	    	$json['state_id'] = $city_info['state_id'];

	    	// Get Towns by City ID
	    	$filter_data = array(
	    		'filter_city' => $city_info['city_id'],
	    	);

	    	$json['districts'] = $this->districtModel->getDistricts($filter_data);
	    }
    }

    return $this->response->setJSON($json);
	}

	public function getDistricts()
	{
    $json = array();

    // Get Countries
    $filter_data = array();

    $json['districts'] = $this->districtModel->getDistricts($filter_data);

    return $this->response->setJSON($json);
	}

	public function getDistrict()
	{
    $json = array();

    // Get State Info
    if ($this->request->getPost('district_id') !== null) {
	    $district_info = $this->districtModel->getDistrict($this->request->getPost('district_id'));

	    if ($district_info) {
	    	$json['name'] = $district_info['name'];
	    	$json['code'] = $district_info['code'];
	    	$json['country_id'] = $district_info['country_id'];
	    	$json['state_id'] = $district_info['state_id'];
	    	$json['city_id'] = $district_info['city_id'];
	    }
    }

    return $this->response->setJSON($json);
	}
}
