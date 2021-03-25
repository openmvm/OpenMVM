<?php

namespace Modules\OpenMVM\Administrator\Controllers\BackEnd;

class Login extends \App\Controllers\BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

    // Data Notification
    if ($this->session->get('error') !== null) {
			$data['error'] = $this->session->get('error');

			$this->session->remove('error');
    } else {
			$data['error'] = '';
    }

    if ($this->session->get('success') !== null) {
			$data['success'] = $this->session->get('success');

			$this->session->remove('success');
    } else {
			$data['success'] = '';
    }

		// Data Text
		$data['heading_title'] = lang('Heading.heading_administrator_login', array(), $this->language->getBackEndLocale());
		$data['website_name'] = $this->setting->get('setting', 'setting_website_name');

		// Form Validation
		if ($this->request->getPost()) {
			$validate = $this->validate([
				'username' => ['label' => lang('Entry.entry_username', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
				'password' => ['label' => lang('Entry.entry_password', array(), $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getBackEndLocale())]],
			]);
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
			// Administrator login
      if ($this->administrator->login($this->request->getPost('username'), $this->request->getPost('password'))) {
      	if (!empty($this->request->getPost('redirect'))) {
					return redirect()->to(base_url($this->request->getPost('redirect') . '/' . $this->administrator->getToken()));
      	} else {
					return redirect()->to(base_url($_SERVER['app.adminDir'] . '/dashboard/' . $this->administrator->getToken()));
      	}
      } else {
      	$this->session->set('error', lang('Error.error_login', array(), $this->language->getBackEndLocale()));

				return redirect()->to(base_url($_SERVER['app.adminDir'] . '/login'));
      }
		} else {
			$this->administrator->logout();
		}

		// Return
		return $this->getForm($data);
	}

	public function getForm($data = array())
	{
		// Data Form
		if($this->request->getPost('username')) {
			$data['username'] = $this->request->getPost('username');
		} else {
			$data['username'] = '';
		}

		if($this->request->getPost('password')) {
			$data['password'] = $this->request->getPost('password');
		} else {
			$data['password'] = '';
		}

  	if ($this->session->has('administrator_redirect' . $this->session->administrator_session_id)) {
			$data['redirect'] = $this->session->get('administrator_redirect' . $this->session->administrator_session_id);
  	} else {
			$data['redirect'] = '';
  	}

		// Echo view
		echo $this->template->render('BackendThemes', 'Administrator\login', $data);
	}
}
