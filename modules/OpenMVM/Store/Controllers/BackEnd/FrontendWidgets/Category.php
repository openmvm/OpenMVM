<?php

namespace Modules\OpenMVM\Store\Controllers\BackEnd\FrontendWidgets;

class Category extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->settingModel = new \Modules\OpenMVM\Setting\Models\SettingModel;
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel;
		$this->widgetModel = new \Modules\OpenMVM\Theme\Models\WidgetModel;
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/frontend_widgets');

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

    $data['action'] = base_url($_SERVER['app.adminDir'] . '/frontend_widget/edit/OpenMVM/Store/category/' . $this->request->uri->getSegment(7) . '/' . $this->administrator->getToken());

		// Form Validation
		if ($this->request->getPost()) {
			$validate = $this->validate([
				'name' => ['label' => lang('Entry.entry_name', array(),  $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getBackEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Store/Controllers/BackEnd/FrontendWidgets/Category')) {
	      // Query
	      $query = $this->widgetModel->editWidget($this->uri->getSegment($this->uri->getTotalSegments() - 1), $this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_widget_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_widget_edit', array(), $this->language->getBackEndLocale()));
	      }
	    } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
	    }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/frontend_widgets/' . $this->administrator->getToken()));
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
			'text' => lang('Heading.heading_frontend_widgets', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/frontend_widgets/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_category', array(), $this->language->getBackEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_category', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_category_lead', array(), $this->language->getBackEndLocale());

		// Data Form
		$widget_info = $this->widgetModel->getWidget($this->request->uri->getSegment(7));

		// General
		if($this->request->getPost('name')) {
			$data['name'] = $this->request->getPost('name');
		} elseif ($widget_info) {
			$setting = json_decode($widget_info['setting'], true);

			$data['name'] = $setting['name'];
		} else {
			$data['name'] = '';
		}

		if($this->request->getPost('orientation')) {
			$data['orientation'] = $this->request->getPost('orientation');
		} elseif ($widget_info) {
			$setting = json_decode($widget_info['setting'], true);

			$data['orientation'] = $setting['orientation'];
		} else {
			$data['orientation'] = '';
		}

		if($this->request->getPost('status')) {
			$data['status'] = $this->request->getPost('status');
		} elseif ($widget_info) {
			$setting = json_decode($widget_info['setting'], true);

			$data['status'] = $setting['status'];
		} else {
			$data['status'] = 1;
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_category', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Store/Controllers/BackEnd/FrontendWidgets/Category')) {
			echo $this->template->render('BackendThemes', 'Store\FrontendWidgets\category', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
