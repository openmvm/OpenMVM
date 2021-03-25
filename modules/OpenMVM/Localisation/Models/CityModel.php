<?php

namespace Modules\OpenMVM\Localisation\Models;

class CityModel extends \CodeIgniter\Model
{

  protected $table = 'city';
	protected $primaryKey = 'city_id';
  protected $allowedFields = ['city_id', 'name', 'code', 'country_id', 'state_id', 'sort_order', 'status'];

	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = db_connect();
	}

	public function addCity($data = array())
	{
		$builder = $this->db->table('city');

    $query_data = array(
      'name'       => $data['name'],
      'code'       => $data['code'],
      'country_id' => $data['country_id'],
      'state_id'   => $data['state_id'],
      'sort_order' => $data['sort_order'],
      'status'     => $data['status'],
    );

		$builder->insert($query_data);

		return $this->db->insertID();
	}

	public function getCities($data = array())
	{
		$results = array();

		$builder = $this->db->table('city');

		if (!empty($data['filter_state'])) {
			$builder->where('state_id', $data['filter_state']);
		}

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
        'city_id'     => $row->city_id,
		  	'name'        => $row->name,
	      'code'        => $row->code,
	      'country_id'  => $row->country_id,
	      'state_id'    => $row->state_id,
	      'sort_order'  => $row->sort_order,
	      'status'      => $row->status,
		  );
		}

		return $results;
	}

	public function getCity($city_id)
	{
		return $this->asArray()->where(['city_id' => $city_id])->first();
	}

	public function getCityByCode($code)
	{
		return $this->asArray()->where(['code' => $code])->first();
	}

	public function editCity($data = array(), $city_id)
	{
		$builder = $this->db->table('city');

    $query_data = array(
      'name'       => $data['name'],
      'code'       => $data['code'],
      'country_id' => $data['country_id'],
      'state_id'   => $data['state_id'],
      'sort_order' => $data['sort_order'],
      'status'     => $data['status'],
    );

		$builder->where('city_id', $city_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteCity($city_id)
	{
		$builder = $this->db->table('city');
		$builder->where('city_id', $city_id);
		$builder->delete();
	}

	public function getTotalCities($data = array())
	{
		$results = array();

		$builder = $this->db->table('city');
    
		$query = $builder->countAllResults();

		return $query;
	}
}