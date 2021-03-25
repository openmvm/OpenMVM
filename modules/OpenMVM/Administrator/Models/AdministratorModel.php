<?php

namespace Modules\OpenMVM\Administrator\Models;

use Modules\OpenMVM\Administrator\Models\AdministratorGroupModel;

class AdministratorModel extends \CodeIgniter\Model
{

  protected $table = 'administrator';
	protected $primaryKey = 'administrator_id';
  protected $allowedFields = ['administrator_id', 'administrator_group_id', 'username', 'password', 'salt', 'firstname', 'lastname', 'avatar', 'code', 'ip', 'status', 'date_added'];

	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		// Load Database
		$this->db = db_connect();
		// Load Models
		$this->administratorGroupModel = new AdministratorGroupModel();
	}

	public function addAdministrator($data = array())
	{
		$builder = $this->db->table('administrator');

    // Hash password
    $salt = uniqid(mt_rand(), true);
    $hashed_password = hash('sha1', $data['password'] . $salt);

    // Avatar
    if ($data['avatar'] && is_file(ROOTPATH . 'public/assets/files/' . $data['avatar'])) {
    	$avatar = $data['avatar'];
    } else {
    	$avatar = '';
    }

    $query_data = array(
      'administrator_group_id' => $data['administrator_group_id'],
      'username'               => $data['username'],
      'password'               => $hashed_password,
      'salt'                   => $salt,
      'firstname'              => $data['firstname'],
      'lastname'               => $data['lastname'],
      'email'                  => $data['email'],
      'avatar'                 => $avatar,
      'status'                 => $data['status'],
      'date_added'             => date("Y-m-d H:i:s",now()),
    );

		$builder->insert($query_data);

		return $this->db->insertID();
	}

	public function getAdministrators($data = array())
	{
		$results = array();

		$builder = $this->db->table('administrator');

		if (!empty($data['filter_name'])) {
      $builder->like('username', $data['filter_name']);
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
	      'administrator_id'       => $row->administrator_id,
	      'administrator_group_id' => $row->administrator_group_id,
	      'username'               => $row->username,
	      'firstname'              => $row->firstname,
	      'lastname'               => $row->lastname,
	      'email'                  => $row->email,
	      'avatar'                 => $row->avatar,
	      'ip'                     => $row->ip,
	      'status'                 => $row->status,
	      'date_added'             => $row->date_added,
		  );
		}

		return $results;
	}

	public function getAdministrator($administrator_id)
	{
		return $this->asArray()->where(['administrator_id' => $administrator_id])->first();
	}

	public function getAdministratorByUsername($username)
	{
		if ($username) {
			$result = $this->asArray()->where(['username' => $username])->first();

			if (!empty($result)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	public function getAdministratorByEmail($email)
	{
		if ($email) {
			$result = $this->asArray()->where(['email' => $email])->first();

			if (!empty($result)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	public function getAdministratorLogin($data = array())
	{
    $user_info = $this->asArray()->where(['username' => $data['username']])->first();

    if ($user_info)
    {
      $hashed_password = $user_info['password'];
      $salt = $user_info['salt'];

      if (hash('sha1', $data['password'] . $salt) == $hashed_password)
      {
        return $user_info;
      } else {
        return null;
      }
    } else {
      return null;
    }
	}

	public function editAdministrator($data = array(), $administrator_id)
	{
		$builder = $this->db->table('administrator');

    // Avatar
    if ($data['avatar'] && is_file(ROOTPATH . 'public/assets/files/' . $data['avatar'])) {
    	$avatar = $data['avatar'];
    } else {
    	$avatar = '';
    }

    $query_data = array(
      'administrator_group_id' => $data['administrator_group_id'],
      'username'               => $data['username'],
      'firstname'              => $data['firstname'],
      'lastname'               => $data['lastname'],
      'email'                  => $data['email'],
      'avatar'                 => $avatar,
      'status'                 => $data['status'],
      'date_modified'          => date("Y-m-d H:i:s",now()),
    );

		$builder->where('administrator_id', $administrator_id);
		$query = $builder->update($query_data);

		if (!empty($data['password'])) {
	    // Hash password
	    $salt = uniqid(mt_rand(), true);
	    $hashed_password = hash('sha1', $data['password'] . $salt);

	    $query_data_2 = array(
	      'password' => $hashed_password,
	      'salt'     => $salt,
	    );

			$builder->where('administrator_id', $administrator_id);
			$query = $builder->update($query_data_2);

		}

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteAdministrator($administrator_id)
	{
		$builder = $this->db->table('administrator');
		$builder->where('administrator_id', $administrator_id);
		$builder->delete();
	}

	public function editPassword($password, $administrator_id)
	{
		$builder = $this->db->table('administrator');

    // Hash password
    $salt = uniqid(mt_rand(), true);
    $hashed_password = hash('sha1', $password . $salt);

    $query_data = array(
      'password'   => $hashed_password,
      'salt'       => $salt
    );

		$builder->where('administrator_id', $administrator_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function checkAccessPermission($location, $administrator_id)
	{
		$administrator_info = $this->getAdministrator($administrator_id);

    $result = $this->administratorGroupModel->getAdministratorGroup($administrator_info['administrator_group_id']);

    if ($result) {
      $permissions = json_decode($result['permission'], true);

      if (!empty($permissions['access'])) {
        $access_permissions = $permissions['access'];

        if (in_array($location, $access_permissions)) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
	}

	public function checkModifyPermission($location, $administrator_id)
	{
		$administrator_info = $this->getAdministrator($administrator_id);

    $result = $this->administratorGroupModel->getAdministratorGroup($administrator_info['administrator_group_id']);

    if ($result) {
      $permissions = json_decode($result['permission'], true);

      if (!empty($permissions['modify'])) {
        $access_permissions = $permissions['modify'];

        if (in_array($location, $access_permissions)) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
	}

	public function loggedIn($administrator_token)
	{
    if (!$this->session->get('administrator_logged_in' . $this->session->administrator_session_id) || $this->session->get('administrator_token' . $this->session->administrator_session_id) !== $administrator_token)
    {
    	return false;
    } else {
    	return true;
    }
	}

	public function getTotalAdministrators($data = array())
	{
		$results = array();

		$builder = $this->db->table('administrator');
    
		$query = $builder->countAllResults();

		return $query;
	}
}