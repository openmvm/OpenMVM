<?php

namespace App\Libraries;

class Administrator
{
	private $administrator_id;
	private $administrator_group_id;
	private $username;
	private $firstname;
	private $lastname;
	private $email;
	private $avatar;
	private $token;
	private $permission = array();
	private $sessionId;

	public function __construct()
	{
		// Load Libraries
		$this->session = session();
		$this->auth = new \App\Libraries\Auth;
		// Load Database
		$this->db = db_connect();

		// Get Administrator Info
		if (!empty($this->session->get('administrator_id_' . $this->session->administrator_session_id))) {
			$builder = $this->db->table('administrator');

			$builder->where('administrator_id', $this->session->get('administrator_id_' . $this->session->administrator_session_id));

			$query = $builder->get();

			$row = $query->getRowArray();

			if ($row) {
				$this->administrator_id = $row['administrator_id'];
				$this->administrator_group_id = $row['administrator_group_id'];
				$this->username = $row['username'];
				$this->firstname = $row['firstname'];
				$this->lastname = $row['lastname'];
				$this->email = $row['email'];
				$this->avatar = $row['avatar'];
				$this->token = $this->session->get('administrator_token_' . $this->session->administrator_session_id);

				// Get Administrator Group Permissions
				$builder = $this->db->table('administrator_group');

				$builder->where('administrator_group_id', $row['administrator_group_id']);

				$query = $builder->get();

				$row = $query->getRowArray();

				$permissions = json_decode($row['permission'], true);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}

				// Get Sesion ID
				$this->sessionId = $this->session->administrator_session_id;

			} else {
				$this->logout();
			}
		}

	}

  public function login($username, $password, $override = false)
  {
		$builder = $this->db->table('administrator');

		$builder->where('username', $username);

		$query = $builder->get();

		$row = $query->getRowArray();

		if ($row) {
      $salt = $row['salt'];
      $hashed_password = $row['password'];

      if (hash('sha1', $password . $salt) == $hashed_password)
      {
		    // Session Data
		    $session_id = $this->auth->sessionId();

		    $newdata = [
		      'administrator_session_id' => $session_id,
		      'administrator_id_' . $session_id => $row['administrator_id'],
		      'administrator_token_' . $session_id => $this->auth->token(),
		      'administrator_logged_in_' . $session_id => TRUE,
		    ];

		    $this->session->set($newdata);

        // Session Expiration
				$this->session->markAsTempdata([
          'administrator_session_id' => 3600,
	        'administrator_id_' . $session_id  => 3600,
	        'administrator_token_' . $session_id => 3600,
          'administrator_logged_in_' . $session_id  => 3600,
				]);

				$this->administrator_id = $row['administrator_id'];
				$this->administrator_group_id = $row['administrator_group_id'];
				$this->username = $row['username'];
				$this->firstname = $row['firstname'];
				$this->lastname = $row['lastname'];
				$this->email = $row['email'];
				$this->avatar = $row['avatar'];
				$this->token = $this->session->get('administrator_token_' . $this->session->administrator_session_id);

				// Get Administrator Group Permissions
				$builder = $this->db->table('administrator_group');

				$builder->where('administrator_group_id', $row['administrator_group_id']);

				$query = $builder->get();

				$row = $query->getRowArray();

				$permissions = json_decode($row['permission'], true);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}

				// Get Sesion ID
				$this->sessionId = $this->session->administrator_session_id;
				
				return true;
      } else {
        return false;
      }
		} else {
			return false;
		}
  }

  public function logout() {
		$this->removeSessions();

		$this->administrator_id = '';
		$this->administrator_group_id = '';
		$this->username = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->avatar = '';
		$this->token = '';
  }

	public function removeSessions() {
		$administrator_sessions = [
		  'administrator_id_' . $this->sessionId,
		  'administrator_token_' . $this->sessionId,
		  'administrator_logged_in_' . $this->sessionId,
		  'administrator_session_id',
		];

		$this->session->remove($administrator_sessions);
	}

	public function hasPermission($key, $value) {
		if (!empty($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}

	public function isLogged() {
		return $this->administrator_id;
	}

	public function getId() {
		return $this->administrator_id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getFirstName() {
		return $this->firstname;
	}

	public function getLastName() {
		return $this->lastname;
	}

	public function getGroupId() {
		return $this->administrator_group_id;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getAvatar() {
		return $this->avatar;
	}

	public function getToken() {
		return $this->token;
	}
}