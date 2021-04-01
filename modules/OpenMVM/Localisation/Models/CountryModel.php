<?php

namespace Modules\OpenMVM\Localisation\Models;

class CountryModel extends \CodeIgniter\Model
{

  protected $table = 'country';
	protected $primaryKey = 'country_id';
  protected $allowedFields = ['country_id', 'name'];

	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = db_connect();
	}

	public function addCountry($data = array())
	{
		$builder = $this->db->table('country');

    $query_data = array(
      'name'                => $data['name'],
      'iso_code_2'          => $data['iso_code_2'],
      'iso_code_3'          => $data['iso_code_3'],
      'iso_code_numeric'    => $data['iso_code_numeric'],
      'code_dial_in'        => $data['code_dial_in'],
      'state_input_type'    => $data['state_input_type'],
      'city_input_type'     => $data['city_input_type'],
      'district_input_type' => $data['district_input_type'],
      'address_format'      => $data['address_format'],
      'sort_order'          => $data['sort_order'],
      'status'              => $data['status'],
    );

		$builder->insert($query_data);

		return $this->db->insertID();
	}

	public function editCountry($data = array(), $country_id)
	{
		$builder = $this->db->table('country');

    $query_data = array(
      'name'                => $data['name'],
      'iso_code_2'          => $data['iso_code_2'],
      'iso_code_3'          => $data['iso_code_3'],
      'iso_code_numeric'    => $data['iso_code_numeric'],
      'code_dial_in'        => $data['code_dial_in'],
      'state_input_type'    => $data['state_input_type'],
      'city_input_type'     => $data['city_input_type'],
      'district_input_type' => $data['district_input_type'],
      'address_format'      => $data['address_format'],
      'sort_order'          => $data['sort_order'],
      'status'              => $data['status'],
    );

		$builder->where('country_id', $country_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteCountry($country_id)
	{
		$builder = $this->db->table('country');
		$builder->where('country_id', $country_id);
		$builder->delete();
	}

	public function getCountries($data = array())
	{
		$results = array();

		$builder = $this->db->table('country');

		if (!empty($data['sort']) && !empty($data['order'])) {
			$builder->orderBy($data['sort'], $data['order']);
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
		  $results[] = array(
        'country_id'          => $row->country_id,
		  	'name'                => $row->name,
	      'iso_code_2'          => $row->iso_code_2,
	      'iso_code_3'          => $row->iso_code_3,
	      'iso_code_numeric'    => $row->iso_code_numeric,
	      'code_dial_in'        => $row->code_dial_in,
	      'state_input_type'    => $row->state_input_type,
	      'city_input_type'     => $row->city_input_type,
	      'district_input_type' => $row->district_input_type,
	      'address_format'      => $row->address_format,
	      'sort_order'          => $row->sort_order,
	      'status'              => $row->status,
		  );
		}

		return $results;
	}

	public function getCountry($country_id)
	{
		return $this->asArray()->where(['country_id' => $country_id])->first();
	}

	public function getCountryByCode($code)
	{
		return $this->asArray()->where(['code' => $code])->first();
	}

	public function getTotalCountries($data = array())
	{
		$results = array();

		$builder = $this->db->table('country');
    
		$query = $builder->countAllResults();

		return $query;
	}
}