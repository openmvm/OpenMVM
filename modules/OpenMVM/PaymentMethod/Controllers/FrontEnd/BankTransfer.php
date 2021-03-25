<?php

namespace Modules\OpenMVM\PaymentMethod\Controllers\FrontEnd;

class BankTransfer extends \App\Controllers\BaseController
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
		$this->subTotalModel = new \Modules\OpenMVM\Order\Models\Total\SubTotalModel();
		$this->totalModel = new \Modules\OpenMVM\Order\Models\Total\TotalModel();
		$this->orderModel = new \Modules\OpenMVM\Order\Models\OrderModel();
		$this->storeModel = new \Modules\OpenMVM\Store\Models\StoreModel();
	}

	public function index()
	{
		$bank_transfer_data = array();

		// Data Libraries
		$bank_transfer_data['lang'] = $this->language;

		// Data Text
		$bank_transfer_data['bank'] = nl2br('Please send the payment to this bank account: Bank Name.');

		// Return view
		return $this->template->render('FrontendThemes', 'PaymentMethod\bank_transfer', $bank_transfer_data);
	}

	public function confirm() {
    $json = array();

    $order_status_id = $this->setting->get('payment_bank_transfer', 'payment_bank_transfer_order_status_id');

		if ($this->session->has('payment_method')) {
			$payment_method = $this->session->get('payment_method');

			if (!empty($payment_method['code']) && $payment_method['code'] == 'bank_transfer') {
				// Get checkout store Ids
				if ($this->session->has('checkout_store_id' . $this->cart->sessionId())) {
					$store_id = $this->session->get('checkout_store_id' . $this->cart->sessionId());

					$store_info = $this->storeModel->getStore($store_id);

					$store_data = array(
						'store_id' => $store_info['store_id'],
					);

					$stores = array($store_data);
				} else {
					$stores = $this->cart->getStores();
				}

				foreach ($stores as $store) {
					$this->orderModel->addOrderHistory($this->session->get('store_order_id_' . $store['store_id']), $order_status_id);
				}

				$json['redirect'] = base_url('order/checkout/widget/checkout_cart/success/' . $this->user->getToken());
			}
		}

    return $this->response->setJSON($json);
	}
}
