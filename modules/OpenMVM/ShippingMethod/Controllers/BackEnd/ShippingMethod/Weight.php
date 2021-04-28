<?php

namespace Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod;

class Weight extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->settingModel = new \Modules\OpenMVM\Setting\Models\SettingModel;
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel;
		$this->orderStatusModel = new \Modules\OpenMVM\Localisation\Models\OrderStatusModel;
		$this->geoZoneModel = new \Modules\OpenMVM\Localisation\Models\GeoZoneModel();
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

		// Data Link
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/shipping_methods/OpenMVM/weight/edit/' . $this->administrator->getToken());

		// Form Validation
		if ($this->request->getMethod() === 'post') {
			$validate = $this->validate([
				'shipping_weight_rate' => ['label' => lang('Entry.entry_rate', array(),  $this->language->getBackEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(),  $this->language->getBackEndLocale())]],
			]);

			// Check if errors exist
			if (!empty($this->validation->getErrors())) {
				$data['error'] = lang('Error.error_form', array(), $this->language->getBackEndLocale());

				$this->session->remove('error');
			}
		}
		
		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/ShippingMethod/Controllers/BackEnd/ShippingMethod/Weight')) {
	      // Query
	      $query = $this->settingModel->editSettings('shipping_weight', $this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_weight_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_weight_edit', array(), $this->language->getBackEndLocale()));
	      }
	    } else {
	      $this->session->set('error', lang('Error.error_permission_modify', array(), $this->language->getBackEndLocale()));
	    }

			return redirect()->to(base_url($_SERVER['app.adminDir'] . '/shipping_methods/' . $this->administrator->getToken()));
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
			'text' => lang('Heading.heading_shipping_methods', array(), $this->language->getBackEndLocale()),
			'href' => base_url($_SERVER['app.adminDir'] . '/shipping_methods/' . $this->administrator->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_weight', array(), $this->language->getBackEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_weight', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_weight_lead', array(), $this->language->getBackEndLocale());

		// Data Form
		// General
		if ($this->request->getPost('shipping_weight_rate')) {
			$data['shipping_weight_rate'] = $this->request->getPost('shipping_weight_rate');
		} else {
			$data['shipping_weight_rate'] = $this->setting->get('shipping_weight', 'shipping_weight_rate');
		}

		if ($this->request->getPost('shipping_weight_origin_geo_zone_id')) {
			$data['shipping_weight_origin_geo_zone_id'] = $this->request->getPost('shipping_weight_origin_geo_zone_id');
		} else {
			$data['shipping_weight_origin_geo_zone_id'] = $this->setting->get('shipping_weight', 'shipping_weight_origin_geo_zone_id');
		}

		if ($this->request->getPost('shipping_weight_destination_geo_zone_id')) {
			$data['shipping_weight_destination_geo_zone_id'] = $this->request->getPost('shipping_weight_destination_geo_zone_id');
		} else {
			$data['shipping_weight_destination_geo_zone_id'] = $this->setting->get('shipping_weight', 'shipping_weight_destination_geo_zone_id');
		}

		$data['geo_zones'] = $this->geoZoneModel->getGeoZones(array(), $this->language->getBackEndId());

		if ($this->request->getPost('shipping_weight_status')) {
			$data['shipping_weight_status'] = $this->request->getPost('shipping_weight_status');
		} else {
			$data['shipping_weight_status'] = $this->setting->get('shipping_weight', 'shipping_weight_status');
		}

		if ($this->request->getPost('shipping_weight_sort_order')) {
			$data['shipping_weight_sort_order'] = $this->request->getPost('shipping_weight_sort_order');
		} else {
			$data['shipping_weight_sort_order'] = $this->setting->get('shipping_weight', 'shipping_weight_sort_order');
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_weight', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/ShippingMethod/Controllers/BackEnd/ShippingMethod/Weight')) {
			echo $this->template->render('BackendThemes', 'ShippingMethod\ShippingMethod\weight', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
