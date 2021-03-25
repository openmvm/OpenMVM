<?php

namespace Modules\OpenMVM\Localisation\Controllers\FrontEnd\Widgets;

class Language extends \App\Controllers\BaseController
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
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel();
	}

	public function index($widget_parameter = array())
	{
		$widget_language_data = array();

		// Data Libraries
		$widget_language_data['lang'] = $this->language;

		// Get languages
		$widget_language_data['languages'] = $this->languageModel->getLanguages();

		// Get current language code
		if ($this->session->has('frontend_language')) {
			$widget_language_data['frontend_language'] = $this->session->get('frontend_language');
		} else {
			$widget_language_data['frontend_language'] = $this->setting->get('setting', 'setting_frontend_language');
		}

		// Data link
		$widget_language_data['action'] = base_url('/localisation/widget/language/set_language');

	  if (!empty($_SERVER['QUERY_STRING'])) {
	    $query_string = '?' . $_SERVER['QUERY_STRING'];
	  } else {
	    $query_string = '';
	  }

	  $widget_language_data['redirect'] = base_url(uri_string()) . $query_string;

		// Return view
		return $this->template->render('FrontendThemes', 'Localisation\Widgets\language', $widget_language_data);
	}

	public function setLanguage()
	{
		if (!empty($this->request->getPost('frontend_language'))) {
			$this->session->set('frontend_language', $this->request->getPost('frontend_language'));
		}
		
		if (!empty($this->request->getPost('redirect'))) {
			return redirect()->to($this->request->getPost('redirect'));
		} else {
			return redirect()->to(base_url());
		}
		
	}
}
