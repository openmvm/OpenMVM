<?php

namespace Modules\OpenMVM\User\Controllers\FrontEnd;

class Register extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->userModel = new \Modules\OpenMVM\User\Models\UserModel();
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
				'email' => ['label' => lang('Entry.entry_email', array(), $this->language->getFrontEndLocale()), 'rules' => 'required|valid_email|is_unique[user.email]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale()), 'valid_email' => lang('Error.error_valid_email', array(), $this->language->getFrontEndLocale()), 'is_unique' => lang('Error.error_exists', array(), $this->language->getFrontEndLocale())]],
				'password' => ['label' => lang('Entry.entry_password', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				'passconf' => ['label' => lang('Entry.entry_passconf', array(), $this->language->getFrontEndLocale()), 'rules' => 'required|matches[password]', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale()), 'matches' => lang('Error.error_matches', array(), $this->language->getFrontEndLocale())]],
			]);
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
      // Query
    	$query = $this->userModel->addUser($this->request->getPost());
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_user_add', array(), $this->language->getFrontEndLocale()));

				return redirect()->to(base_url('/register/success'));
      } else {
      	$this->session->set('error', lang('Error.error_user_add', array(), $this->language->getFrontEndLocale()));

				return redirect()->to(base_url('/register/failed'));
      }
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

		if($this->request->getPost('password')) {
			$data['password'] = $this->request->getPost('password');
		} else {
			$data['password'] = '';
		}

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_register', array(), $this->language->getFrontEndLocale()),
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'User\register', $data);
	}

	public function success($data = array())
	{
    // Data Text
		$data['message'] = lang('Success.success_user_registration', array(), $this->language->getFrontEndLocale());;
    
		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_success', array(), $this->language->getFrontEndLocale()),
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'Common\success', $data);
	}

	public function successVerify($data = array())
	{
    // Data Text
		$data['message'] = lang('Success.success_user_registration_verify', array(), $this->language->getFrontEndLocale());;
    
		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_success', array(), $this->language->getFrontEndLocale()),
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'Common\success', $data);
	}

	public function error($data = array())
	{
    // Data Text
		$data['message'] = lang('Error.error_user_registration', array(), $this->language->getFrontEndLocale());;

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_error', array(), $this->language->getFrontEndLocale()),
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'Common\error', $data);
	}
}
