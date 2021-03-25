<?php

namespace Modules\OpenMVM\Localisation\Models;

class StateModel extends \CodeIgniter\Model
{

  protected $table = 'state';
	protected $primaryKey = 'state_id';
  protected $allowedFields = ['state_id', 'name'];

	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = db_connect();
	}

	public function addState($data = array())
	{
		$builder = $this->db->table('state');

    $query_data = array(
      'name'       => $data['name'],
      'code'       => $data['code'],
      'country_id' => $data['country_id'],
      'sort_order' => $data['sort_order'],
      'status'     => $data['status'],
    );

		$builder->insert($query_data);

		return $this->db->insertID();
	}

	public function getStates($data = array())
	{
		$results = array();

		$builder = $this->db->table('state');

		if (!empty($data['filter_country'])) {
			$builder->where('country_id', $data['filter_country']);
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
        'state_id'    => $row->state_id,
		  	'name'        => $row->name,
	      'code'        => $row->code,
	      'country_id'  => $row->country_id,
	      'sort_order'  => $row->sort_order,
	      'status'      => $row->status,
		  );
		}

		return $results;
	}

	public function getState($state_id)
	{
		return $this->asArray()->where(['state_id' => $state_id])->first();
	}

	public function getStateByCode($code)
	{
		return $this->asArray()->where(['code' => $code])->first();
	}

	public function editState($data = array(), $state_id)
	{
		$builder = $this->db->table('state');

    $query_data = array(
      'name'       => $data['name'],
      'code'       => $data['code'],
      'country_id' => $data['country_id'],
      'sort_order' => $data['sort_order'],
      'status'     => $data['status'],
    );

		$builder->where('state_id', $state_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteState($state_id)
	{
		$builder = $this->db->table('state');
		$builder->where('state_id', $state_id);
		$builder->delete();
	}

	public function getTotalStates($data = array())
	{
		$results = array();

		$builder = $this->db->table('state');
    
		$query = $builder->countAllResults();

		return $query;
	}
}