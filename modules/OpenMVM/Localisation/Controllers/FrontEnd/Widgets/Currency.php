<?php

namespace Modules\OpenMVM\Localisation\Controllers\FrontEnd\Widgets;

class Currency extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->uri = new \CodeIgniter\HTTP\URI(current_url());
		$this->language = new \App\Libraries\Language;
		$this->template = new \App\Libraries\Template;
		$this->user = new \App\Libraries\User;
		$this->auth = new \App\Libraries\Auth;
		$this->setting = new \App\Libraries\Setting;
		$this->image = new \App\Libraries\Image;
		// Load Model
		$this->currencyModel = new \Modules\OpenMVM\Localisation\Models\CurrencyModel();
	}

	public function index($widget_parameter = array())
	{
		$widget_currency_data = array();

		// Data Libraries
		$widget_currency_data['lang'] = $this->language;

		// Get currencies
		$widget_currency_data['currencies'] = $this->currencyModel->getCurrencies();

		// Get current currency code
		if ($this->session->has('frontend_currency')) {
			$widget_currency_data['frontend_currency'] = $this->session->get('frontend_currency');
		} else {
			$widget_currency_data['frontend_currency'] = $this->setting->get('setting', 'setting_frontend_currency');
		}

		// Data link
		$widget_currency_data['action'] = base_url('/localisation/widget/currency/set_currency');

	  if (!empty($_SERVER['QUERY_STRING'])) {
	    $query_string = '?' . $_SERVER['QUERY_STRING'];
	  } else {
	    $query_string = '';
	  }

	  $widget_currency_data['redirect'] = base_url(uri_string()) . $query_string;

		// Return view
		return $this->template->render('FrontendThemes', 'Localisation\Widgets\currency', $widget_currency_data);
	}

	public function setCurrency()
	{
		if (!empty($this->request->getPost('frontend_currency'))) {
			$this->session->set('frontend_currency', $this->request->getPost('frontend_currency'));
		}
		
		if (!empty($this->request->getPost('redirect'))) {
			return redirect()->to($this->request->getPost('redirect'));
		} else {
			return redirect()->to(base_url());
		}
		
	}
}
