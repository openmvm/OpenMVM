<?php

/**
 * This file is part of OpenMVM.
 *
 * (c) OpenMVM <admin@openmvm.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace App\Libraries;

class Administrator {
	private $administrator_id;
	private $administrator_group_id;
	private $username;
	private $firstname;
	private $lastname;
	private $email;
	private $permission = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();

        if ($this->session->has('administrator_session_token')) {
            if ($this->session->has('administrator_id_' . $this->session->get('administrator_session_token'))) {
                $builder_administrator = $this->db->table('administrator');
                $builder_administrator->where('administrator_id', $this->session->get('administrator_id_' . $this->session->get('administrator_session_token')));
                $builder_administrator->where('status', 1);
                $administrator_query = $builder_administrator->get();
        
                if ($row_administrator = $administrator_query->getRow()) {
                    $this->administrator_id = $row_administrator->administrator_id;
                    $this->administrator_group_id = $row_administrator->administrator_group_id;
                    $this->username = $row_administrator->username;
                    $this->firstname = $row_administrator->firstname;
                    $this->lastname = $row_administrator->lastname;
                    $this->email = $row_administrator->email;

                    $builder_administrator_group = $this->db->table('administrator_group');
        
                    $builder_administrator_group->where('administrator_group_id', $row_administrator->administrator_group_id);
            
                    $administrator_group_query = $builder_administrator_group->get();
                    
                    if ($row_administrator_group = $administrator_group_query->getRow()) {
                        $permissions = json_decode($row_administrator_group->permission, true);

                        if (is_array($permissions)) {
                            foreach ($permissions as $key => $value) {
                                $this->permission[$key] = $value;
                            }
                        }
                    }
                } else {
                    $this->logout();
                }
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    /**
     * Administrator login.
     *
     */
    public function login($username, $password)
    {
        $builder_administrator = $this->db->table('administrator');
        $builder_administrator->where('username', $username);
        $administrator_query = $builder_administrator->get();

        $row_administrator = $administrator_query->getRow();

        if ($row_administrator && password_verify($password, $row_administrator->password)) {
            $session_token = bin2hex(random_bytes(20));

            $this->session->set('administrator_session_token', $session_token);
            $this->session->set('administrator_id_' . $session_token, $row_administrator->administrator_id);

            $this->administrator_id = $row_administrator->administrator_id;
            $this->administrator_group_id = $row_administrator->administrator_group_id;
            $this->username = $row_administrator->username;
            $this->firstname = $row_administrator->firstname;
            $this->lastname = $row_administrator->lastname;
            $this->email = $row_administrator->email;

            $builder_administrator_group = $this->db->table('administrator_group');

            $builder_administrator_group->where('administrator_group_id', $row_administrator->administrator_group_id);
    
            $administrator_group_query = $builder_administrator_group->get();
            
            if ($row_administrator_group = $administrator_group_query->getRow()) {
                $permissions = json_decode($row_administrator_group->permission, true);

                if (is_array($permissions)) {
                    foreach ($permissions as $key => $value) {
                        $this->permission[$key] = $value;
                    }
                }
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Administrator logout.
     *
     */
    public function logout()
    {
        $this->session->remove('administrator_id_' . $this->session->get('administrator_session_token'));
        $this->session->remove('administrator_session_token');

        $this->administrator_id = '';
        $this->administrator_group_id = '';
        $this->username = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->permission = [];
    }

    /**
     * Administrator logged in.
     *
     */
    public function isLoggedIn()
    {
        return $this->administrator_id;
    }

    /**
     * Administrator id.
     *
     */
    public function getId()
    {
        return $this->administrator_id;
    }

    /**
     * Administrator group id.
     *
     */
    public function getGroupId()
    {
        return $this->administrator_group_id;
    }

    /**
     * Administrator username.
     *
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Administrator firstname.
     *
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Administrator lastname.
     *
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Administrator email.
     *
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Administrator permission.
     *
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Administrator has permission.
     *
     */
	public function hasPermission($key, $value) {
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}

    /**
     * Get token.
     *
     */
    public function getToken()
    {
        if ($this->session->has('administrator_session_token')) {
            return $this->session->get('administrator_session_token');
        } else {
            return false;
        }
    }

    /**
     * Verify token.
     *
     */
    public function verifyToken($token)
    {
        $verify = false;

        if ($this->session->has('administrator_session_token') && !empty($token)) {
            if ($this->session->get('administrator_session_token') == $token) {
                $verify = true;
            }
        }

        return $verify;
    }
}