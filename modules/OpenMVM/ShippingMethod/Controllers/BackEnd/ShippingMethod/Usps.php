<?php

namespace Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod;

class Usps extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Models
		$this->settingModel = new \Modules\OpenMVM\Setting\Models\SettingModel;
		$this->languageModel = new \Modules\OpenMVM\Localisation\Models\LanguageModel;
		$this->orderStatusModel = new \Modules\OpenMVM\Localisation\Models\OrderStatusModel;
		$this->geoZoneModel = new \Modules\OpenMVM\Localisation\Models\GeoZoneModel();
		$this->weightClassModel = new \Modules\OpenMVM\Localisation\Models\WeightClassModel();
		$this->lengthClassModel = new \Modules\OpenMVM\Localisation\Models\LengthClassModel();
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
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/shipping_methods/OpenMVM/usps/edit/' . $this->administrator->getToken());

		// Form
		if ($this->request->getMethod() === 'post') {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/ShippingMethod/Controllers/BackEnd/ShippingMethod/Usps')) {
	      // Query
	      $query = $this->settingModel->editSettings('shipping_usps', $this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_usps_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_usps_edit', array(), $this->language->getBackEndLocale()));
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
			'text' => lang('Heading.heading_usps', array(), $this->language->getBackEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_usps', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_usps_lead', array(), $this->language->getBackEndLocale());

		// Data Form
		// General
		if ($this->request->getPost('shipping_usps_user_id')) {
			$data['shipping_usps_user_id'] = $this->request->getPost('shipping_usps_user_id');
		} else {
			$data['shipping_usps_user_id'] = $this->setting->get('shipping_usps', 'shipping_usps_user_id');
		}

		// Domestic Services
		$data['domestic_services'] = array();

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_00', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_00'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_01', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_01'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_02', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_02'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_03', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_03'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_1', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_1'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_2', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_2'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_3', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_3'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_4', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_4'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_5', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_5'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_6', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_6'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_7', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_7'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_12', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_12'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_13', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_13'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_16', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_16'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_17', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_17'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_18', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_18'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_19', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_19'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_22', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_22'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_23', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_23'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_25', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_25'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_27', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_27'
		);

		$domestic_services[] = array(
			'text'  => lang('Text.text_usps_domestic_28', array(), $this->language->getBackEndLocale()),
			'value' => 'domestic_28'
		);

		foreach ($domestic_services as $domestic_service) {
			if ($this->request->getPost('shipping_usps_' . $domestic_service['value'])) {
				$data['shipping_usps_' . $domestic_service['value']] = $this->request->getPost('shipping_usps_' . $domestic_service['value']);
			} else {
				$data['shipping_usps_' . $domestic_service['value']] = $this->setting->get('shipping_usps', 'shipping_usps_' . $domestic_service['value']);
			}
		}

		$data['domestic_services'] = $domestic_services;

		// International Services
		$data['international_services'] = array();

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_1', array(), $this->language->getBackEndLocale()),
			'value' => 'international_1'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_2', array(), $this->language->getBackEndLocale()),
			'value' => 'international_2'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_4', array(), $this->language->getBackEndLocale()),
			'value' => 'international_4'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_5', array(), $this->language->getBackEndLocale()),
			'value' => 'international_5'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_6', array(), $this->language->getBackEndLocale()),
			'value' => 'international_6'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_7', array(), $this->language->getBackEndLocale()),
			'value' => 'international_7'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_8', array(), $this->language->getBackEndLocale()),
			'value' => 'international_8'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_9', array(), $this->language->getBackEndLocale()),
			'value' => 'international_9'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_10', array(), $this->language->getBackEndLocale()),
			'value' => 'international_10'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_11', array(), $this->language->getBackEndLocale()),
			'value' => 'international_11'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_12', array(), $this->language->getBackEndLocale()),
			'value' => 'international_12'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_13', array(), $this->language->getBackEndLocale()),
			'value' => 'international_13'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_14', array(), $this->language->getBackEndLocale()),
			'value' => 'international_14'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_15', array(), $this->language->getBackEndLocale()),
			'value' => 'international_15'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_16', array(), $this->language->getBackEndLocale()),
			'value' => 'international_16'
		);

		$international_services[] = array(
			'text'  => lang('Text.text_usps_international_21', array(), $this->language->getBackEndLocale()),
			'value' => 'international_21'
		);

		foreach ($international_services as $international_service) {
			if ($this->request->getPost('shipping_usps_' . $international_service['value'])) {
				$data['shipping_usps_' . $international_service['value']] = $this->request->getPost('shipping_usps_' . $international_service['value']);
			} else {
				$data['shipping_usps_' . $international_service['value']] = $this->setting->get('shipping_usps', 'shipping_usps_' . $international_service['value']);
			}
		}

		$data['international_services'] = $international_services;

		if ($this->request->getPost('shipping_usps_display_delivery_time')) {
			$data['shipping_usps_display_delivery_time'] = $this->request->getPost('shipping_usps_display_delivery_time');
		} else {
			$data['shipping_usps_display_delivery_time'] = $this->setting->get('shipping_usps', 'shipping_usps_display_delivery_time');
		}

		if ($this->request->getPost('shipping_usps_display_delivery_weight')) {
			$data['shipping_usps_display_delivery_weight'] = $this->request->getPost('shipping_usps_display_delivery_weight');
		} else {
			$data['shipping_usps_display_delivery_weight'] = $this->setting->get('shipping_usps', 'shipping_usps_display_delivery_weight');
		}

		if ($this->request->getPost('shipping_usps_weight_class_id')) {
			$data['shipping_usps_weight_class_id'] = $this->request->getPost('shipping_usps_weight_class_id');
		} else {
			$data['shipping_usps_weight_class_id'] = $this->setting->get('shipping_usps', 'shipping_usps_weight_class_id');
		}

		$data['weight_classes'] = $this->weightClassModel->getWeightClasses(array(), $this->language->getBackEndId());

		if ($this->request->getPost('shipping_usps_length_class_id')) {
			$data['shipping_usps_length_class_id'] = $this->request->getPost('shipping_usps_length_class_id');
		} else {
			$data['shipping_usps_length_class_id'] = $this->setting->get('shipping_usps', 'shipping_usps_length_class_id');
		}

		$data['length_classes'] = $this->lengthClassModel->getLengthClasses(array(), $this->language->getBackEndId());

		if ($this->request->getPost('shipping_usps_origin_geo_zone_id')) {
			$data['shipping_usps_origin_geo_zone_id'] = $this->request->getPost('shipping_usps_origin_geo_zone_id');
		} else {
			$data['shipping_usps_origin_geo_zone_id'] = $this->setting->get('shipping_usps', 'shipping_usps_origin_geo_zone_id');
		}

		if ($this->request->getPost('shipping_usps_destination_geo_zone_id')) {
			$data['shipping_usps_destination_geo_zone_id'] = $this->request->getPost('shipping_usps_destination_geo_zone_id');
		} else {
			$data['shipping_usps_destination_geo_zone_id'] = $this->setting->get('shipping_usps', 'shipping_usps_destination_geo_zone_id');
		}

		$data['geo_zones'] = $this->geoZoneModel->getGeoZones(array(), $this->language->getBackEndId());

		if ($this->request->getPost('shipping_usps_sort_order')) {
			$data['shipping_usps_sort_order'] = $this->request->getPost('shipping_usps_sort_order');
		} else {
			$data['shipping_usps_sort_order'] = $this->setting->get('shipping_usps', 'shipping_usps_sort_order');
		}

		if ($this->request->getPost('shipping_usps_status')) {
			$data['shipping_usps_status'] = $this->request->getPost('shipping_usps_status');
		} else {
			$data['shipping_usps_status'] = $this->setting->get('shipping_usps', 'shipping_usps_status');
		}

		if ($this->request->getPost('shipping_usps_debug')) {
			$data['shipping_usps_debug'] = $this->request->getPost('shipping_usps_debug');
		} else {
			$data['shipping_usps_debug'] = $this->setting->get('shipping_usps', 'shipping_usps_debug');
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_usps', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/ShippingMethod/Controllers/BackEnd/ShippingMethod/Usps')) {
			echo $this->template->render('BackendThemes', 'ShippingMethod\ShippingMethod\usps', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
