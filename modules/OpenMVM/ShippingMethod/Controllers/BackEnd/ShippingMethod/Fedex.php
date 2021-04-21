<?php

namespace Modules\OpenMVM\ShippingMethod\Controllers\BackEnd\ShippingMethod;

class Fedex extends \App\Controllers\BaseController
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
		$data['action'] = base_url($_SERVER['app.adminDir'] . '/shipping_methods/OpenMVM/fedex/edit/' . $this->administrator->getToken());

		// Form
		if ($this->request->getMethod() === 'post') {
    	if ($this->administrator->hasPermission('modify','modules/OpenMVM/ShippingMethod/Controllers/BackEnd/ShippingMethod/Fedex')) {
	      // Query
	      $query = $this->settingModel->editSettings('shipping_fedex', $this->request->getPost());
	      
	      if ($query) {
	      	$this->session->set('success', lang('Success.success_fedex_edit', array(), $this->language->getBackEndLocale()));
	      } else {
	      	$this->session->set('error', lang('Error.error_fedex_edit', array(), $this->language->getBackEndLocale()));
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
			'text' => lang('Heading.heading_fedex', array(), $this->language->getBackEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_fedex', array(), $this->language->getBackEndLocale());
		$data['lead'] = lang('text.text_fedex_lead', array(), $this->language->getBackEndLocale());

		// Data Form
		// General
		if ($this->request->getPost('shipping_fedex_mode')) {
			$data['shipping_fedex_mode'] = $this->request->getPost('shipping_fedex_mode');
		} else {
			$data['shipping_fedex_mode'] = $this->setting->get('shipping_fedex', 'shipping_fedex_mode');
		}

		if ($this->request->getPost('shipping_fedex_url_test')) {
			$data['shipping_fedex_url_test'] = $this->request->getPost('shipping_fedex_url_test');
		} else {
			$data['shipping_fedex_url_test'] = $this->setting->get('shipping_fedex', 'shipping_fedex_url_test');
		}

		if ($this->request->getPost('shipping_fedex_url_production')) {
			$data['shipping_fedex_url_production'] = $this->request->getPost('shipping_fedex_url_production');
		} else {
			$data['shipping_fedex_url_production'] = $this->setting->get('shipping_fedex', 'shipping_fedex_url_production');
		}

		if ($this->request->getPost('shipping_fedex_key')) {
			$data['shipping_fedex_key'] = $this->request->getPost('shipping_fedex_key');
		} else {
			$data['shipping_fedex_key'] = $this->setting->get('shipping_fedex', 'shipping_fedex_key');
		}

		if ($this->request->getPost('shipping_fedex_password')) {
			$data['shipping_fedex_password'] = $this->request->getPost('shipping_fedex_password');
		} else {
			$data['shipping_fedex_password'] = $this->setting->get('shipping_fedex', 'shipping_fedex_password');
		}

		if ($this->request->getPost('shipping_fedex_account_number')) {
			$data['shipping_fedex_account_number'] = $this->request->getPost('shipping_fedex_account_number');
		} else {
			$data['shipping_fedex_account_number'] = $this->setting->get('shipping_fedex', 'shipping_fedex_account_number');
		}

		if ($this->request->getPost('shipping_fedex_meter_number')) {
			$data['shipping_fedex_meter_number'] = $this->request->getPost('shipping_fedex_meter_number');
		} else {
			$data['shipping_fedex_meter_number'] = $this->setting->get('shipping_fedex', 'shipping_fedex_meter_number');
		}

		if ($this->request->getPost('shipping_fedex_service')) {
			$data['shipping_fedex_service'] = $this->request->getPost('shipping_fedex_service');
		} elseif (!empty($this->setting->get('shipping_fedex', 'shipping_fedex_service'))) {
			$data['shipping_fedex_service'] = $this->setting->get('shipping_fedex', 'shipping_fedex_service');
		} else {
			$data['shipping_fedex_service'] = array();
		}

		$data['services'] = array();

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_europe_first_international_priority', array(), $this->language->getBackEndLocale()),
			'value' => 'EUROPE_FIRST_INTERNATIONAL_PRIORITY'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_1_day_freight', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_1_DAY_FREIGHT'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_2_day', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_2_DAY'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_2_day_am', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_2_DAY_AM'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_2_day_freight', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_2_DAY_FREIGHT'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_3_day_freight', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_3_DAY_FREIGHT'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_express_saver', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_EXPRESS_SAVER'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_first_freight', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_FIRST_FREIGHT'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_freight_economy', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_FREIGHT_ECONOMY'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_freight_priority', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_FREIGHT_PRIORITY'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_ground', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_GROUND'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_first_overnight', array(), $this->language->getBackEndLocale()),
			'value' => 'FIRST_OVERNIGHT'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_ground_home_delivery', array(), $this->language->getBackEndLocale()),
			'value' => 'GROUND_HOME_DELIVERY'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_international_economy', array(), $this->language->getBackEndLocale()),
			'value' => 'INTERNATIONAL_ECONOMY'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_international_economy_freight', array(), $this->language->getBackEndLocale()),
			'value' => 'INTERNATIONAL_ECONOMY_FREIGHT'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_international_first', array(), $this->language->getBackEndLocale()),
			'value' => 'INTERNATIONAL_FIRST'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_international_priority', array(), $this->language->getBackEndLocale()),
			'value' => 'INTERNATIONAL_PRIORITY'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_international_priority_freight', array(), $this->language->getBackEndLocale()),
			'value' => 'INTERNATIONAL_PRIORITY_FREIGHT'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_priority_overnight', array(), $this->language->getBackEndLocale()),
			'value' => 'PRIORITY_OVERNIGHT'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_smart_post', array(), $this->language->getBackEndLocale()),
			'value' => 'SMART_POST'
		);

		$data['services'][] = array(
			'text'  => lang('Text.text_fedex_standard_overnight', array(), $this->language->getBackEndLocale()),
			'value' => 'STANDARD_OVERNIGHT'
		);

		if ($this->request->getPost('shipping_fedex_dropoff_type')) {
			$data['shipping_fedex_dropoff_type'] = $this->request->getPost('shipping_fedex_dropoff_type');
		} else {
			$data['shipping_fedex_dropoff_type'] = $this->setting->get('shipping_fedex', 'shipping_fedex_dropoff_type');
		}

		$data['dropoff_types'] = array();

		$data['dropoff_types'][] = array(
			'text'  => lang('Text.text_regular_pickup', array(), $this->language->getBackEndLocale()),
			'value' => 'REGULAR_PICKUP'
		);

		$data['dropoff_types'][] = array(
			'text'  => lang('Text.text_request_courier', array(), $this->language->getBackEndLocale()),
			'value' => 'REQUEST_COURIER'
		);

		$data['dropoff_types'][] = array(
			'text'  => lang('Text.text_drop_box', array(), $this->language->getBackEndLocale()),
			'value' => 'DROP_BOX'
		);

		$data['dropoff_types'][] = array(
			'text'  => lang('Text.text_business_service_center', array(), $this->language->getBackEndLocale()),
			'value' => 'BUSINESS_SERVICE_CENTER'
		);

		$data['dropoff_types'][] = array(
			'text'  => lang('Text.text_station', array(), $this->language->getBackEndLocale()),
			'value' => 'STATION'
		);

		if ($this->request->getPost('shipping_fedex_packaging_type')) {
			$data['shipping_fedex_packaging_type'] = $this->request->getPost('shipping_fedex_packaging_type');
		} else {
			$data['shipping_fedex_packaging_type'] = $this->setting->get('shipping_fedex', 'shipping_fedex_packaging_type');
		}

		$data['packaging_types'] = array();

		$data['packaging_types'][] = array(
			'text'  => lang('Text.text_fedex_envelope', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_ENVELOPE'
		);

		$data['packaging_types'][] = array(
			'text'  => lang('Text.text_fedex_pak', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_PAK'
		);

		$data['packaging_types'][] = array(
			'text'  => lang('Text.text_fedex_box', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_BOX'
		);

		$data['packaging_types'][] = array(
			'text'  => lang('Text.text_fedex_tube', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_TUBE'
		);

		$data['packaging_types'][] = array(
			'text'  => lang('Text.text_fedex_10kg_box', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_10KG_BOX'
		);

		$data['packaging_types'][] = array(
			'text'  => lang('Text.text_fedex_25kg_box', array(), $this->language->getBackEndLocale()),
			'value' => 'FEDEX_25KG_BOX'
		);

		$data['packaging_types'][] = array(
			'text'  => lang('Text.text_your_packaging', array(), $this->language->getBackEndLocale()),
			'value' => 'YOUR_PACKAGING'
		);

		if ($this->request->getPost('shipping_fedex_rate_type')) {
			$data['shipping_fedex_rate_type'] = $this->request->getPost('shipping_fedex_rate_type');
		} else {
			$data['shipping_fedex_rate_type'] = $this->setting->get('shipping_fedex', 'shipping_fedex_rate_type');
		}

		$data['rate_types'] = array();

		$data['rate_types'][] = array(
			'text'  => lang('Text.text_list', array(), $this->language->getBackEndLocale()),
			'value' => 'LIST'
		);

		$data['rate_types'][] = array(
			'text'  => lang('Text.text_account', array(), $this->language->getBackEndLocale()),
			'value' => 'ACCOUNT'
		);

		if ($this->request->getPost('shipping_fedex_display_delivery_time')) {
			$data['shipping_fedex_display_delivery_time'] = $this->request->getPost('shipping_fedex_display_delivery_time');
		} else {
			$data['shipping_fedex_display_delivery_time'] = $this->setting->get('shipping_fedex', 'shipping_fedex_display_delivery_time');
		}

		if ($this->request->getPost('shipping_fedex_display_delivery_weight')) {
			$data['shipping_fedex_display_delivery_weight'] = $this->request->getPost('shipping_fedex_display_delivery_weight');
		} else {
			$data['shipping_fedex_display_delivery_weight'] = $this->setting->get('shipping_fedex', 'shipping_fedex_display_delivery_weight');
		}

		if ($this->request->getPost('shipping_fedex_weight_class_id')) {
			$data['shipping_fedex_weight_class_id'] = $this->request->getPost('shipping_fedex_weight_class_id');
		} else {
			$data['shipping_fedex_weight_class_id'] = $this->setting->get('shipping_fedex', 'shipping_fedex_weight_class_id');
		}

		$data['weight_classes'] = $this->weightClassModel->getWeightClasses(array(), $this->language->getBackEndId());

		if ($this->request->getPost('shipping_fedex_length_class_id')) {
			$data['shipping_fedex_length_class_id'] = $this->request->getPost('shipping_fedex_length_class_id');
		} else {
			$data['shipping_fedex_length_class_id'] = $this->setting->get('shipping_fedex', 'shipping_fedex_length_class_id');
		}

		$data['length_classes'] = $this->lengthClassModel->getLengthClasses(array(), $this->language->getBackEndId());

		if ($this->request->getPost('shipping_fedex_geo_zone_id')) {
			$data['shipping_fedex_geo_zone_id'] = $this->request->getPost('shipping_fedex_geo_zone_id');
		} else {
			$data['shipping_fedex_geo_zone_id'] = $this->setting->get('shipping_fedex', 'shipping_fedex_geo_zone_id');
		}

		$data['geo_zones'] = $this->geoZoneModel->getGeoZones(array(), $this->language->getBackEndId());

		if ($this->request->getPost('shipping_fedex_status')) {
			$data['shipping_fedex_status'] = $this->request->getPost('shipping_fedex_status');
		} else {
			$data['shipping_fedex_status'] = $this->setting->get('shipping_fedex', 'shipping_fedex_status');
		}

		if ($this->request->getPost('shipping_fedex_sort_order')) {
			$data['shipping_fedex_sort_order'] = $this->request->getPost('shipping_fedex_sort_order');
		} else {
			$data['shipping_fedex_sort_order'] = $this->setting->get('shipping_fedex', 'shipping_fedex_sort_order');
		}

		$data['administrator_token'] = $this->administrator->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_fedex', array(), $this->language->getBackEndLocale()),
		);
		$data['header'] = $this->backend_header->index($header_parameter);

		// Load SideMenu
		$sidemenu_parameter = array();
		$data['sidemenu'] = $this->backend_sidemenu->index($sidemenu_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->backend_footer->index($footer_parameter);

		// Echo view
		if ($this->administrator->hasPermission('access','modules/OpenMVM/ShippingMethod/Controllers/BackEnd/ShippingMethod/Fedex')) {
			echo $this->template->render('BackendThemes', 'ShippingMethod\ShippingMethod\fedex', $data);
		} else {
			echo $this->template->render('BackendThemes', 'Common\permission', $data);
		}
	}
}
