<?php

namespace Modules\OpenMVM\User\Controllers\FrontEnd;

class Profile extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->userModel = new \Modules\OpenMVM\User\Models\UserModel();
	}

	public function index()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/profile');

			return redirect()->to(base_url('/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_account', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_profile', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/profile/' . $this->user->getToken()),
			'active' => true,
		);

		// Form Validation
		if ($this->request->getPost()) {
			// Check Username
			$username_exists = $this->userModel->getUserByUsername($this->request->getPost('username'));

			if ($username_exists && $username_exists['user_id'] == $this->user->getId()) {
				$this->validate([
					'username' => ['label' => lang('Entry.entry_username', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				]);
			} else {
				$this->validate([
					'username' => ['label' => lang('Entry.entry_username', array(), $this->language->getFrontEndLocale()), 'rules' => 'required|is_unique[user.username]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale()), 'is_unique' => lang('Error.error_exists', array(), $this->language->getFrontEndLocale())]],
				]);
			}

			$this->validate([
				'firstname' => ['label' => lang('Entry.entry_firstname', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
			]);

			$this->validate([
				'lastname' => ['label' => lang('Entry.entry_lastname'), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
			]);

			// Check Email
			$email_exists = $this->userModel->getUserByEmail($this->request->getPost('email'));

			if ($email_exists && $email_exists['user_id'] == $this->user->getId()) {
				$this->validate([
					'email' => ['label' => lang('Entry.entry_email', array(), $this->language->getFrontEndLocale()), 'rules' => 'required|valid_email', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale()), 'valid_email' => lang('Error.error_invalid', array(), $this->language->getFrontEndLocale())]],
				]);
			} else {
				$this->validate([
					'email' => ['label' => lang('Entry.entry_email', array(), $this->language->getFrontEndLocale()), 'rules' => 'required|valid_email|is_unique[user.email]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale()), 'valid_email' => lang('Error.error_invalid', array(), $this->language->getFrontEndLocale()), 'is_unique' => lang('Error.error_exists', array(), $this->language->getFrontEndLocale())]],
				]);
			}

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getFrontEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
      // Query
    	$query = $this->userModel->editUser($this->request->getPost(), $this->user->getId());
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_user_edit', array(), $this->language->getFrontEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_user_edit', array(), $this->language->getFrontEndLocale()));
      }
    
			return redirect()->to(base_url('/account/' . $this->user->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function getForm($data = array())
	{
		// Data Form
		$user_info = $this->userModel->getUser($this->user->getId());

		if (!$user_info) {
			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/profile');

			return redirect()->to(base_url('/login'));
		}

		if($this->request->getPost('username')) {
			$data['username'] = $this->request->getPost('username');
		} else {
			$data['username'] = $user_info['username'];
		}

		if ($this->request->getPost('avatar')) {
			$data['thumb_avatar'] = $this->image->resize($this->request->getPost('avatar'), 150, 150, true, 'auto');
		} else {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $user_info['avatar'])) {
				$data['thumb_avatar'] = $this->image->resize($user_info['avatar'], 150, 150, true, 'auto');
			} else {
				$data['thumb_avatar'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		}

		if ($this->request->getPost('avatar')) {
			$data['avatar'] = $this->request->getPost('avatar');
		} elseif (is_file(ROOTPATH . 'public/assets/files/' . $user_info['avatar'])) {
			$data['avatar'] = $user_info['avatar'];
		} else {
			$data['avatar'] = '';
		}

		if ($this->request->getPost('wallpaper')) {
			$data['thumb_wallpaper'] = $this->image->resize($this->request->getPost('wallpaper'), 150, 150, true, 'auto');
		} else {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $user_info['wallpaper'])) {
				$data['thumb_wallpaper'] = $this->image->resize($user_info['wallpaper'], 150, 150, true, 'auto');
			} else {
				$data['thumb_wallpaper'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		}

		if ($this->request->getPost('wallpaper')) {
			$data['wallpaper'] = $this->request->getPost('wallpaper');
		} elseif (is_file(ROOTPATH . 'public/assets/files/' . $user_info['wallpaper'])) {
			$data['wallpaper'] = $user_info['wallpaper'];
		} else {
			$data['wallpaper'] = '';
		}

		if($this->request->getPost('firstname')) {
			$data['firstname'] = $this->request->getPost('firstname');
		} else {
			$data['firstname'] = $user_info['firstname'];
		}

		if($this->request->getPost('lastname')) {
			$data['lastname'] = $this->request->getPost('lastname');
		} else {
			$data['lastname'] = $user_info['lastname'];
		}

		if($this->request->getPost('email')) {
			$data['email'] = $this->request->getPost('email');
		} else {
			$data['email'] = $user_info['email'];
		}
		
		if (!empty($this->setting->get('setting', 'setting_placeholder'))) {
	    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
				$data['placeholder'] = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 150, 150, true, 'auto');
			} else {
				$data['placeholder'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
			}
		} else {
			$data['placeholder'] = $this->image->resize('placeholder.png', 150, 150, true, 'auto');
		}

		$data['user_token'] = $this->user->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_profile', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'User\profile', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}
}
