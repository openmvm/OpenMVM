<?php namespace App\Controllers;

class Menu extends BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->uri = new \CodeIgniter\HTTP\URI(current_url());
		// Load Models
	}

	public function index($menu_parameter)
	{
		$menu_data = array();

		if (!empty($menu_parameter['front_locale'])) {
			$menu_data['front_locale'] = $menu_parameter['front_locale'];
		} else {
			$menu_data['front_locale'] = 'en-US';
		}

		$menu_data['current_page'] = $this->uri->getSegment($this->uri->getTotalSegments());

		// Define Models

		return view('menu', $menu_data);
	}

	//--------------------------------------------------------------------

}
