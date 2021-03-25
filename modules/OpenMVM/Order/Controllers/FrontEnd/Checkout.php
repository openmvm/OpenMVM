<?php

namespace Modules\OpenMVM\Order\Controllers\FrontEnd;

class Checkout extends \App\Controllers\BaseController
{
	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		// Load Modules Libraries
		$this->cart = new \Modules\OpenMVM\Order\Libraries\Cart;
		// Load Models
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
		$this->subTotalModel = new \Modules\OpenMVM\Order\Models\Total\SubTotalModel();
		$this->totalModel = new \Modules\OpenMVM\Order\Models\Total\TotalModel();

		// Set checkout store ID
		if (!empty($this->request->getPost('checkout_store_id'))) {
			$this->session->set('checkout_store_id' . $this->cart->sessionId(), $this->request->getPost('checkout_store_id'));
		} else {
			$this->session->remove('checkout_store_id' . $this->cart->sessionId());
		}
	}

	public function index()
	{
		// User must logged in!
		if (!$this->user->isLogged() || !$this->auth->validateUserToken($this->uri->getSegment($this->uri->getTotalSegments()))) {

			$this->session->set('user_redirect' . $this->session->user_session_id, '/checkout');

			return redirect()->to(base_url('/login'));
		}

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

		// Validate cart has products and has stock.
		$total_products = 0;

		foreach ($stores as $store) {
			$total_products += $this->cart->hasProducts($store['store_id']);
		}

		if (empty($stores) || !$total_products) {
			return redirect()->to(base_url('/cart'));
		}

		$data = array();

		// Breadcrumbs
		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_home', array(), $this->language->getFrontEndLocale()),
			'href' => base_url(),
			'active' => false,
		);

		$data['breadcrumbs'][] = array(
			'text' => lang('Heading.heading_checkout', array(), $this->language->getFrontEndLocale()),
			'href' => base_url('/checkout'),
			'active' => true,
		);

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
		echo $this->template->render('FrontendThemes', 'Order\checkout', $data);
	}
}
