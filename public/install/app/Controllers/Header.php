<?php namespace App\Controllers;

class Header extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Libraries
		$this->session = \Config\Services::session();
	}

	public function index($header_parameter)
	{
		$header_data = array();
		
        $header_data['base'] = base_url();

	    // Message
	    if ($this->session->get('error') !== null) {
			$header_data['error'] = $this->session->get('error');

			$this->session->remove('error');
	    } else {
			$header_data['error'] = '';
	    }

	    if ($this->session->get('success') !== null) {
			$header_data['success'] = $this->session->get('success');

			$this->session->remove('success');
	    } else {
			$header_data['success'] = '';
	    }

		if (!empty($header_parameter['title'])) {
			$header_data['title'] = $header_parameter['title'];
		} else {
			$header_data['title'] = lang('Text.text_openmvm', array(), 'en-US');
		}

		if (!empty($header_parameter['meta_description'])) {
			$header_data['meta_description'] = $header_parameter['meta_description'];
		} else {
			$header_data['meta_description'] = '';
		}

		if (!empty($header_parameter['meta_keywords'])) {
			$header_data['meta_keywords'] = $header_parameter['meta_keywords'];
		} else {
			$header_data['meta_keywords'] = '';
		}

		if (!empty($header_parameter['front_locale'])) {
			$header_data['front_locale'] = $header_parameter['front_locale'];
		} else {
			$header_data['front_locale'] = 'en-US';
		}

		if (!empty($header_parameter['styles'])) {
			$header_data['styles'] = array_unique($header_parameter['styles']);
		} else {
			$header_data['styles'] = array();
		}

		if (!empty($header_parameter['scripts'])) {
			$header_data['scripts'] = array_unique($header_parameter['scripts']);
		} else {
			$header_data['scripts'] = array();
		}

		if (!empty($header_parameter['breadcrumbs'])) {
			$header_data['breadcrumbs'] = $header_parameter['breadcrumbs'];
		} else {
			$header_data['breadcrumbs'] = array();
		}

		$header_data['favicon'] = base_url('assets/files/favicon.png');

		// Define Models

		// Set CSRF Token session
		$this->session->set('front_csrf_token' . $this->session->front_session_id, csrf_hash());

		$header_data['front_csrf_token'] = $this->session->get('front_csrf_token' . $this->session->front_session_id);

		return view('header', $header_data);
	}

	//--------------------------------------------------------------------

}
