<?php

namespace Modules\OpenMVM\User\Models;

class UserGroupModel extends \CodeIgniter\Model
{

  protected $table = 'user_group';
	protected $primaryKey = 'user_group_id';
  protected $allowedFields = ['user_group_id', 'name', 'permission'];

	public function __construct()
	{
		// Load Database
		$this->db = db_connect();
	}
	
	public function addUserGroup($data = array())
	{
		$builder = $this->db->table('user_group');

    $query_data = array(
      'name'               => $data['name'],
      'email_verification' => $data['email_verification'],
    );

		$builder->insert($query_data);

		return $this->db->insertID();
	}

	public function getUserGroups($data = array())
	{
		$results = array();

		$builder = $this->db->table('user_group');

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
        'user_group_id'      => $row->user_group_id,
		  	'name'               => $row->name,
      	'email_verification' => $data['email_verification'],
		  );
		}

		return $results;
	}

	public function getUserGroup($user_group_id)
	{
		return $this->asArray()->where(['user_group_id' => $user_group_id])->first();
	}

	public function editUserGroup($data = array(), $user_group_id)
	{
		$builder = $this->db->table('user_group');

    $query_data = array(
      'name'               => $data['name'],
      'email_verification' => $data['email_verification'],
    );

		$builder->where('user_group_id', $user_group_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteUserGroup($user_group_id)
	{
		$builder = $this->db->table('user_group');
		$builder->where('user_group_id', $user_group_id);
		$builder->delete();
	}

	public function getTotalUserGroups($data = array())
	{
		$results = array();

		$builder = $this->db->table('user_group');
    
		$query = $builder->countAllResults();

		return $query;
	}
}