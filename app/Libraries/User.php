<?php

namespace App\Libraries;

class User
{
	private $user_id;
	private $user_group_id;
	private $username;
	private $firstname;
	private $lastname;
	private $email;
	private $avatar;
	private $token;
	private $permission = array();
	private $sessionId;
	private $storeId;

	public function __construct()
	{
		// Load Libraries
		$this->session = session();
		$this->auth = new \App\Libraries\Auth;
		// Load Database
		$this->db = db_connect();

		// Get User Info
		if (!empty($this->session->get('user_id_' . $this->session->user_session_id))) {
			$builder = $this->db->table('user');

			$builder->where('user_id', $this->session->get('user_id_' . $this->session->user_session_id));

			$query = $builder->get();

			$row = $query->getRowArray();

			if ($row) {
				$this->user_id = $row['user_id'];
				$this->user_group_id = $row['user_group_id'];
				$this->username = $row['username'];
				$this->firstname = $row['firstname'];
				$this->lastname = $row['lastname'];
				$this->email = $row['email'];
				$this->avatar = $row['avatar'];
				$this->token = $this->session->get('user_token_' . $this->session->user_session_id);

				// Get User Group Permissions
				$builder = $this->db->table('user_group');

				$builder->where('user_group_id', $row['user_group_id']);

				$query = $builder->get();

				$row = $query->getRowArray();

				$permissions = json_decode($row['permission'], true);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}

				// Get Sesion ID
				$this->sessionId = $this->session->user_session_id;

				// Get User Store ID if any
				$builder = $this->db->table('store');

				$builder->where('user_id', $this->user_id);

				$query = $builder->get();

				$row = $query->getRowArray();

				if ($row) {
					$this->storeId = $row['store_id'];
				} else {
					$this->storeId = false;
				}

			} else {
				$this->logout();
			}
		}

	}

  public function login($email, $password, $override = false)
  {
		$builder = $this->db->table('user');

		$builder->where('email', $email);

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
		      'user_session_id' => $session_id,
		      'user_id_' . $session_id => $row['user_id'],
		      'user_token_' . $session_id => $this->auth->token(),
		      'user_logged_in_' . $session_id => TRUE,
		    ];

		    $this->session->set($newdata);

        // Session Expiration
				$this->session->markAsTempdata([
          'user_session_id' => 3600,
	        'user_id_' . $session_id  => 3600,
	        'user_token_' . $session_id => 3600,
          'user_logged_in_' . $session_id  => 3600,
				]);

				$this->user_id = $row['user_id'];
				$this->user_group_id = $row['user_group_id'];
				$this->username = $row['username'];
				$this->firstname = $row['firstname'];
				$this->lastname = $row['lastname'];
				$this->email = $row['email'];
				$this->avatar = $row['avatar'];
				$this->token = $this->session->get('user_token_' . $this->session->user_session_id);

				// Get User Group Permissions
				$builder = $this->db->table('user_group');

				$builder->where('user_group_id', $row['user_group_id']);

				$query = $builder->get();

				$row = $query->getRowArray();

				$permissions = json_decode($row['permission'], true);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}

				// Get Sesion ID
				$this->sessionId = $this->session->user_session_id;

				// Get User Store ID if any
				$builder = $this->db->table('store');

				$builder->where('user_id', $this->user_id);

				$query = $builder->get();

				$row = $query->getRowArray();

				if ($row) {
					$this->storeId = $row['store_id'];
				} else {
					$this->storeId = false;
				}
				
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

		$this->user_id = '';
		$this->user_group_id = '';
		$this->username = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->avatar = '';
		$this->token = '';
		$this->sessionId = '';
		$this->storeId = '';
  }

	public function removeSessions() {
		// Remove user sessions
		$user_sessions = [
		  'user_id_' . $this->sessionId,
		  'user_token_' . $this->sessionId,
		  'user_logged_in_' . $this->sessionId,
		  'user_session_id',
		];

		$this->session->remove($user_sessions);
	}

	public function hasPermission() {
		if ($this->isLogged()) {
			return true;
		} else {
			return false;
		}
	}

	public function sessionId() {
		return $this->sessionId;
	}

	public function isLogged() {
		return $this->user_id;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserGroupId() {
		return $this->user_group_id;
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
		return $this->user_group_id;
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

	public function isMerchant() {
		if ($this->storeId === false) {
			return false;
		} else {
			return true;
		}
	}

	public function getStoreId() {
		return $this->storeId;
	}
}