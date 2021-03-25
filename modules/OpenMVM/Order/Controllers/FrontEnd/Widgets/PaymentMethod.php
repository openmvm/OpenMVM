<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets;

class PaymentMethod extends \App\Controllers\BaseController
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
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
		$this->orderModel = new \Modules\OpenMVM\Order\Models\OrderModel();
		$this->userAddressModel = new \Modules\OpenMVM\User\Models\UserAddressModel();
	}

	public function index($widget_parameter = array())
	{
		$widget_payment_method_data = array();

		// Data Libraries
		$widget_payment_method_data['lang'] = $this->language;

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

    // Totals
		$total_items = 0;
		$total_value = 0;

		$data['stores'] = array();

		foreach ($stores as $store) {
			// Get store totals
			$totals = array();
			$total = 0;

			// Because __call can not keep var references so we put them into an array.
			$total_data = array(
				'totals' => &$totals,
				'total'  => &$total
			);

			$results = array('sub_total', 'shipping', 'total');

			foreach ($results as $result) {
				$codes = explode('_', $result);
				
				$code = array();

				foreach ($codes as $key => $value) {
					$code[] = ucwords($value);
				}

				$code = implode('', $code);

				$model = lcfirst($code . 'Model');
				$namespace = '\Modules\OpenMVM\Order\Models\Total\\' . $code . 'Model';
				$this->$model = new $namespace;

				$this->{$model}->getTotal($store['store_id'], $total_data, $this->language->getFrontEndLocale());

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}

			$total_value += $total;
		}

		// User can select payment method after selecting
		// payment address, shipping address, and shipping method
		$error = false;

		if (!$this->session->has('payment_address_id')) {
			$error = true;
		} else {
			$payment_address = $this->userAddressModel->getUserAddress($this->session->get('payment_address_id'), $this->user->getId());

			if (!$payment_address) {
				$error = true;
			}
		}

		if (!$this->session->has('shipping_address_id')) {
			$error = true;
		} else {
			$shipping_address = $this->userAddressModel->getUserAddress($this->session->get('shipping_address_id'), $this->user->getId());

			if (!$shipping_address) {
				$error = true;
			}
		}

		foreach ($stores as $store) {
			if (!$this->session->has('shipping_method_' . $store['store_id'])) {
				$error = true;

				break;
			}
		}

		$widget_payment_method_data['error'] = $error;

		// Payment methods
		$method_data = array();

		$results = array('BankTransfer', 'Cod');

		foreach ($results as $result) {
			$model = lcfirst($result . 'Model');
			$namespace = '\Modules\OpenMVM\PaymentMethod\Models\\' . $result . 'Model';
			$this->$model = new $namespace;

			$method = $this->{$model}->getMethod($this->session->get('payment_address_id'), $total_value, $this->user->getId());

			if ($method) {
				$method_data[$result] = $method;
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
		}

		array_multisort($sort_order, SORT_ASC, $method_data);

		$this->session->set('payment_methods', $method_data);

		if ($this->session->has('payment_methods')) {
			$widget_payment_method_data['payment_methods'] = $this->session->get('payment_methods');
		} else {
			$widget_payment_method_data['payment_methods'] = array();
		}

		if ($this->session->has('payment_method')) {
			$payment_method = $this->session->get('payment_method');

			if (!empty($payment_method['code'])) {
				$widget_payment_method_data['code'] = $payment_method['code'];
			} else {
				$widget_payment_method_data['code'] = '';
			}
		} else {
			$widget_payment_method_data['code'] = '';
		}

		// Return view
		return $this->template->render('FrontendThemes', 'Order\Widgets\payment_method', $widget_payment_method_data);
	}

	public function set()
	{
    $json = array();

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

		// User can select payment method after selecting
		// payment address, shipping address, and shipping method
		$error = false;

		if (!$this->session->has('payment_address_id')) {
			$error = true;
		}

		if (!$this->session->has('shipping_address_id')) {
			$error = true;
		}

		foreach ($stores as $store) {
			if (!$this->session->has('shipping_method_' . $store['store_id'])) {
				$error = true;

				break;
			}
		}

		if (!$error) {
	    // Totals
			$total_items = 0;
			$total_value = 0;

			foreach ($stores as $store) {
				// Get store totals
				$totals = array();
				$total = 0;

				// Because __call can not keep var references so we put them into an array.
				$total_data = array(
					'totals' => &$totals,
					'total'  => &$total
				);

				$results = array('sub_total', 'shipping', 'total');

				foreach ($results as $result) {
					$codes = explode('_', $result);
					
					$code = array();

					foreach ($codes as $key => $value) {
						$code[] = ucwords($value);
					}

					$code = implode('', $code);

					$model = lcfirst($code . 'Model');
					$namespace = '\Modules\OpenMVM\Order\Models\Total\\' . $code . 'Model';
					$this->$model = new $namespace;

					$this->{$model}->getTotal($store['store_id'], $total_data, $this->language->getFrontEndLocale());

					$sort_order = array();

					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $totals);
				}

				$total_value += $total;
			}
			
			$codes = explode('_', $this->request->getPost('value'));
			
			$code = array();

			foreach ($codes as $key => $value) {
				$code[] = ucwords($value);
			}

			$code = implode('', $code);

			$model = lcfirst($code . 'Model');

			$namespace = '\Modules\OpenMVM\PaymentMethod\Models\\' . $code . 'Model';
			$this->$model = new $namespace;

			$method = $this->{$model}->getMethod($this->session->get('payment_address_id'), $total_value, $this->user->getId());

			$payment_method_data = array(
				'code' => $method['code'],
				'title' => $method['title'],
				'terms' => $method['terms'],
			);

	    $this->session->set('payment_method', $payment_method_data);

		} else {
			$json['error'] = 'ERROR!';
		}

    return $this->response->setJSON($json);
	}
}
