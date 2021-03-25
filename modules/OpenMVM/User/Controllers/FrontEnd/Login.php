<?php

namespace Modules\OpenMVM\User\Controllers\FrontEnd;

class Login extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->user = new \App\Libraries\User;
		// Load Models
		$this->userModel = new \Modules\OpenMVM\User\Models\UserModel();

		$this->user->logout();
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

		// Form Validation
		if ($this->request->getPost()) {
			$validate = $this->validate([
				'email' => ['label' => lang('Entry.entry_email', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				'password' => ['label' => lang('Entry.entry_password', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
			]);
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
			// User login
      if ($this->user->login($this->request->getPost('email'), $this->request->getPost('password'))) {
      	if (!empty($this->request->getPost('redirect'))) {
					return redirect()->to(base_url($this->request->getPost('redirect') . '/' . $this->user->getToken()));
      	} else {
					return redirect()->to(base_url('/account/' . $this->user->getToken()));
      	}
      } else {
      	$this->session->set('error', lang('Error.error_login', array(), $this->language->getFrontEndLocale()));

				return redirect()->to(base_url('/login'));
      }
		} else {
			$this->user->logout();
		}

		// Return
		return $this->getForm($data);
	}

	public function getForm($data = array())
	{
		// Data Form
		if($this->request->getPost('email')) {
			$data['email'] = $this->request->getPost('email');
		} else {
			$data['email'] = '';
		}

  	if ($this->session->has('user_redirect' . $this->session->user_session_id)) {
			$data['redirect'] = $this->session->get('user_redirect' . $this->session->user_session_id);
  	} else {
			$data['redirect'] = '';
  	}

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_login', array(), $this->language->getFrontEndLocale()),
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'User\login', $data);
	}
}
