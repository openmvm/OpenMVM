<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets;

class ShippingMethod extends \App\Controllers\BaseController
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
		$this->userAddressModel = new \Modules\OpenMVM\User\Models\UserAddressModel();
		$this->shippingMethodModel = new \Modules\OpenMVM\ShippingMethod\Models\ShippingMethodModel();
	}

	public function index($widget_parameter = array())
	{
		$widget_shipping_method_data = array();

		// Data Libraries
		$widget_shipping_method_data['lang'] = $this->language;

		if (!$this->session->has('shipping_address_id')) {
			$error = true;
		} else {
			$shipping_address = $this->userAddressModel->getUserAddress($this->session->get('shipping_address_id'), $this->user->getId());

			if (!$shipping_address) {
				$error = true;
			}
		}

		$widget_shipping_method_data['error'] = $error;

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

			// Shipping Methods
			$method_data = array();

			// $results = array('fedex', 'flat', 'weight');
			$results = $this->shippingMethodModel->getInstalled();

			foreach ($results as $result) {
				if (!empty($this->setting->get('shipping_' . $result['code'], 'shipping_' . $result['code'] . '_status'))) {
					$codes = explode('_', $result['code']);
					
					$code = array();

					foreach ($codes as $key => $value) {
						if ($key == 0) {
							$code[] = $value;
						} else {
							$code[] = ucwords($value);
						}
					}

					$code = implode('', $code);

					$model = lcfirst($code . 'Model');
					$namespace = '\Modules\\' . $result['provider'] . '\ShippingMethod\Models\\' . $code . 'Model';
					$this->$model = new $namespace;

					$quote = $this->{$code . 'Model'}->getQuote($store['store_id'], $this->session->get('shipping_address_id'), $this->user->getId());

					if ($quote) {
						$method_data[$result['code']] = array(
							'code'       => $quote['code'],
							'title'      => $quote['title'],
							'quote'      => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);

			$this->session->set('shipping_methods_' . $store['store_id'], $method_data);

			if ($this->session->has('shipping_methods_' . $store['store_id'])) {
				$shipping_method_data = $this->session->get('shipping_methods_' . $store['store_id']);
			} else {
				$shipping_method_data = array();
			}

			$widget_shipping_method_data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name' => $store['name'],
				'weight' => $this->weight->format($this->cart->getWeight($store['store_id'], 'frontend'), $this->setting->get('setting', 'setting_frontend_weight_class_id'), lang('Common.common_decimal_point', array(), $this->language->getFrontEndLocale()), lang('Common.common_thousand_point', array(), $this->language->getFrontEndLocale())),
				'shipping_methods' => $shipping_method_data,
			);

			if ($this->session->has('shipping_method_' . $store['store_id'])) {
    		$shipping_method = $this->session->get('shipping_method_' . $store['store_id']);

				$widget_shipping_method_data['shipping_method_' . $store['store_id']] = $shipping_method['code'];
			} else {
				$widget_shipping_method_data['shipping_method_' . $store['store_id']] = '';
			}
		}

		// Return view
		return $this->template->render('FrontendThemes', 'Order\Widgets\shipping_method', $widget_shipping_method_data);
	}

	public function set()
	{
    $json = array();

		$shipping_method_data = array(
			'store_id' => $this->request->getPost('store_id'),
			'code' => $this->request->getPost('code'),
			'title' => $this->request->getPost('title'),
			'cost' => $this->request->getPost('cost'),
		);

    $this->session->set('shipping_method_' . $this->request->getPost('store_id'), $shipping_method_data);

    return $this->response->setJSON($json);
	}
}
