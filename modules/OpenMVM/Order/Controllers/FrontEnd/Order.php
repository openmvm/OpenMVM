<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd;

class Order extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Model
		$this->orderModel = new \Modules\OpenMVM\Order\Models\OrderModel();
		$this->productModel = new \Modules\OpenMVM\Store\Models\ProductModel();
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
	}

	public function index()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/orders');

			return redirect()->to(base_url('/login'));
		}

		$data = array();

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_account', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_my_orders', array(), $this->language->getFrontEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_my_orders', array(), $this->language->getFrontEndLocale());

		// Return
		return $this->getList($data);
	}

	public function getList($data = array())
	{
		// Data URL Parameters
		if ($this->request->getGet('page') !== null) {
			$page = $this->request->getGet('page');
		} else {
			$page = 1;
		}

		// Get User Orders
    if ($this->request->getPost('selected')) {
      $data['selected'] = (array)$this->request->getPost('selected');
    } else {
      $data['selected'] = array();
    }

		$data['orders'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page'),
			'limit' => $this->setting->get('setting', 'setting_frontend_items_per_page'),
		);

		$total_results = $this->orderModel->getTotalOrders($filter_data, $this->user->getId(), $this->language->getFrontEndId());

		$results = $this->orderModel->getOrders($filter_data, $this->user->getId(), $this->language->getFrontEndId());

		foreach ($results as $result) {
			$product_total = $this->orderModel->getTotalOrderProductsByOrderId($result['order_id']);

			$data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['firstname'] . ' ' . $result['lastname'],
				'status'     => $result['status'],
				'date_added' => date(lang('Common.common_date_format_short', array(), $this->language->getFrontEndLocale()), strtotime($result['date_added'])),
				'products'   => $product_total,
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'view'       => base_url('/account/orders/info/' . $result['order_id'] . '/' . $this->user->getToken()),
			);
		}

		// Pager
		$data['pager'] = $this->pager->makeLinks($page, $this->setting->get('setting', 'setting_frontend_items_per_page'), $total_results, 'frontend_pager');

		// Pagination Text
		$data['pagination'] = sprintf(lang('Text.text_pagination', array(), $this->language->getFrontEndLocale()), ($total_results) ? (($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page')) + 1 : 0, ((($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page')) > ($total_results - $this->setting->get('setting', 'setting_frontend_items_per_page'))) ? $total_results : ((($page - 1) * $this->setting->get('setting', 'setting_frontend_items_per_page')) + $this->setting->get('setting', 'setting_frontend_items_per_page')), $total_results, ceil($total_results / $this->setting->get('setting', 'setting_frontend_items_per_page')));

		$data['user_token'] = $this->user->getToken();

		// Load Header
		$header_parameter = array(
			'title' => lang('Heading.heading_my_orders', array(), $this->language->getFrontEndLocale()),
			'breadcrumbs' => $data['breadcrumbs'],
		);
		$data['header'] = $this->frontend_header->index($header_parameter);

		// Load Footer
		$footer_parameter = array();
		$data['footer'] = $this->frontend_footer->index($footer_parameter);

		// Echo view
		if ($this->user->hasPermission()) {
			echo $this->template->render('FrontendThemes', 'Order\order_list', $data);
		} else {
			echo $this->template->render('FrontendThemes', 'Common\permission', $data);
		}
	}

	public function info($data = array())
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/account/orders');

			return redirect()->to(base_url('/login'));
		}

		$data = array();

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_account', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_my_orders', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/account/orders/' . $this->user->getToken()),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_my_orders', array(), $this->language->getFrontEndLocale()),
			'href' => '',
			'active' => true,
		);

		// Data Text
		$data['heading_title'] = lang('Heading.heading_my_orders', array(), $this->language->getFrontEndLocale());

		$data['user_token'] = $this->user->getToken();

		// Get order
		$order_info = $this->orderModel->getOrder($this->request->uri->getSegment(4), $this->user->getId());

		if ($order_info) {
			// Store info
			$store_info = $this->storeModel->getStore($order_info['store_id']);

			$data['store_name'] = $store_info['name'];

			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['order_id'] = (int)$order_info['order_id'];
			$data['date_added'] = date(lang('Common.common_date_format_short', array(), $this->language->getFrontEndLocale()), strtotime($order_info['date_added']));

			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postal_code}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postal_code}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname'   => $order_info['payment_firstname'],
				'lastname'    => $order_info['payment_lastname'],
				'company'     => $order_info['payment_company'],
				'address_1'   => $order_info['payment_address_1'],
				'address_2'   => $order_info['payment_address_2'],
				'city'        => $order_info['payment_city'],
				'postal_code' => $order_info['payment_postal_code'],
				'zone'        => $order_info['payment_zone'],
				'zone_code'   => $order_info['payment_zone_code'],
				'country'     => $order_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['payment_method'] = $order_info['payment_method'];

			// Get order shipping
			$order_shipping = $this->orderModel->getOrderShipping($order_info['order_id'], $order_info['store_id']);

			if ($order_shipping['shipping_address_format']) {
				$format = $order_shipping['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postal_code}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postal_code}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname'   => $order_shipping['shipping_firstname'],
				'lastname'    => $order_shipping['shipping_lastname'],
				'company'     => $order_shipping['shipping_company'],
				'address_1'   => $order_shipping['shipping_address_1'],
				'address_2'   => $order_shipping['shipping_address_2'],
				'city'        => $order_shipping['shipping_city'],
				'postal_code' => $order_shipping['shipping_postal_code'],
				'zone'        => $order_shipping['shipping_zone'],
				'zone_code'   => $order_shipping['shipping_zone_code'],
				'country'     => $order_shipping['shipping_country']
			);

			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['shipping_method'] = $order_shipping['shipping_method'];

			// Products
			$products = $this->orderModel->getOrderProducts($order_info['order_id'], $order_info['store_id']);

			foreach ($products as $product) {
				$product_info = $this->productModel->getProduct($product['product_id']);

				if ($product_info) {
					$reorder = base_url('');
				} else {
					$reorder = '';
				}

				$data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'], $order_info['currency_code'], $order_info['currency_value']),
					'reorder'  => $reorder,
					'return'   => base_url(''),
				);
			}

			// Totals
			$totals = $this->orderModel->getOrderTotals($order_info['order_id'], $order_info['store_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}

			$data['comment'] = nl2br($order_info['comment']);

			// History
			$data['histories'] = array();

			$results = $this->orderModel->getOrderHistories($order_info['order_id'], $this->language->getFrontEndId());

			foreach ($results as $result) {
				$data['histories'][] = array(
					'date_added' => date(lang('Common.common_date_format_short', array(), $this->language->getFrontEndLocale()), strtotime($result['date_added'])),
					'status'     => $result['status'],
					'comment'    => $result['notify'] ? nl2br($result['comment']) : ''
				);
			}

			// Load Header
			$header_parameter = array(
				'title' => lang('Heading.heading_my_orders', array(), $this->language->getFrontEndLocale()),
				'breadcrumbs' => $data['breadcrumbs'],
			);
			$data['header'] = $this->frontend_header->index($header_parameter);

			// Load Footer
			$footer_parameter = array();
			$data['footer'] = $this->frontend_footer->index($footer_parameter);

			// Echo view
			if ($this->user->hasPermission()) {
				echo $this->template->render('FrontendThemes', 'Order\order_info', $data);
			} else {
				echo $this->template->render('FrontendThemes', 'Common\permission', $data);
			}
		} else {
			// Data Text
			$data['message'] = lang('Text.text_order_not_found', array(), $this->language->getFrontEndLocale());

			// Load Header
			$header_parameter = array(
				'title' => lang('Heading.heading_not_found', array(), $this->language->getFrontEndLocale()),
				'breadcrumbs' => $data['breadcrumbs'],
			);
			$data['header'] = $this->frontend_header->index($header_parameter);

			// Load Footer
			$footer_parameter = array();
			$data['footer'] = $this->frontend_footer->index($footer_parameter);

			// Echo view
			if ($this->user->hasPermission()) {
				echo $this->template->render('FrontendThemes', 'Common\not_found', $data);
			} else {
				echo $this->template->render('FrontendThemes', 'Common\permission', $data);
			}
		}
	}
}
