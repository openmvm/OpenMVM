<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets;

class PaymentAddress extends \App\Controllers\BaseController
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
		$widget_payment_address_data = array();

		// Data Libraries
		$widget_payment_address_data['lang'] = $this->language;

		// Get User Addresses
		$widget_payment_address_data['user_addresses'] = array();

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

			$widget_payment_address_data['user_addresses'][] = array(
				'user_address_id' => $result['user_address_id'],
				'address' => str_replace(array("\r\n", "\r", "\n"), ', ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ', ', trim(str_replace($find, $replace, $format)))),
			);
		}

		if ($this->session->has('payment_address_id')) {
			$payment_address = $this->userAddressModel->getUserAddress($this->session->get('payment_address_id'), $this->user->getId());

			if ($payment_address) {
				$widget_payment_address_data['payment_address_id'] = $this->session->get('payment_address_id');
			} else {
				$widget_payment_address_data['payment_address_id'] = '';
			}
		} else {
			$widget_payment_address_data['payment_address_id'] = '';
		}

		$widget_payment_address_data['countries'] = $this->countryModel->getCountries();

		// Return view
		return $this->template->render('FrontendThemes', 'Order\Widgets\payment_address', $widget_payment_address_data);
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
			$json['error']['input']['payment_address_firstname'] = $validation->getError('firstname');
		}

		if ($validation->hasError('lastname')) {
			$json['error']['input']['payment_address_lastname'] = $validation->getError('lastname');
		}

    if (!$this->user->hasPermission()) {
			$json['error']['permission'] = lang('Error.error_permission_modify', array(), $this->language->getFrontEndLocale());
		}

		if ($this->validation->withRequest($this->request)->run() == TRUE) {
    	if (empty($json['error'])) {
	      // Query
	    	$query = $this->userAddressModel->addUserAddress($this->request->getPost(), $this->user->getId());
	      
	      if ($query) {
    			$this->session->set('payment_address_id', $query);

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

    // Set payment address ID
    $payment_address_id = $this->request->getPost('payment_address_id');

    $this->session->set('payment_address_id', $payment_address_id);

		// Remove selected payment method
		$this->session->remove('payment_method');

    return $this->response->setJSON($json);
	}
}
