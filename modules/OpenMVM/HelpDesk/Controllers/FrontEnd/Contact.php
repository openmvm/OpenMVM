<?php

namespace Modules\OpenMVM\HelpDesk\Controllers\FrontEnd;

class Contact extends \App\Controllers\BaseController
{
	public function index()
	{
		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

		// Data Links
		$data['action'] = base_url('/contact_us');

		// Form Validation
		if ($this->request->getMethod() === 'post') {
			$validate = $this->validate([
				'firstname' => ['label' => lang('Entry.entry_firstname', array(),  $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getFrontEndLocale())]],
				'lastname' => ['label' => lang('Entry.entry_lastname', array(),  $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getFrontEndLocale())]],
				'email' => ['label' => lang('Entry.entry_email', array(),  $this->language->getFrontEndLocale()), 'rules' => 'required|valid_email', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getFrontEndLocale()), 'valid_email' => lang('Error.error_invalid', array(), $this->language->getFrontEndLocale())]],
				'message' => ['label' => lang('Entry.entry_message', array(),  $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getFrontEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getFrontEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
			// Send Mail
	    $query = $this->mail->send($this->request->getPost('email'), $this->request->getPost('firstname') . ' ' . $this->request->getPost('lastname'), $this->setting->get('setting','setting_smtp_username'), $this->setting->get('setting','setting_website_name'), sprintf(lang('Mail.mail_contact_us_subject', array(), $this->language->getFrontEndLocale()), $this->request->getPost('firstname') . ' ' . $this->request->getPost('lastname')), $this->request->getPost('message'), true);
    
      if ($query) {
				return redirect()->to(base_url('/contact_us/success'));
      } else {
				return redirect()->to(base_url('/contact_us/error'));
      }
		}

		// Return
		return $this->getForm($data);
	}

	public function getForm($data = array())
	{
		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_contact_us', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/contact_us/' . $this->user->getToken()),
			'active' => true,
		);

		// Data Form
		if($this->request->getPost('firstname')) {
			$data['firstname'] = $this->request->getPost('firstname');
		} else {
			$data['firstname'] = '';
		}

		if($this->request->getPost('lastname')) {
			$data['lastname'] = $this->request->getPost('lastname');
		} else {
			$data['lastname'] = '';
		}

		if($this->request->getPost('email')) {
			$data['email'] = $this->request->getPost('email');
		} else {
			$data['email'] = '';
		}

		if($this->request->getPost('message')) {
			$data['message'] = $this->request->getPost('message');
		} else {
			$data['message'] = '';
		}

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_contact_us', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'HelpDesk\contact', $data);
	}

	public function success($data = array())
	{
		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_contact_us', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/contact_us/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_success', array(), $this->language->getFrontEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['message'] = lang('Success.success_message_send', array(), $this->language->getFrontEndLocale());

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_contact_us', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
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
		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_contact_us', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/contact_us/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_success', array(), $this->language->getFrontEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['message'] = lang('Error.error_message_send', array(), $this->language->getFrontEndLocale());

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_contact_us', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'Common\error', $data);
	}
}
