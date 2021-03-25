<?php

namespace Modules\OpenMVM\Localisation\Models;

class DistrictModel extends \CodeIgniter\Model
{

  protected $table = 'district';
	protected $primaryKey = 'district_id';
  protected $allowedFields = ['district_id', 'name', 'code', 'country_id', 'state_id', 'city_id', 'sort_order', 'status'];

	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = db_connect();
	}

	public function addDistrict($data = array())
	{
		$builder = $this->db->table('district');

    $query_data = array(
      'name'       => $data['name'],
      'code'       => $data['code'],
      'country_id' => $data['country_id'],
      'state_id'   => $data['state_id'],
      'city_id'    => $data['city_id'],
      'sort_order' => $data['sort_order'],
      'status'     => $data['status'],
    );

		$builder->insert($query_data);

		return $this->db->insertID();
	}

	public function getDistricts($data = array())
	{
		$results = array();

		$builder = $this->db->table('district');

		if (!empty($data['filter_city'])) {
			$builder->where('city_id', $data['filter_city']);
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
        'district_id'     => $row->district_id,
		  	'name'        => $row->name,
	      'code'        => $row->code,
	      'country_id'  => $row->country_id,
	      'state_id'    => $row->state_id,
	      'city_id'     => $row->city_id,
	      'sort_order'  => $row->sort_order,
	      'status'      => $row->status,
		  );
		}

		return $results;
	}

	public function getDistrict($district_id)
	{
		return $this->asArray()->where(['district_id' => $district_id])->first();
	}

	public function getDistrictByCode($code)
	{
		return $this->asArray()->where(['code' => $code])->first();
	}

	public function editDistrict($data = array(), $district_id)
	{
		$builder = $this->db->table('district');

    $query_data = array(
      'name'       => $data['name'],
      'code'       => $data['code'],
      'country_id' => $data['country_id'],
      'state_id'   => $data['state_id'],
      'city_id'    => $data['city_id'],
      'sort_order' => $data['sort_order'],
      'status'     => $data['status'],
    );

		$builder->where('district_id', $district_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteDistrict($district_id)
	{
		$builder = $this->db->table('district');
		$builder->where('district_id', $district_id);
		$builder->delete();
	}

	public function getTotalDistricts($data = array())
	{
		$results = array();

		$builder = $this->db->table('district');
    
		$query = $builder->countAllResults();

		return $query;
	}
}