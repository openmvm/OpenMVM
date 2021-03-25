<?php

namespace App\Libraries;

class Auth
{
	public function __construct()
	{
		// Load Libraries
		$this->session = session();
	}

  public function validateAdministratorToken($token)
  {
  	if (!empty($this->session->get('administrator_token_' . $this->session->administrator_session_id))) {
  		$administrator_token = $this->session->get('administrator_token_' . $this->session->administrator_session_id);

  		if ($administrator_token == $token) {
  			return true;
  		} else {
  			return false;
  		}
  	} else {
  		return false;
  	}
  }

  public function validateUserToken($token)
  {
  	if (!empty($this->session->get('user_token_' . $this->session->user_session_id))) {
  		$user_token = $this->session->get('user_token_' . $this->session->user_session_id);

  		if ($user_token == $token) {
  			return true;
  		} else {
  			return false;
  		}
  	} else {
  		return false;
  	}
  }

  public function randomToken($length = 40)
  {
  	$csrf_token = bin2hex(random_bytes($length));

    return $csrf_token;
  }

  public function csrfToken()
  {
  	$csrf_token = bin2hex(random_bytes(32));

    return $csrf_token;
  }

  public function sessionId()
  {
  	$session_id = uniqid();

    return $session_id;
  }

  public function token()
  {
  	$token = hash('sha1', date("Y-m-d H:i:s", now()) . $this->salt());

    return $token;
  }

  public function salt()
  {
  	$salt = uniqid(mt_rand(), true);

    return $salt;
  }
}