<?php

namespace Modules\OpenMVM\User\Models;

use Modules\OpenMVM\User\Models\UserGroupModel;
use App\Libraries\PHPMailer_lib;

class UserModel extends \CodeIgniter\Model
{

  protected $table = 'user';
	protected $primaryKey = 'user_id';
  protected $allowedFields = ['user_id', 'user_group_id', 'username', 'password', 'salt', 'firstname', 'lastname', 'avatar', 'code', 'ip', 'status', 'date_added'];

	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		$this->phpmailer_lib = new PHPMailer_lib;
		$this->auth = new \App\Libraries\Auth;
		// Load Database
		$this->db = db_connect();
		// Load Models
		$this->userGroupModel = new UserGroupModel();
	}

	public function addUser($data = array())
	{
    // Data without user_group_id, status, and approved is data from user registration
    if (!empty($data['user_group_id'])) {
    	$user_group_id = $data['user_group_id'];
    } else {
    	$user_group_id = $this->setting->get('setting', 'setting_default_user_group_id');
    }

    if (!empty($data['username'])) {
    	$username = $data['username'];
    } else {
    	$username = 'openmvm' . $this->auth->randomToken(6);
    }

    // Hash password
    $salt = uniqid(mt_rand(), true);
    $hashed_password = hash('sha1', $data['password'] . $salt);

    if (!empty($data['firstname'])) {
    	$firstname = $data['firstname'];
    } else {
    	$firstname = '';
    }

    if (!empty($data['lastname'])) {
    	$lastname = $data['lastname'];
    } else {
    	$lastname = '';
    }

    $user_group_info = $this->userGroupModel->getUserGroup($user_group_id);

    if (!empty($data['status'])) {
    	$status = $data['status'];
    } else {
    	$status = 1;
    }

    if (!empty($data['approved'])) {
    	$approved = $data['approved'];
    } else {
    	if ($user_group_info && $user_group_info['email_verification']) {
    		$approved = 0;
    	} else {
    		$approved = 1;
    	}
    }

    // Avatar
    if ($data['avatar'] && is_file(ROOTPATH . 'public/assets/files/' . $data['avatar'])) {
    	$avatar = $data['avatar'];
    } else {
    	$avatar = '';
    }

    // Wallpaper
    if ($data['wallpaper'] && is_file(ROOTPATH . 'public/assets/files/' . $data['wallpaper'])) {
    	$wallpaper = $data['wallpaper'];
    } else {
    	$wallpaper = '';
    }

		// Insert Data into the Database
		$builder = $this->db->table('user');

    $query_data = array(
      'user_group_id' => $user_group_id,
      'username'      => $username,
      'password'      => $hashed_password,
      'salt'          => $salt,
      'firstname'     => $firstname,
      'lastname'      => $lastname,
      'email'         => $data['email'],
      'status'        => $status,
      'approved'      => $approved,
      'avatar'        => $avatar,
      'wallpaper'     => $wallpaper,
      'code'          => bin2hex(random_bytes(40)),
      'date_added'    => date("Y-m-d H:i:s",now()),
    );

		$builder->insert($query_data);

		$user_id = $this->db->insertID();

		// User Addresses
		$builder = $this->db->table('user_address');
		$builder->where('user_id', $user_id);
		$builder->delete();

		if (!empty($data['user_address'])) {
			foreach ($data['user_address'] as $user_address) {
				$builder = $this->db->table('user_address');

		    $query_data_2 = array(
		      'user_id'     => $user_id,
		      'firstname'   => $user_address['firstname'],
		      'lastname'    => $user_address['lastname'],
		      'address'     => $user_address['address'],
		      'country_id'  => $user_address['country_id'],
		      'state_id'    => $user_address['state_id'],
		      'city_id'     => $user_address['city_id'],
		      'district_id' => $user_address['district_id'],
		      'postal_code' => $user_address['postal_code'],
		      'telephone'   => $user_address['telephone'],
		    );

				$builder->insert($query_data_2);

				$user_address_id = $this->db->insertID();

				// Update User Default Address
				if ($user_address['is_default']) {
					$builder = $this->db->table('user');

			    $query_data_3 = array(
			      'user_address_id' => $user_address_id,
			    );

					$builder->where('user_id', $user_id);
					$query = $builder->update($query_data_3);
				}
			}
		}

    // Send Email Verification Mail if Required
		if ($user_group_info && $user_group_info['email_verification']) {
			$user_info = $this->getUser($user_id);

			if ($user_info) {
				// Get Current Language
				$segments = explode('/', uri_string());

				$language_info = $this->language->getLanguageByCode($segments[0]);

				if ($language_info['language_id']) {
					$language_id = $language_info['language_id'];
				} elseif ($this->session->has('front_lang_id')) {
					$language_id = $this->session->get('front_lang_id');
				} else {
					$language_id = $this->setting->get('setting','setting_front_lang_id');
				}

				if ($language_info['code']) {
					$language_code = $language_info['code'];
				} elseif ($this->session->has('front_lang_code')) {
					$language_code = $this->session->get('front_lang_code');
				} else {
					$language_code = $segments[0];
				}

				$builder = $this->db->table('user_email_verification');
				$builder->where('username', $data['username']);
				$builder->where('email', $data['email']);
				$builder->delete();

				$builder = $this->db->table('user_email_verification');

		    $query_data = array(
		      'username'      => $data['username'],
		      'email'         => $data['email'],
		      'code'          => bin2hex(random_bytes(40)),
		      'date_added'    => date("Y-m-d H:i:s",now()),
		      'date_expired'  => date("Y-m-d H:i:s",strtotime("+7 day",now())),
		    );

				$query = $builder->insert($query_data);

				// Send Mail
				$mail = $this->phpmailer_lib->load();

		    // SMTP configuration
		    $mail->SMTPDebug   = 0; // Enable verbose debug output
		    $mail->isSMTP();     
		    $mail->Timeout     = $this->setting->get('setting','setting_smtp_timeout'); // Set mailer to use SMTP
		    $mail->Host        = $this->setting->get('setting','setting_smtp_hostname'); // Specify main and backup SMTP servers
		    $mail->SMTPAuth    = true; // Enable SMTP authentication
		    $mail->Username    = $this->setting->get('setting','setting_smtp_username'); // SMTP username
		    $mail->Password    = $this->setting->get('setting','setting_smtp_password'); // SMTP password
		    $mail->SMTPSecure  = 'ssl'; // Enable TLS encryption, `ssl` also accepted
				$mail->SMTPOptions = array(
			    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
			    )
				);
		    $mail->Port        = $this->setting->get('setting','setting_smtp_port'); // TCP port to connect to

		    //Recipients
		    $mail->setFrom($this->setting->get('setting','setting_smtp_username'), html_entity_decode($this->setting->get('setting','setting_website_name'), ENT_QUOTES, 'UTF-8'));
		    $mail->addAddress($user_info['email'], html_entity_decode($user_info['firstname'] . ' ' . $user_info['lastname'], ENT_QUOTES, 'UTF-8')); // Add a recipient

		    // Content
		    $mail->isHTML(true); // Set email format to HTML
		    $mail->Subject = sprintf(lang('Mail.mail_subject_email_verification', array(), $language_code), html_entity_decode($this->setting->get('setting','setting_website_name'), ENT_QUOTES, 'UTF-8'));

		    $mail_data = array(
		    	'front_locale' => $language_code,
		    	'website_name' => $this->setting->get('setting','setting_website_name'),
		    	'firstname'    => $user_info['firstname'],
		    	'lastname'     => $user_info['lastname'],
		    	'username'     => $user_info['username'],
		    	'email'        => $user_info['email'],
		    	'code'         => $user_info['code'],
		    );

		    // $mail->Body    = view('welcome_message', $mail_data);
		    // $mail->AltBody = view('welcome_message', $mail_data);

		    // Send email
		    $mail->send();
			}
		}

		return $user_id;
	}

	public function getUsers($data = array())
	{
		$results = array();

		$builder = $this->db->table('user');

		if (!empty($data['filter_username'])) {
      $builder->like('username', $data['filter_username']);
		}

		if (!empty($data['filter_name'])) {
      $builder->like('CONCAT(firstname, " ", lastname)', $data['filter_name']);
		}

		if (!empty($data['filter_email'])) {
      $builder->like('email', $data['filter_email']);
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
	      'user_id'       => $row->user_id,
	      'user_group_id' => $row->user_group_id,
	      'username'      => $row->username,
	      'name'          => $row->firstname . ' ' . $row->lastname,
	      'firstname'     => $row->firstname,
	      'lastname'      => $row->lastname,
	      'email'         => $row->email,
	      'avatar'        => $row->avatar,
	      'ip'            => $row->ip,
	      'status'        => $row->status,
      	'approved'      => $row->approved,
	      'date_added'    => $row->date_added,
		  );
		}

		return $results;
	}

	public function getUser($user_id)
	{
		return $this->asArray()->where(['user_id' => $user_id])->first();
	}

	public function getUserByUsername($username)
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

	public function getUserByEmail($email)
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

	public function getUserByUsernameAndEmail($username, $email)
	{
		if ($username && $email) {
			$result = $this->asArray()->where(['username' => $username, 'email' => $email])->first();

			if (!empty($result)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	public function getUserLogin($data = array())
	{
    $user_info = $this->asArray()->where(['username' => $data['username'], 'approved' => 1])->first();

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

	public function editUser($data = array(), $user_id)
	{
		// User Data
		$builder = $this->db->table('user');

		if ($data['user_group_id'] !== null) {
			$builder->set('user_group_id', $data['user_group_id']);
		}

		if ($data['username'] !== null) {
			$builder->set('username', $data['username']);
		}

		if ($data['firstname'] !== null) {
			$builder->set('firstname', $data['firstname']);
		}

		if ($data['lastname'] !== null) {
			$builder->set('lastname', $data['lastname']);
		}

		if ($data['email'] !== null) {
			$builder->set('email', $data['email']);
		}

		if ($data['status'] !== null) {
			$builder->set('status', $data['status']);
		}

		if ($data['approved'] !== null) {
			$builder->set('approved', $data['approved']);
		}

		if ($data['code'] !== null) {
			$builder->set('code', $data['code']);
		} else {
			$builder->set('code', bin2hex(random_bytes(40)));
		}

		if ($data['date_modified'] !== null) {
			$builder->set('date_modified', $data['date_modified']);
		} else {
			$builder->set('date_modified', date("Y-m-d H:i:s",now()));
		}

    // Avatar
    if ($data['avatar'] !== null && is_file(ROOTPATH . 'public/assets/files/' . $data['avatar'])) {
			$builder->set('avatar', $data['avatar']);
    } else {
    	$avatar = null;
    }

    // Wallpaper
    if ($data['wallpaper'] !== null && is_file(ROOTPATH . 'public/assets/files/' . $data['wallpaper'])) {
			$builder->set('wallpaper', $data['wallpaper']);
    } else {
    	$wallpaper = null;
    }

		$builder->where('user_id', $user_id);
		$query = $builder->update($query_data);

		// Password
		if (!empty($data['password'])) {
	    // Hash password
	    $salt = uniqid(mt_rand(), true);
	    $hashed_password = hash('sha1', $data['password'] . $salt);

	    $query_data_2 = array(
	      'password' => $hashed_password,
	      'salt'     => $salt,
	    );

			$builder->where('user_id', $user_id);
			$query = $builder->update($query_data_2);

		}

		if (!empty($data['user_address'])) {
			// User Addresses
			$builder = $this->db->table('user_address');
			$builder->where('user_id', $user_id);
			$builder->delete();

			foreach ($data['user_address'] as $user_address) {
				$builder = $this->db->table('user_address');

				if ($user_address['user_address_id'] == null) {
			    $query_data_3 = array(
			      'user_id'     => $user_id,
			      'firstname'   => $user_address['firstname'],
			      'lastname'    => $user_address['lastname'],
			      'address'     => $user_address['address'],
			      'country_id'  => $user_address['country_id'],
			      'state_id'    => $user_address['state_id'],
			      'city_id'     => $user_address['city_id'],
			      'district_id' => $user_address['district_id'],
			      'postal_code' => $user_address['postal_code'],
			      'telephone'   => $user_address['telephone'],
			    );

					$builder->insert($query_data_3);

					$user_address_id = $this->db->insertID();
				} else {
			    $query_data_3 = array(
			      'user_address_id' => $user_address['user_address_id'],
			      'user_id'         => $user_id,
			      'firstname'       => $user_address['firstname'],
			      'lastname'        => $user_address['lastname'],
			      'address'         => $user_address['address'],
			      'country_id'      => $user_address['country_id'],
			      'state_id'        => $user_address['state_id'],
			      'city_id'         => $user_address['city_id'],
			      'district_id'     => $user_address['district_id'],
			      'postal_code'     => $user_address['postal_code'],
			      'telephone'       => $user_address['telephone'],
			    );

					$builder->insert($query_data_3);

					$user_address_id = $user_address['user_address_id'];
				}

				// Update User Default Address
				if ($user_address['is_default']) {
					$builder = $this->db->table('user');

			    $query_data_4 = array(
			      'user_address_id' => $user_address_id,
			    );

					$builder->where('user_id', $user_id);
					$query = $builder->update($query_data_4);
				}
			}
		}

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function editFrontUser($data = array(), $user_id)
	{
		// User Data
		$builder = $this->db->table('user');

    $query_data = array(
      'firstname'     => $data['firstname'],
      'lastname'      => $data['lastname'],
      'date_modified' => date("Y-m-d H:i:s",now()),
    );

		$builder->where('user_id', $user_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteUser($user_id)
	{
		$builder = $this->db->table('user');
		$builder->where('user_id', $user_id);
		$builder->delete();

		$builder = $this->db->table('user_address');
		$builder->where('user_id', $user_id);
		$builder->delete();
	}

	public function editPassword($password, $user_id)
	{
		$builder = $this->db->table('user');

    // Hash password
    $salt = uniqid(mt_rand(), true);
    $hashed_password = hash('sha1', $password . $salt);

    $query_data = array(
      'password'   => $hashed_password,
      'salt'       => $salt
    );

		$builder->where('user_id', $user_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function getUserAddresses($user_id)
	{
		$results = array();

		$builder = $this->db->table('user_address');
		$builder->where('user_id', $user_id);

		$query   = $builder->get();

		foreach ($query->getResult() as $row)
		{
		  $results[] = array(
	      'user_address_id' => $row->user_address_id,
	      'user_id'         => $row->user_id,
	      'firstname'       => $row->firstname,
	      'lastname'        => $row->lastname,
	      'address'         => $row->address,
	      'country_id'      => $row->country_id,
	      'state_id'        => $row->state_id,
	      'city_id'         => $row->city_id,
	      'district_id'         => $row->district_id,
	      'postal_code'     => $row->postal_code,
	      'telephone'       => $row->telephone,
	      'is_default'      => $row->is_default,
		  );
		}

		return $results;
	}

	public function getUserAddress($user_address_id)
	{
		$builder = $this->db->table('user_address');
		$builder->where('user_address_id', $user_address_id);
		$query = $builder->get();

		$row = $query->getRow();

		$result = array(
      'user_address_id' => $row->user_address_id,
      'user_id'         => $row->user_id,
      'firstname'       => $row->firstname,
      'lastname'        => $row->lastname,
      'address'         => $row->address,
      'country_id'      => $row->country_id,
      'state_id'        => $row->state_id,
      'city_id'         => $row->city_id,
      'district_id'         => $row->district_id,
	    'postal_code'     => $row->postal_code,
      'telephone'       => $row->telephone,
      'is_default'      => $row->is_default,
		);

		return $result;
	}

	public function checkAccessPermission($location, $user_group_id)
	{
    $result = $this->asArray()->where(['user_group_id' => $user_group_id])->first();

    if ($result) {
      $permissions = json_decode($result['permission']);

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

	public function loggedIn($user_token)
	{
    if (!$this->session->get('user_logged_in' . $this->session->user_session_id) || $this->session->get('user_token' . $this->session->user_session_id) !== $user_token)
    {
    	return false;
    } else {
    	return true;
    }
	}

	public function formLoggedIn()
	{
    if (!$this->session->get('user_logged_in' . $this->session->user_session_id))
    {
    	return false;
    } else {
    	return true;
    }
	}

	public function verifyUser($username, $code)
	{
		if ($username) {
			$result = $this->asArray()->where(['username' => $username, 'code' => $code])->first();

			if (!empty($result)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	public function approveUser($username)
	{
		$builder = $this->db->table('user');

    $query_data = array(
      'approved' => 1,
    );

		$builder->where('username', $username);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function addUserPasswordRecoveryRequest($data = array())
	{
		// Get User Info
		$user_info = $this->getUserByUsernameAndEmail($data['username'], $data['email']);

		if ($user_info) {
			// Get Current Language
			$segments = explode('/', uri_string());

			$language_info = $this->language->getLanguageByCode($segments[0]);

			if ($language_info['language_id']) {
				$language_id = $language_info['language_id'];
			} elseif ($this->session->has('front_lang_id')) {
				$language_id = $this->session->get('front_lang_id');
			} else {
				$language_id = $this->setting->get('setting','setting_front_lang_id');
			}

			if ($language_info['code']) {
				$language_code = $language_info['code'];
			} elseif ($this->session->has('front_lang_code')) {
				$language_code = $this->session->get('front_lang_code');
			} else {
				$language_code = $segments[0];
			}

			$builder = $this->db->table('user_password_recovery_request');
			$builder->where('username', $data['username']);
			$builder->where('email', $data['email']);
			$builder->delete();

			$builder = $this->db->table('user_password_recovery_request');

	    $query_data = array(
	      'username'      => $data['username'],
	      'email'         => $data['email'],
	      'code'          => bin2hex(random_bytes(40)),
	      'date_added'    => date("Y-m-d H:i:s",now()),
	      'date_expired'  => date("Y-m-d H:i:s",strtotime("+1 hour",now())),
	    );

			$query = $builder->insert($query_data);

			// Send Mail
			$mail = $this->phpmailer_lib->load();

	    // SMTP configuration
	    $mail->SMTPDebug   = 0; // Enable verbose debug output
	    $mail->isSMTP();     
	    $mail->Timeout     = $this->setting->get('setting','setting_smtp_timeout'); // Set mailer to use SMTP
	    $mail->Host        = $this->setting->get('setting','setting_smtp_hostname'); // Specify main and backup SMTP servers
	    $mail->SMTPAuth    = true; // Enable SMTP authentication
	    $mail->Username    = $this->setting->get('setting','setting_smtp_username'); // SMTP username
	    $mail->Password    = $this->setting->get('setting','setting_smtp_password'); // SMTP password
	    $mail->SMTPSecure  = 'ssl'; // Enable TLS encryption, `ssl` also accepted
			$mail->SMTPOptions = array(
		    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
		    )
			);
	    $mail->Port        = $this->setting->get('setting','setting_smtp_port'); // TCP port to connect to

	    //Recipients
	    $mail->setFrom($this->setting->get('setting','setting_smtp_username'), html_entity_decode($this->setting->get('setting','setting_website_name'), ENT_QUOTES, 'UTF-8'));
	    $mail->addAddress($user_info['email'], html_entity_decode($user_info['firstname'] . ' ' . $user_info['lastname'], ENT_QUOTES, 'UTF-8')); // Add a recipient

	    // Content
	    $mail->isHTML(true); // Set email format to HTML
	    $mail->Subject = sprintf(lang('Mail.mail_subject_forgot_password', array(), $language_code), html_entity_decode($this->setting->get('setting','setting_website_name'), ENT_QUOTES, 'UTF-8'));

	    $mail_data = array(
	    	'front_locale' => $language_code,
	    	'website_name' => $this->setting->get('setting','setting_website_name'),
	    	'firstname'    => $user_info['firstname'],
	    	'lastname'     => $user_info['lastname'],
	    	'username'     => $user_info['username'],
	    	'email'        => $user_info['email'],
	    	'code'         => $user_info['code'],
	    );

	    $mail->Body    = view('welcome_message', $mail_data);
	    $mail->AltBody = view('welcome_message', $mail_data);

	    // Send email
	    if($mail->send()){
				return true;
		  } else {
				return false;
		  }
		} else {
			return false;
		}
	}

	public function getUserPasswordRecoveryRequest($username, $code)
	{
		$builder = $this->db->table('user_password_recovery_request');
		$builder->where('username', $username);
		$builder->where('code', $code);
		$query = $builder->get();

		$row = $query->getRow();

		$result = array(
      'username'        => $row->username,
      'email'           => $row->email,
      'code'            => $row->code,
      'date_added'      => $row->date_added,
      'date_expired'    => $row->date_expired,
		);

		if ($row && strtotime($row->date_expired) > strtotime('now')) {
			return $result;
		} else {
			return null;
		}
	}

	public function addUserEmailVerification($data = array())
	{
		// Get User Info
		$user_info = $this->getUserByUsernameAndEmail($data['username'], $data['email']);

		if ($user_info) {
			// Get Current Language
			$segments = explode('/', uri_string());

			$language_info = $this->language->getLanguageByCode($segments[0]);

			if ($language_info['language_id']) {
				$language_id = $language_info['language_id'];
			} elseif ($this->session->has('front_lang_id')) {
				$language_id = $this->session->get('front_lang_id');
			} else {
				$language_id = $this->setting->get('setting','setting_front_lang_id');
			}

			if ($language_info['code']) {
				$language_code = $language_info['code'];
			} elseif ($this->session->has('front_lang_code')) {
				$language_code = $this->session->get('front_lang_code');
			} else {
				$language_code = $segments[0];
			}

			$builder = $this->db->table('user_email_verification');
			$builder->where('username', $data['username']);
			$builder->where('email', $data['email']);
			$builder->delete();

			$builder = $this->db->table('user_email_verification');

	    $query_data = array(
	      'username'      => $data['username'],
	      'email'         => $data['email'],
	      'code'          => bin2hex(random_bytes(40)),
	      'date_added'    => date("Y-m-d H:i:s",now()),
	      'date_expired'  => date("Y-m-d H:i:s",strtotime("+7 day",now())),
	    );

			$query = $builder->insert($query_data);

			// Send Mail
			$mail = $this->phpmailer_lib->load();

	    // SMTP configuration
	    $mail->SMTPDebug   = 0; // Enable verbose debug output
	    $mail->isSMTP();     
	    $mail->Timeout     = $this->setting->get('setting','setting_smtp_timeout'); // Set mailer to use SMTP
	    $mail->Host        = $this->setting->get('setting','setting_smtp_hostname'); // Specify main and backup SMTP servers
	    $mail->SMTPAuth    = true; // Enable SMTP authentication
	    $mail->Username    = $this->setting->get('setting','setting_smtp_username'); // SMTP username
	    $mail->Password    = $this->setting->get('setting','setting_smtp_password'); // SMTP password
	    $mail->SMTPSecure  = 'ssl'; // Enable TLS encryption, `ssl` also accepted
			$mail->SMTPOptions = array(
		    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
		    )
			);
	    $mail->Port        = $this->setting->get('setting','setting_smtp_port'); // TCP port to connect to

	    //Recipients
	    $mail->setFrom($this->setting->get('setting','setting_smtp_username'), html_entity_decode($this->setting->get('setting','setting_website_name'), ENT_QUOTES, 'UTF-8'));
	    $mail->addAddress($user_info['email'], html_entity_decode($user_info['firstname'] . ' ' . $user_info['lastname'], ENT_QUOTES, 'UTF-8')); // Add a recipient

	    // Content
	    $mail->isHTML(true); // Set email format to HTML
	    $mail->Subject = sprintf(lang('Mail.mail_subject_email_verification', array(), $language_code), html_entity_decode($this->setting->get('setting','setting_website_name'), ENT_QUOTES, 'UTF-8'));

	    $mail_data = array(
	    	'front_locale' => $language_code,
	    	'website_name' => $this->setting->get('setting','setting_website_name'),
	    	'firstname'    => $user_info['firstname'],
	    	'lastname'     => $user_info['lastname'],
	    	'username'     => $user_info['username'],
	    	'email'        => $user_info['email'],
	    	'code'         => $user_info['code'],
	    );

	    $mail->Body    = view('welcome_message', $mail_data);
	    $mail->AltBody = view('welcome_message', $mail_data);

	    // Send email
	    if($mail->send()){
				return true;
		  } else {
				return false;
		  }
		} else {
			return false;
		}
	}

	public function getUserEmailVerification($username, $code)
	{
		$builder = $this->db->table('user_email_verification');
		$builder->where('username', $username);
		$builder->where('code', $code);
		$query = $builder->get();

		$row = $query->getRow();

		$result = array(
      'username'        => $row->username,
      'email'           => $row->email,
      'code'            => $row->code,
      'date_added'      => $row->date_added,
      'date_expired'    => $row->date_expired,
		);

		if ($row && strtotime($row->date_expired) > strtotime('now')) {
			return $result;
		} else {
			return null;
		}
	}

	public function getTotalUsers($data = array())
	{
		$results = array();

		$builder = $this->db->table('user');
    
		$query = $builder->countAllResults();

		return $query;
	}
}