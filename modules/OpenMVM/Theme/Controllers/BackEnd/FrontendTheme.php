<?php

namespace Modules\OpenMVM\Theme\Controllers\BackEnd;

class FrontendTheme extends \App\Controllers\BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/frontend_themes');

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;
		$data['validation'] = $this->validation;

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

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_dashboard', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/dashboard/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_frontend_themes', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/frontend_themes/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_frontend_themes', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_frontend_themes_lead', array(), $this->language->getBackEndLocale());

		// Return
		return $this->getList($data);
	}

	public function getList($data = array())
	{
		// Get frontend theme settings
		$data['theme_settings'] = array();

		$theme_settings = $this->frontend_theme->getThemeSettings();

		foreach ($theme_settings as $theme_setting) {
			$data['theme_settings'][] = array(
				'name' => $theme_setting['name'],
				'edit' => base_url($_SERVER['app.adminDir'] . $theme_setting['uri_string'] . '/' . $this->administrator->getToken()),
			);
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_frontend_themes', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Theme/Controllers/BackEnd/FrontendTheme')) {
			echo $this->template->render('BackendThemes', 'Theme\frontend_theme_list', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
