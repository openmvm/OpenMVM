<?php

namespace Modules\OpenMVM\Common\Controllers\FrontEnd;

class Home extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Database
		$this->db = \Config\Database::connect();
	}

	public function index()
	{
		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['widget'] = $this->widget;
		$data['template'] = $this->template;

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

    $data['debug'] = null;

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'Common\home', $data);
	}
}
