<?php

namespace Modules\OpenMVM\ShippingMethod\Controllers\BackEnd;

class ShippingMethod extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->shippingMethodModel = new \Modules\OpenMVM\ShippingMethod\Models\ShippingMethodModel();
	}

	public function index()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/shipping_methods');

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
			'text' => lang('Heading.heading_shipping_methods', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/shipping_methods/' . $this->administrator->getToken()),
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_shipping_methods', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_shipping_methods_lead', array(), $this->language->getBackEndLocale());

		// Return
		return $this->getList($data);
	}

	public function install()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/shipping_methods');

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;

  	if ($this->administrator->hasPermission('modify','modules/OpenMVM/ShippingMethod/Controllers/BackEnd/ShippingMethod')) {
      // Query
    	$query = $this->shippingMethodModel->install($this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments() - 1));
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_shipping_method_install', array(), $this->language->getBackEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_shipping_method_install', array(), $this->language->getBackEndLocale()));
      }
    } else {
      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    }

		// Return
		return redirect()->to(base_url($_SERVER['app.adminDir'] . '/shipping_methods/' . $this->administrator->getToken()));
	}

	public function uninstall()
	{
		// Administrator must logged in!
		if (!$this->administrator->isLogged() || !$this->auth->validateAdministratorToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('administrator_redirect' . $this->session->administrator_session_id, $_SERVER['app.adminDir'] . '/shipping_methods');

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/login'));
		}

		$data = array();

		// Data Libraries
		$data['lang'] = $this->language;

  	if ($this->administrator->hasPermission('modify','modules/OpenMVM/ShippingMethod/Controllers/BackEnd/ShippingMethod')) {
      // Query
    	$query = $this->shippingMethodModel->uninstall($this->uri->getSegment($this->uri->getTotalSegments() - 2), $this->uri->getSegment($this->uri->getTotalSegments() - 1));
      
      if ($query) {
      	$this->session->set('success', lang('Success.success_shipping_method_uninstall', array(), $this->language->getBackEndLocale()));
      } else {
      	$this->session->set('error', lang('Error.error_shipping_method_uninstall', array(), $this->language->getBackEndLocale()));
      }
    } else {
      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
    }

		// Return
		return redirect()->to(base_url($_SERVER['app.adminDir'] . '/shipping_methods/' . $this->administrator->getToken()));
	}

	public function getList($data = array())
	{
		// Get installed shipping methods
		$installed_shipping_methods = $this->shippingMethodModel->getInstalled();

		foreach ($installed_shipping_methods as $installed_shipping_method) {
			if (!$this->shipping_method->check($installed_shipping_method['provider'], $installed_shipping_method['code'])) {
				$this->shippingMethodModel->uninstall($installed_shipping_method['provider'], $installed_shipping_method['code']);
			}
		}

		$data['shipping_methods'] = array();
		
		// Compatibility code for old extension folders
		$files = $this->shipping_method->list();

		if ($files) {
			foreach ($files as $file) {
				$data['shipping_methods'][] = array(
					'name'       => lang('Heading.heading_' . $file['code'], array(), $this->language->getBackEndLocale()),
					'link'       => '',
					'status'     => '',
					'sort_order' => '',
					'install'    => base_url($_SERVER['app.adminDir'] . '/shipping_methods/install/' . $file['provider']  . '/' . $file['code'] . '/' . $this->administrator->getToken()),
					'uninstall'  => base_url($_SERVER['app.adminDir'] . '/shipping_methods/uninstall/' . $file['provider']  . '/' . $file['code'] . '/' . $this->administrator->getToken()),
					'installed'  => $this->shipping_method->isInstalled($file['provider'], $file['code']),
					'edit'       => base_url($_SERVER['app.adminDir'] . '/shipping_methods/' . $file['provider']  . '/' . $file['code'] . '/edit/' . $this->administrator->getToken()),
				);
			}
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_shipping_methods', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/ShippingMethod/Controllers/BackEnd/ShippingMethod')) {
			echo $this->template->render('BackendThemes', 'ShippingMethod\shipping_method_list', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
