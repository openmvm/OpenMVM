<?php namespace App\Controllers;

class Footer extends BaseController
{
	public function __construct()
	{
		// Libraries
		$this->session = \Config\Services::session();
		// Helper
		helper(['form', 'date', 'filesystem']);
	}

	public function index($footer_parameter)
	{
		$footer_data = array();

		if (!empty($footer_parameter['front_locale'])) {
			$footer_data['front_locale'] = $footer_parameter['front_locale'];
		} else {
			$footer_data['front_locale'] = 'en-US';
		}

		// Define Models

		// Data
		$footer_data['now'] = now();

		return view('footer', $footer_data);
	}

	//--------------------------------------------------------------------

}
