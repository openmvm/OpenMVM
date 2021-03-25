<?php

namespace Modules\OpenMVM\User\Models;

class UserAddressModel extends \CodeIgniter\Model
{

  protected $table = 'user_address';
	protected $primaryKey = 'user_address_id';
  protected $allowedFields = ['user_address_id', 'user_id', 'firstname', 'lastname', 'address_1', 'address_2', 'country_id', 'state_id', 'city_id', 'district_id', 'postal_code', 'telephone'];

	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		$this->phpmailer_lib = new \App\Libraries\PHPMailer_lib;
		$this->auth = new \App\Libraries\Auth;
		// Load Database
		$this->db = db_connect();
		// Load Models
		$this->userModel = new \Modules\OpenMVM\User\Models\UserModel;
		$this->countryModel = new \Modules\OpenMVM\Localisation\Models\CountryModel;
		$this->stateModel = new \Modules\OpenMVM\Localisation\Models\StateModel;
		$this->cityModel = new \Modules\OpenMVM\Localisation\Models\CityModel;
		$this->districtModel = new \Modules\OpenMVM\Localisation\Models\DistrictModel;
	}

	public function addUserAddress($data = array(), $user_id)
	{
		// Insert Data into the Database
		$builder = $this->db->table('user_address');

		$builder->set('user_id', $user_id);

		if ($data['firstname'] !== null) {
			$builder->set('firstname', $data['firstname']);
		}

		if ($data['lastname'] !== null) {
			$builder->set('lastname', $data['lastname']);
		}

		if ($data['address_1'] !== null) {
			$builder->set('address_1', $data['address_1']);
		}

		if ($data['address_2'] !== null) {
			$builder->set('address_2', $data['address_2']);
		}

		if ($data['address_format'] !== null) {
			$builder->set('address_format', $data['address_format']);
		}

		if ($data['country_id'] !== null) {
			$builder->set('country_id', $data['country_id']);
		}

		if ($data['state_id'] !== null) {
			$builder->set('state_id', $data['state_id']);
		}

		if ($data['city_id'] !== null) {
			$builder->set('city_id', $data['city_id']);
		}

		if ($data['district_id'] !== null) {
			$builder->set('district_id', $data['district_id']);
		}

		if ($data['postal_code'] !== null) {
			$builder->set('postal_code', $data['postal_code']);
		}

		if ($data['telephone'] !== null) {
			$builder->set('telephone', $data['telephone']);
		}

		$builder->insert($query_data);

		$user_address_id = $this->db->insertID();

		return $user_address_id;
	}

	public function editUserAddress($data = array(), $user_id)
	{
		// User Data
		$builder = $this->db->table('user_address');

		if ($data['firstname'] !== null) {
			$builder->set('firstname', $data['firstname']);
		}

		if ($data['lastname'] !== null) {
			$builder->set('lastname', $data['lastname']);
		}

		if ($data['address_1'] !== null) {
			$builder->set('address_1', $data['address_1']);
		}

		if ($data['address_2'] !== null) {
			$builder->set('address_2', $data['address_2']);
		}

		if ($data['address_format'] !== null) {
			$builder->set('address_format', $data['address_format']);
		}

		if ($data['country_id'] !== null) {
			$builder->set('country_id', $data['country_id']);
		}

		if ($data['state_id'] !== null) {
			$builder->set('state_id', $data['state_id']);
		}

		if ($data['city_id'] !== null) {
			$builder->set('city_id', $data['city_id']);
		}

		if ($data['district_id'] !== null) {
			$builder->set('district_id', $data['district_id']);
		}

		if ($data['postal_code'] !== null) {
			$builder->set('postal_code', $data['postal_code']);
		}

		if ($data['telephone'] !== null) {
			$builder->set('telephone', $data['telephone']);
		}

		$builder->where('user_id', $user_id);

		$query = $builder->update();

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteUserAddress($user_address_id, $user_id)
	{
		$builder = $this->db->table('user_address');
		$builder->where('user_address_id', $user_address_id);
		$builder->where('user_id', $user_id);
		$builder->delete();
	}

	public function getUserAddresses($data = array(), $user_id = null)
	{
		$results = array();

		$builder = $this->db->table('user_address');

		if ($user_id !== null) {
		  $builder->where('user_id', $user_id);
		}

    if (!empty($data['start']) || !empty($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $builder->limit($data['limit'], $data['start']);
    }

		$query   = $builder->get();

		foreach ($query->getResult() as $row)
		{
			$builder_country = $this->db->table('country');
			$builder_country->where('country_id', $row->country_id);
			$query_country   = $builder_country->get();

			if ($row_country = $query_country->getRow()) {
				$country = $row_country->name;
				$iso_code_2 = $row_country->iso_code_2;
				$iso_code_3 = $row_country->iso_code_3;
				$address_format = $row_country->address_format;
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$builder_state = $this->db->table('state');
			$builder_state->where('state_id', $row->state_id);
			$query_state   = $builder_state->get();

			if ($row_state = $query_state->getRow()) {
				$state = $row_state->name;
				$state_code = $row_state->code;
			} else {
				$state = '';
				$state_code = '';
			}

			$builder_city = $this->db->table('city');
			$builder_city->where('city_id', $row->city_id);
			$query_city   = $builder_city->get();

			if ($row_city = $query_city->getRow()) {
				$city = $row_city->name;
				$city_code = $row_city->code;
			} else {
				$city = '';
				$city_code = '';
			}

			$builder_district = $this->db->table('district');
			$builder_district->where('district_id', $row->district_id);
			$query_district   = $builder_district->get();

			if ($row_district = $query_district->getRow()) {
				$district = $row_district->name;
				$district_code = $row_district->code;
			} else {
				$district = '';
				$district_code = '';
			}

		  $results[] = array(
	      'user_address_id' => $row->user_address_id,
	      'user_id'         => $row->user_id,
	      'firstname'       => $row->firstname,
	      'lastname'        => $row->lastname,
	      'address_1'       => $row->address_1,
	      'address_2'       => $row->address_2,
	      'country_id'      => $row->country_id,
				'country'         => $country,
				'iso_code_2'      => $iso_code_2,
				'iso_code_3'      => $iso_code_3,
				'address_format'  => $address_format,
	      'state_id'        => $row->state_id,
	      'state'           => $state,
	      'state_code'      => $state_code,
	      'city_id'         => $row->city_id,
	      'city'            => $city,
	      'city_code'       => $city_code,
      	'district_id'     => $row->district_id,
	      'district'        => $district,
	      'district_code'   => $district_code,
	      'postal_code'     => $row->postal_code,
      	'telephone'       => $row->telephone,
		  );
		}

		return $results;
	}

	public function getUserAddress($user_address_id, $user_id)
	{
		$builder = $this->db->table('user_address');

		$builder->where('user_address_id', $user_address_id);
		if ($user_id !== null) {
		  $builder->where('user_id', $user_id);
		}

		$query   = $builder->get();

		$row = $query->getRow();

		if ($row) {
			$builder_country = $this->db->table('country');
			$builder_country->where('country_id', $row->country_id);
			$query_country   = $builder_country->get();

			if ($row_country = $query_country->getRow()) {
				$country = $row_country->name;
				$iso_code_2 = $row_country->iso_code_2;
				$iso_code_3 = $row_country->iso_code_3;
				$address_format = $row_country->address_format;
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$builder_state = $this->db->table('state');
			$builder_state->where('state_id', $row->state_id);
			$query_state   = $builder_state->get();

			if ($row_state = $query_state->getRow()) {
				$state = $row_state->name;
				$state_code = $row_state->code;
			} else {
				$state = '';
				$state_code = '';
			}

			$builder_city = $this->db->table('city');
			$builder_city->where('city_id', $row->city_id);
			$query_city   = $builder_city->get();

			if ($row_city = $query_city->getRow()) {
				$city = $row_city->name;
				$city_code = $row_city->code;
			} else {
				$city = '';
				$city_code = '';
			}

			$builder_district = $this->db->table('district');
			$builder_district->where('district_id', $row->district_id);
			$query_district   = $builder_district->get();

			if ($row_district = $query_district->getRow()) {
				$district = $row_district->name;
				$district_code = $row_district->code;
			} else {
				$district = '';
				$district_code = '';
			}

		  $result = array(
	      'user_address_id' => $row->user_address_id,
	      'user_id'         => $row->user_id,
	      'firstname'       => $row->firstname,
	      'lastname'        => $row->lastname,
	      'address_1'       => $row->address_1,
	      'address_2'       => $row->address_2,
	      'country_id'      => $row->country_id,
				'country'         => $country,
				'iso_code_2'      => $iso_code_2,
				'iso_code_3'      => $iso_code_3,
				'address_format'  => $address_format,
	      'state_id'        => $row->state_id,
	      'state'           => $state,
	      'state_code'      => $state_code,
	      'city_id'         => $row->city_id,
	      'city'            => $city,
	      'city_code'       => $city_code,
      	'district_id'     => $row->district_id,
	      'district'        => $district,
	      'district_code'   => $district_code,
	      'postal_code'     => $row->postal_code,
      	'telephone'       => $row->telephone,
		  );
		}

		return $result;
	}

	public function getTotalUserAddresses($user_id)
	{
		$results = array();

		$builder = $this->db->table('user_address');
		$builder->where('user_id', $user_id);
    
		$query = $builder->countAllResults();

		return $query;
	}
}