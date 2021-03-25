<?php

namespace Modules\OpenMVM\Administrator\Models;

class AdministratorGroupModel extends \CodeIgniter\Model
{

  protected $table = 'administrator_group';
	protected $primaryKey = 'administrator_group_id';
  protected $allowedFields = ['administrator_group_id', 'name', 'permission'];

	public function __construct()
	{
		// Load Database
		$this->db = db_connect();
	}
	
	public function addAdministratorGroup($data = array())
	{
		$builder = $this->db->table('administrator_group');

    if (!empty($data['permission'])) {
      $permission = json_encode($data['permission']);
    } else {
      $permission = '';
    }

    $query_data = array(
      'name'        => $data['name'],
      'permission'  => $permission,
    );

		$builder->insert($query_data);

		return $this->db->insertID();
	}

	public function getAdministratorGroups($data = array())
	{
		$results = array();

		$builder = $this->db->table('administrator_group');

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

		$query = $builder->get();

		foreach ($query->getResult() as $row)
		{
		  $results[] = array(
        'administrator_group_id' => $row->administrator_group_id,
		  	'name'                   => $row->name,
		  	'permission'             => json_decode($row->permission, true),
		  );
		}

		return $results;
	}

	public function getAdministratorGroup($administrator_group_id)
	{
		return $this->asArray()->where(['administrator_group_id' => $administrator_group_id])->first();
	}

	public function editAdministratorGroup($data = array(), $administrator_group_id)
	{
		$builder = $this->db->table('administrator_group');

    if (!empty($data['permission'])) {
      $permission = json_encode($data['permission']);
    } else {
      $permission = '';
    }

    $query_data = array(
      'name'        => $data['name'],
      'permission'  => $permission,
    );

		$builder->where('administrator_group_id', $administrator_group_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteAdministratorGroup($administrator_group_id)
	{
		$builder = $this->db->table('administrator_group');
		$builder->where('administrator_group_id', $administrator_group_id);
		$builder->delete();
	}

	public function getTotalAdministratorGroups($data = array())
	{
		$results = array();

		$builder = $this->db->table('administrator_group');
    
		$query = $builder->countAllResults();

		return $query;
	}
}