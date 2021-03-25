<?php

namespace Modules\OpenMVM\Common\Controllers\BackEnd;

class Header extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->language = new \App\Libraries\Language;
		$this->template = new \App\Libraries\Template;
		$this->administrator = new \App\Libraries\Administrator;
		$this->auth = new \App\Libraries\Auth;
	}

	public function index($header_parameter = array())
	{
		$header_data = array();

		// Data Scripts & Styles
		if (!empty($header_parameter['scripts'])) {
			$header_data['scripts'] = array_unique($header_parameter['scripts']);
		} else {
			$header_data['scripts'] = array();
		}

		if (!empty($header_parameter['styles'])) {
			$header_data['styles'] = array_unique($header_parameter['styles']);
		} else {
			$header_data['styles'] = array();
		}

		// Data Libraries
		$header_data['lang'] = $this->language;
		$header_data['administrator'] = $this->administrator;
		$header_data['auth'] = $this->auth;

		// Data Text
		$header_data['title'] = $header_parameter['title'];

		$header_data['administrator_token'] = $this->administrator->getToken();

		// Return view
		return $this->template->render('BackendThemes', 'Common\header', $header_data);
	}
}
