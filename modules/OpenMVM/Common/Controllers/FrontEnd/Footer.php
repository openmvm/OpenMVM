<?php

namespace Modules\OpenMVM\Common\Controllers\FrontEnd;

class Footer extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		$this->template = new \App\Libraries\Template;
	}

	public function index($footer_parameter = array())
	{
		$footer_data = array();

		// Data Libraries
		$footer_data['lang'] = $this->language;

		// Data Text
		$footer_data['website_name'] = $this->setting->get('setting', 'setting_website_name');

		// Return view
		return $this->template->render('FrontendThemes', 'Common\footer', $footer_data);
	}
}
