<?php

namespace Modules\OpenMVM\FrontEndTheme\Controllers\BackEnd;

class ThemeDefault extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->settingModel = new \Modules\OpenMVM\Setting\Models\SettingModel;
		$this->layoutModel = new \Modules\OpenMVM\Theme\Models\LayoutModel();
		$this->widgetModel = new \Modules\OpenMVM\Theme\Models\WidgetModel();
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/frontend_themes/openmvm/default');

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

    $data['action'] = base_url($_SERVER['app.adminDir'] . '/frontend_theme/openmvm/default/' . $this->administrator->getToken());

		// Form Validation
		if ($this->request->getPost()) {
			$validate = $this->validate([
				'frontend_theme_openmvm_default_name' => ['label' => lang('Entry.entry_name', array(),  $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getBackEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/FrontendTheme/Controllers/BackEnd/ThemeDefault')) {
	      // Query
	      $query = $this->settingModel->editSettings('frontend_theme_openmvm_default', $this->request->getPost());
	      
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
			'text' => lang('Heading.heading_theme_default_settings', array(), $this->language->getBackEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_theme_default_settings', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_theme_default_settings_lead', array(), $this->language->getBackEndLocale());

		// Data Form
		// General
		if($this->request->getPost('frontend_theme_openmvm_default_name')) {
			$data['frontend_theme_openmvm_default_name'] = $this->request->getPost('frontend_theme_openmvm_default_name');
		} else {
			$data['frontend_theme_openmvm_default_name'] = $this->settingModel->getSettingValue('frontend_theme_openmvm_default', 'frontend_theme_openmvm_default_name');
		}

		$data['layouts'] = array();

		$layouts = $this->layoutModel->getLayouts('frontend', $filter_data);

		foreach ($layouts as $layout) {
			$data['layouts'][] = array(
				'layout_id' => $layout['layout_id'],
				'name' => $layout['name'],
			);
		}

		foreach ($layouts as $layout) {
			if ($this->request->getPost('frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id'])) {
				$data['frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']] = array_map('array_values', $this->request->getPost('frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']));
			} elseif (!empty($this->setting->get('frontend_theme_openmvm_default', 'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']))) {
				$data['frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']] = array_map('array_values', $this->setting->get('frontend_theme_openmvm_default', 'frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']));
			} else {
				$data['frontend_theme_openmvm_default_layout_widget_' . $layout['layout_id']] = array();
			}
		}

		// Get installed frontend widgets
		$installed_widgets = $this->widgetModel->getInstalled('frontend');

		foreach ($installed_widgets as $installed_widget) {
			if (!$this->widget->checkWidgets('frontend', $installed_widget['provider'], $installed_widget['dir'], $installed_widget['code'])) {
				$this->widgetModel->uninstall('frontend', $installed_widget['provider'], $installed_widget['dir'], $installed_widget['code']);
			}
		}

		$data['widgets'] = array();
		
		// Compatibility code for old extension folders
		$files = $this->widget->getWidgets('frontend');

		if ($files) {
			foreach ($files as $file) {
	      // Check if front widget is installed
	      $installed = $this->widget->isInstalled('frontend', $file['provider'], $file['dir'], $file['code']);

	      // Get Frontend Widget Items
	      $widget_item_data = array();

	      if ($installed) {
	        $widgets = $this->widgetModel->getWidgets('frontend', $file['provider'], $file['dir'], $file['code']);

	        foreach ($widgets as $widget) {
	          if (empty($widget['name'])) {
	            $widget_name = lang('Text.text_unnamed_widget', array(), $this->language->getBackEndLocale());
	          } else {
	            $widget_name = $widget['name'];
	          }

	          $widget_item_data[] = array(
	            'widget_id' => $widget['widget_id'],
	            'name'      => $widget_name,
	          );
	        }
	      }

				$data['widgets'][] = array(
					'name' => lang('Heading.heading_' . $file['code'], array(), $this->language->getBackEndLocale()),
        	'widget_items' => $widget_item_data,
				);
			}
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_theme_default_settings', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/FrontendTheme/Controllers/BackEnd/ThemeDefault')) {
			echo $this->template->render('BackendThemes', 'FrontendTheme\OpenMVM\default', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
