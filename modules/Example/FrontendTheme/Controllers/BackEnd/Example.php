<?php

namespace Modules\Example\FrontendTheme\Controllers\BackEnd;

class Example extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->settingModel = new \Modules\OpenMVM\Setting\Models\SettingModel;
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/frontend_theme/example/example');

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

    $data['action'] = base_url($_SERVER['app.adminDir'] . '/frontend_theme/example/example/' . $this->administrator->getToken());

		// Form Validation
		if ($this->request->getPost()) {
			$validate = $this->validate([
				'frontend_theme_example_example_name' => ['label' => lang('Entry.entry_name', array(),  $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getBackEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/Example/FrontendTheme/Controllers/BackEnd/Example')) {
	      // Query
	      $query = $this->settingModel->editSettings('frontend_theme_example_example', $this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_settings_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_settings_edit', array(), $this->language->getBackEndLocale()));
	      }
	    } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
	    }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/frontend_themes/' . $this->administrator->getToken()));
		}

		// Return
		return $this->getForm($data);
	}

	public function getForm($data = array())
	{
		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_dashboard', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/dashboard/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_frontend_themes', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/frontend_themes/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_theme_example_settings', array(), $this->language->getBackEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_theme_example_settings', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_theme_example_settings_lead', array(), $this->language->getBackEndLocale());

		// Data Form
		// General
		if($this->request->getPost('frontend_theme_example_example_name')) {
			$data['frontend_theme_example_example_name'] = $this->request->getPost('frontend_theme_example_example_name');
		} else {
			$data['frontend_theme_example_example_name'] = $this->settingModel->getSettingValue('frontend_theme_example_example', 'frontend_theme_example_example_name');
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_theme_example_settings', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/Example/FrontendTheme/Controllers/BackEnd/Example')) {
			echo $this->template->render('BackendThemes', 'FrontendTheme\Example\example', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
