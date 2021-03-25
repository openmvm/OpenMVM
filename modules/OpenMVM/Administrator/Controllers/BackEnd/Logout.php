<?php

namespace Modules\OpenMVM\Administrator\Controllers\BackEnd;

class Logout extends \App\Controllers\BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		$this->administrator->logout();

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;

		// Data Text
		$data['heading_title'] = lang('Heading.heading_administrator_logout', array(), $this->language->getBackEndLocale());

		// Echo view
		echo $this->template->render('BackendThemes', 'Administrator\logout', $data);
	}

}
