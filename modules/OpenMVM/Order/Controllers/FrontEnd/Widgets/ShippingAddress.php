<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets;

class ShippingAddress extends \App\Controllers\BaseController
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
		$this->currency = new \App\Libraries\Currency;
		// Load Modules Libraries
		$this->cart = new \Modules\OpenMVM\Order\Libraries\Cart;
		// Load Models
		$this->countryModel = new \Modules\OpenMVM\Localisation\Models\CountryModel();
		$this->userAddressModel = new \Modules\OpenMVM\User\Models\UserAddressModel();
	}

	public function index($widget_parameter = array())
	{
		$widget_shipping_address_data = array();

		// Data Libraries
		$widget_shipping_address_data['lang'] = $this->language;

		// Get User Addresses
		$widget_shipping_address_data['user_addresses'] = array();

		$filter_data = array();

		$results = $this->userAddressModel->getUserAddresses($filter_data, $this->user->getId());

		foreach ($results as $result) {
			if ($result['address_format']) {
				$format = $result['address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{district} {city} {postal_code}' . "\n" . '{state}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{district}',
				'{city}',
				'{postal_code}',
				'{state}',
				'{state_code}',
				'{country}'
			);

			$replace = array(
				'firstname'   => $result['firstname'],
				'lastname'    => $result['lastname'],
				'company'     => $result['company'],
				'address_1'   => $result['address_1'],
				'address_2'   => $result['address_2'],
				'district'    => $result['district'],
				'city'        => $result['city'],
				'postal_code' => $result['postal_code'],
				'state'       => $result['state'],
				'state_code'  => $result['state_code'],
				'country'     => $result['country']
			);

			$widget_shipping_address_data['user_addresses'][] = array(
				'user_address_id' => $result['user_address_id'],
				'address' => str_replace(array("\r\n", "\r", "\n"), ', ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ', ', trim(str_replace($find, $replace, $format)))),
			);
		}

		if ($this->session->has('shipping_address_id')) {
			$shipping_address = $this->userAddressModel->getUserAddress($this->session->get('shipping_address_id'), $this->user->getId());

			if ($shipping_address) {
				$widget_shipping_address_data['shipping_address_id'] = $this->session->get('shipping_address_id');
			} else {
				$widget_shipping_address_data['shipping_address_id'] = '';
			}
		} else {
			$widget_shipping_address_data['shipping_address_id'] = '';
		}

		$widget_shipping_address_data['countries'] = $this->countryModel->getCountries();

		// Return view
		return $this->template->render('FrontendThemes', 'Order\Widgets\shipping_address', $widget_shipping_address_data);
	}

	public function add()
	{
    $json = array();

		// Data Libraries
		$validation = $this->validation;

		// Form Validation
		if ($this->request->getPost()) {
			$this->validate([
				'firstname' => ['label' => lang('Entry.entry_firstname', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
				'lastname' => ['label' => lang('Entry.entry_lastname', array(), $this->language->getFrontEndLocale()), 'rules' => 'required', 'errors' => ['required' => lang('Error.error_required', array(), $this->language->getFrontEndLocale())]],
			]);
		}

		// Errors
		if ($validation->hasError('firstname')) {
			$json['error']['input']['shipping_address_firstname'] = $validation->getError('firstname');
		}

		if ($validation->hasError('lastname')) {
			$json['error']['input']['shipping_address_lastname'] = $validation->getError('lastname');
		}

    if (!$this->user->hasPermission()) {
			$json['error']['permission'] = lang('Error.error_permission_modify', array(), $this->language->getFrontEndLocale());
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if (empty($json['error'])) {
	      // Query
	    	$query = $this->userAddressModel->addUserAddress($this->request->getPost(), $this->user->getId());
	      
	      if ($query) {
    			$this->session->set('shipping_address_id', $query);

	      	$json['success'] = lang('Success.success_user_address_add', array(), $this->language->getFrontEndLocale());
	      } else {
	      	$json['error'] = lang('Error.error_user_address_add', array(), $this->language->getFrontEndLocale());
	      }
      }
		} else {
	    $json['error']['warning'] = lang('Error.error_form', array(), $this->language->getFrontEndLocale());
    }

    $json['response'] = json_encode($this->request->getPost());

    return $this->response->setJSON($json);
	}

	public function set()
	{
    $json = array();

    // Set shipping address ID
    $shipping_address_id = $this->request->getPost('shipping_address_id');

    $this->session->set('shipping_address_id', $shipping_address_id);

    // Remove selected shipping methods
		// Get checkout store Ids
		if ($this->session->has('checkout_store_id' . $this->cart->sessionId())) {
			$store_id = $this->session->get('checkout_store_id' . $this->cart->sessionId());

			$store_info = $this->storeModel->getStore($store_id);

			$store_data = array(
				'store_id' => $store_info['store_id'],
				'name' => $store_info['name'],
				'logo' => $store_info['logo'],
			);

			$stores = array($store_data);
		} else {
			$stores = $this->cart->getStores();
		}

		foreach ($stores as $store) {
			$this->session->remove('shipping_methods_' . $store['store_id']);
			$this->session->remove('shipping_method_' . $store['store_id']);
		}

		// Remove selected payment method
		$this->session->remove('payment_method');

    return $this->response->setJSON($json);
	}
}
