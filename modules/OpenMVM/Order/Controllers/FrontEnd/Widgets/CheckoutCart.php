<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd\Widgets;

class CheckoutCart extends \App\Controllers\BaseController
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
		$this->userModel = new \Modules\OpenMVM\User\Models\UserModel();
		$this->userAddressModel = new \Modules\OpenMVM\User\Models\UserAddressModel();
	}

	public function index($widget_parameter = array())
	{
		$widget_checkout_cart_data = array();

		// Data Libraries
		$widget_checkout_cart_data['lang'] = $this->language;

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

		$widget_checkout_cart_data['stores'] = array();

		foreach ($stores as $store) {
			// Store logo
			if ($store['logo'] && is_file(ROOTPATH . 'public/assets/files/' . $store['logo'])) {
				$thumb = $this->image->resize($store['logo'], 24, 24, true, 'auto');
			} else {
		    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
					$thumb = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 24, 24, true, 'auto');
				} else {
					$thumb = $this->image->resize('placeholder.png', 24, 24, true, 'auto');
				}
			}

			// Get store products
			$product_data = array();

			foreach ($this->cart->getProducts($store['store_id']) as $product) {
				if ($product['image'] && is_file(ROOTPATH . 'public/assets/files/' . $product['image'])) {
					$thumb_product = $this->image->resize($product['image'], 48, 48, true, 'auto');
				} else {
			    if (is_file(ROOTPATH . 'public/assets/files/' . $this->setting->get('setting', 'setting_placeholder'))) {
						$thumb_product = $this->image->resize($this->setting->get('setting', 'setting_placeholder'), 48, 48, true, 'auto');
					} else {
						$thumb_product = $this->image->resize('placeholder.png', 48, 48, true, 'auto');
					}
				}

				$total = $this->currency->format($product['price'] * $product['quantity'], $this->currency->getFrontEndCode());

				$product_data[] = array(
					'product_id' => $product['product_id'],
					'name' => $product['name'],
					'thumb' => $thumb_product,
					'quantity' => $product['quantity'],
					'price' => $this->currency->format($product['price'], $this->currency->getFrontEndCode()),
					'total' => $total,
				);
			}

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

			$totals_data = array();

			foreach ($totals as $total) {
				$totals_data[] = array(
					'code'  => $total['code'],
					'title' => $total['title'],
					'value' => $total['value'],
					'text'  => $this->currency->format($total['value'], $this->currency->getFrontEndCode()),
				);
			}

			$widget_checkout_cart_data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name' => $store['name'],
				'thumb' => $thumb,
				'products' => $product_data,
				'totals' => $totals_data,
				'weight' => $this->weight->format($this->cart->getWeight($store['store_id'], 'frontend'), $this->setting->get('setting', 'setting_frontend_weight_class_id'), lang('Common.common_decimal_point', array(), $this->language->getFrontEndLocale()), lang('Common.common_thousand_point', array(), $this->language->getFrontEndLocale())),
			);

			$total_item += $this->cart->countProducts($store['store_id']);
		}

		$widget_checkout_cart_data['total_item'] = $total_item;
		$widget_checkout_cart_data['total_value'] = $this->currency->format($total_value, $this->currency->getFrontEndCode());

		// Get Payment Address
		$payment_address = '';

		if ($this->session->has('payment_address_id')) {
			$payment_address_id = $this->session->get('payment_address_id');

			$payment_address_info = $this->userAddressModel->getUserAddress($payment_address_id, $this->user->getId());

			if ($payment_address_info) {
				if ($payment_address_info['address_format']) {
					$format = $payment_address_info['address_format'];
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
					'firstname'   => $payment_address_info['firstname'],
					'lastname'    => $payment_address_info['lastname'],
					'company'     => $payment_address_info['company'],
					'address_1'   => $payment_address_info['address_1'],
					'address_2'   => $payment_address_info['address_2'],
					'district'    => $payment_address_info['district'],
					'city'        => $payment_address_info['city'],
					'postal_code' => $payment_address_info['postal_code'],
					'state'       => $payment_address_info['state'],
					'state_code'  => $payment_address_info['state_code'],
					'country'     => $payment_address_info['country']
				);

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
			}
		}

		$widget_checkout_cart_data['payment_address'] = $payment_address;

		// Get Shipping Address
		$shipping_address = '';

		if ($this->session->has('shipping_address_id')) {
			$shipping_address_id = $this->session->get('shipping_address_id');

			$shipping_address_info = $this->userAddressModel->getUserAddress($shipping_address_id, $this->user->getId());

			if ($shipping_address_info) {
				if ($shipping_address_info['address_format']) {
					$format = $shipping_address_info['address_format'];
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
					'firstname'   => $shipping_address_info['firstname'],
					'lastname'    => $shipping_address_info['lastname'],
					'company'     => $shipping_address_info['company'],
					'address_1'   => $shipping_address_info['address_1'],
					'address_2'   => $shipping_address_info['address_2'],
					'district'    => $shipping_address_info['district'],
					'city'        => $shipping_address_info['city'],
					'postal_code' => $shipping_address_info['postal_code'],
					'state'       => $shipping_address_info['state'],
					'state_code'  => $shipping_address_info['state_code'],
					'country'     => $shipping_address_info['country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
			}
		}

		$widget_checkout_cart_data['shipping_address'] = $shipping_address;

		// Get Payment Method
		if ($this->session->has('payment_method')) {
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

			if (!$error) {
				$payment_method = $this->session->get('payment_method');

				$widget_checkout_cart_data['payment_method'] = $payment_method['title'];

				// Load Widget Selected Payment Method
				$codes = explode('_', $payment_method['code']);
				
				$code = array();

				foreach ($codes as $key => $value) {
					$code[] = ucwords($value);
				}

				$code = implode('', $code);

				$model = lcfirst($code . 'Model');

				$namespace = '\Modules\OpenMVM\PaymentMethod\Controllers\FrontEnd\\' . $code;
				$this->$model = new $namespace;

				$widget_checkout_cart_data['widget_payment_method'] = $this->$model->index();
			} else {
				$widget_checkout_cart_data['payment_method'] = '';
				$widget_checkout_cart_data['widget_payment_method'] = '';
			}
		} else {
			$widget_checkout_cart_data['payment_method'] = '';
			$widget_checkout_cart_data['widget_payment_method'] = '';
		}

		// Return view
		return $this->template->render('FrontendThemes', 'Order\Widgets\checkout_cart', $widget_checkout_cart_data);
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

		if (!$this->session->has('payment_method')) {
			$error = true;
		}

		if (!$error) {
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

		    // Order data
				$order_data['store_id'] = $store['store_id'];
				$order_data['invoice_no'] = '';
				$order_data['invoice_prefix'] = '';

				// User Info
				$user_info = $this->userModel->getUser($this->user->getId());

				$order_data['user_id'] = $user_info['user_id'];
				$order_data['user_group_id'] = $user_info['user_group_id'];
				$order_data['firstname'] = $user_info['firstname'];
				$order_data['lastname'] = $user_info['lastname'];
				$order_data['email'] = $user_info['email'];
				$order_data['telephone'] = $user_info['telephone'];
				$order_data['fax'] = '';
				$order_data['custom_field'] = '';

		    // Payment Address
		    $payment_address_id = $this->session->get('payment_address_id');

		    $payment_address_info = $this->userAddressModel->getUserAddress($payment_address_id, $this->user->getId());

				$order_data['payment_firstname'] = $payment_address_info['firstname'];
				$order_data['payment_lastname'] = $payment_address_info['lastname'];
				$order_data['payment_company'] = '';
				$order_data['payment_address_1'] = $payment_address_info['address_1'];
				$order_data['payment_address_2'] = $payment_address_info['address_2'];
				$order_data['payment_city'] = $payment_address_info['city'];
				$order_data['payment_postal_code'] = $payment_address_info['postal_code'];
				$order_data['payment_country'] = $payment_address_info['country'];
				$order_data['payment_country_id'] = $payment_address_info['country_id'];
				$order_data['payment_state'] = $payment_address_info['state'];
				$order_data['payment_state_id'] = $payment_address_info['state_id'];
				$order_data['payment_address_format'] = $payment_address_info['address_format'];
				$order_data['payment_custom_field'] = '';

				// Payment Method
				$payment_method = $this->session->get('payment_method');

				$order_data['payment_method'] = $payment_method['title'];
				$order_data['payment_code'] = $payment_method['code'];

		    // Shipping Address
		    $shipping_address_id = $this->session->get('shipping_address_id');

		    $shipping_address_info = $this->userAddressModel->getUserAddress($shipping_address_id, $this->user->getId());

				$order_data['shipping_firstname'] = $shipping_address_info['firstname'];
				$order_data['shipping_lastname'] = $shipping_address_info['lastname'];
				$order_data['shipping_company'] = '';
				$order_data['shipping_address_1'] = $shipping_address_info['address_1'];
				$order_data['shipping_address_2'] = $shipping_address_info['address_2'];
				$order_data['shipping_city'] = $shipping_address_info['city'];
				$order_data['shipping_postal_code'] = $shipping_address_info['postal_code'];
				$order_data['shipping_country'] = $shipping_address_info['country'];
				$order_data['shipping_country_id'] = $shipping_address_info['country_id'];
				$order_data['shipping_state'] = $shipping_address_info['state'];
				$order_data['shipping_state_id'] = $shipping_address_info['state_id'];
				$order_data['shipping_address_format'] = $shipping_address_info['address_format'];
				$order_data['shipping_custom_field'] = '';

				$order_data['comment'] = '';
				$order_data['total'] = $total;
				$order_data['order_status_id'] = '';
				$order_data['affiliate_id'] = '';
				$order_data['commission'] = '';
				$order_data['marketing_id'] = '';
				$order_data['tracking'] = '';
				$order_data['language_id'] = $this->language->getFrontEndId();
				$order_data['currency_id'] = $this->currency->getFrontEndId();
				$order_data['currency_code'] = $this->currency->getFrontEndCode();
				$order_data['currency_value'] = $this->currency->getFrontEndValue();
				$order_data['ip'] = '';
				$order_data['forwarded_ip'] = '';
				$order_data['user_agent'] = '';
				$order_data['accept_language'] = '';

		    // Add or Edit Order
		    if ($this->session->has('store_order_id_' . $store['store_id'])) {
		    	$order_id = $this->session->get('store_order_id_' . $store['store_id']);

		    	$this->orderModel->editOrder($order_data, $order_id);
		    } else {
		    	$order_id = $this->orderModel->addOrder($order_data);

		    	$this->session->set('store_order_id_' . $store['store_id'], $order_id);
		    }
			   
		    // Delete order products
		    $this->orderModel->deleteOrderProduct($order_id);

		    // Delete order total
		    $this->orderModel->deleteOrderTotal($order_id);

				// Products
				$order_data['products'] = array();

				foreach ($this->cart->getProducts($store['store_id']) as $product) {
					$option_data = array();

					$order_data['products'][] = array(
						'product_id' => $product['product_id'],
						'name'       => $product['name'],
						'model'      => $product['model'],
						'quantity'   => $product['quantity'],
						'price'      => $product['price'],
						'total'      => $product['total'],
						'tax'        => $product['tax'],
						'reward'     => $product['reward'],
					);
				}

    		$this->orderModel->addOrderProduct($order_data, $order_id, $store['store_id']);

				// Shipping Method
				$shipping_method = $this->session->get('shipping_method_' . $store['store_id']);

				$order_data['shipping_method'] = $shipping_method['title'];
				$order_data['shipping_code'] = $shipping_method['code'];

    		$this->orderModel->addOrderShipping($order_data, $order_id, $store['store_id']);

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

				$totals_data = array();

				foreach ($totals as $total) {
					$totals_data[] = array(
						'code'  => $total['code'],
						'title' => $total['title'],
						'value' => $total['value'],
						'sort_order' => $total['sort_order'],
					);
				}

    		$this->orderModel->addOrderTotal($totals_data, $order_id, $store['store_id']);
			}
		  
	  }

    return $this->response->setJSON($json);
  }

	public function success()
	{
		$data = array();

		// Remove checkout sessions
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
			$this->cart->clear($store['store_id']);
			$this->session->remove('shipping_methods_' . $store['store_id']);
			$this->session->remove('shipping_method_' . $store['store_id']);
			$this->session->remove('store_order_id_' . $store['store_id']);
		}

		$this->session->remove('payment_methods');
		$this->session->remove('shipping_address_id');
		$this->session->remove('payment_address_id');
		$this->session->remove('payment_method');
		$this->session->remove('checkout_store_id' . $this->cart->sessionId());

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_checkout', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		echo $this->template->render('FrontendThemes', 'Order\checkout_success', $data);
	}
}
