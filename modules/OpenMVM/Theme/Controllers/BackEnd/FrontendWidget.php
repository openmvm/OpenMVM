<?php

namespace Modules\OpenMVM\Theme\Controllers\BackEnd;

class FrontendWidget extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->widgetModel = new \Modules\OpenMVM\Theme\Models\WidgetModel();
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

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_dashboard', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/dashboard/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_frontend_widgets', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/frontend_widgets/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_frontend_widgets', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_frontend_widgets_lead', array(), $this->language->getBackEndLocale());

		// Return
		return $this->getList($data);
	}

	public function install()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/frontend_widgets');

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;

  	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Theme/Controllers/BackEnd/FrontendWidget')) {
      // Query
    	$query = $this->widgetModel->install('frontend', $this->uri->getSegment($this->uri->getTotalSegments() - 3), $this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments() - 1));
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_frontend_widget_install', array(), $this->language->getBackEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_frontend_widget_install', array(), $this->language->getBackEndLocale()));
      }
    } else {
      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    }

		// Return
		return redirect()->to(base_url($_SERVER['app.adminDir'] . '/frontend_widgets/' . $this->administrator->getToken()));
	}

	public function uninstall()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/frontend_widgets');

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;

  	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Theme/Controllers/BackEnd/FrontendWidget')) {
      // Query
    	$query = $this->widgetModel->uninstall('frontend', $this->uri->getSegment($this->uri->getTotalSegments() - 3), $this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments() - 1));
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_frontend_widget_uninstall', array(), $this->language->getBackEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_frontend_widget_uninstall', array(), $this->language->getBackEndLocale()));
      }
    } else {
      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    }

		// Return
		return redirect()->to(base_url($_SERVER['app.adminDir'] . '/frontend_widgets/' . $this->administrator->getToken()));
	}

	public function delete()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/frontend_widgets');

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;

  	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Theme/Controllers/BackEnd/FrontendWidget')) {
      // Query
    	$query = $this->widgetModel->deleteWidget($this->request->uri->getSegment(4));
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_frontend_widget_delete', array(), $this->language->getBackEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_frontend_widget_delete', array(), $this->language->getBackEndLocale()));
      }
    } else {
      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    }

		// Return
		return redirect()->to(base_url($_SERVER['app.adminDir'] . '/frontend_widgets/' . $this->administrator->getToken()));
	}

	public function add()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/frontend_widgets');

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;

  	if ($this->administrator->hasPermission('modify','modules/OpenMVM/Theme/Controllers/BackEnd/FrontendWidget')) {
      // Query
    	$query = $this->widgetModel->addWidget('frontend', $this->uri->getSegment($this->uri->getTotalSegments() - 3), $this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments() - 1));
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_frontend_widget_add', array(), $this->language->getBackEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_frontend_widget_add', array(), $this->language->getBackEndLocale()));
      }
    } else {
      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    }

		// Return
		return redirect()->to(base_url($_SERVER['app.adminDir'] . '/frontend_widgets/' . $this->administrator->getToken()));
	}

	public function getList($data = array())
	{
		// Get installed frontend widgets
		$installed_frontend_widgets = $this->widgetModel->getInstalled('frontend');

		foreach ($installed_frontend_widgets as $installed_frontend_widget) {
			if (!$this->widget->checkWidgets('frontend', $installed_frontend_widget['provider'], $installed_frontend_widget['dir'], $installed_frontend_widget['code'])) {
				$this->widgetModel->uninstall('frontend', $installed_frontend_widget['provider'], $installed_frontend_widget['dir'], $installed_frontend_widget['code']);
			}
		}

		$data['frontend_widgets'] = array();
		
		// Compatibility code for old extension folders
		$files = $this->widget->getWidgets('frontend');

		if ($files) {
			foreach ($files as $file) {
	      // Check if front widget is installed
	      $installed = $this->widget->isInstalled('frontend', $file['provider'], $file['dir'], $file['code']);

	      // Get Frontend Widget Items
	      if ($installed) {
	      	$frontend_widget_item_data = array();

	        $frontend_widgets = $this->widgetModel->getWidgets('frontend', $file['provider'], $file['dir'], $file['code']);

	        foreach ($frontend_widgets as $frontend_widget) {
	          if (empty($frontend_widget['name'])) {
	            $frontend_widget_name = lang('Text.text_unnamed_widget', array(), $this->language->getBackEndLocale());
	          } else {
	            $frontend_widget_name = $frontend_widget['name'];
	          }

	          $frontend_widget_item_data[] = array(
	            'widget_id' => $frontend_widget['widget_id'],
	            'name'      => $frontend_widget_name,
	            'edit'      => base_url($_SERVER['app.adminDir'] . '/frontend_widget/edit/'. $file['provider']  . '/' . $file['dir'] . '/' . $file['code'] . '/' . $frontend_widget['widget_id'] . '/' . $this->administrator->getToken()),
	            'delete'    => base_url($_SERVER['app.adminDir'] . '/frontend_widgets/delete/' . $frontend_widget['widget_id'] . '/' . $this->administrator->getToken())
	          );
	        }
	      }

				$data['frontend_widgets'][] = array(
					'name'       => lang('Heading.heading_' . $file['code'], array(), $this->language->getBackEndLocale()),
					'link'       => '',
					'status'     => '',
					'sort_order' => '',
        	'frontend_widget_items' => $frontend_widget_item_data,
					'install'    => base_url($_SERVER['app.adminDir'] . '/frontend_widgets/install/' . $file['provider']  . '/' . $file['dir'] . '/' . $file['code'] . '/' . $this->administrator->getToken()),
					'uninstall'  => base_url($_SERVER['app.adminDir'] . '/frontend_widgets/uninstall/' . $file['provider']  . '/' . $file['dir'] . '/' . $file['code'] . '/' . $this->administrator->getToken()),
					'installed'  => $this->widget->isInstalled('frontend', $file['provider'], $file['dir'], $file['code']),
        	'add'        => base_url($_SERVER['app.adminDir'] . '/frontend_widgets/add/' . $file['provider']  . '/' . $file['dir'] . '/' . $file['code'] . '/' . $this->administrator->getToken()),
				);
			}
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_frontend_widgets', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/Theme/Controllers/BackEnd/FrontendWidget')) {
			echo $this->template->render('BackendThemes', 'Theme\frontend_widget_list', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
