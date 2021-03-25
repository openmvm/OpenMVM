<?php

namespace Modules\OpenMVM\User\Controllers\FrontEnd;

class Logout extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->user = new \App\Libraries\User;

		$this->user->logout();
	}

	public function index()
	{
		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;

		// Data Text
		$data['heading_title'] = lang('Heading.heading_logout', array(), $this->language->getBackEndLocale());

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_logout', array(), $this->language->getFrontEndLocale()),
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'User\logout', $data);
	}
}
