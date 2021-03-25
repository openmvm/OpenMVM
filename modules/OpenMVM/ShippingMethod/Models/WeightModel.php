<?php

namespace Modules\OpenMVM\ShippingMethod\Models;

class WeightModel extends \CodeIgniter\Model
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		$this->currency = new \App\Libraries\Currency;
		// Load Modules Libraries
		$this->cart = new \Modules\OpenMVM\Order\Libraries\Cart;
		// Load Database
		$this->db = db_connect();
	}

	public function getQuote($store_id, $shipping_address_id, $user_id)
	{
		$quote_data = array();

		// Get address info
		$builder = $this->db->table('user_address');
		$builder->where('user_address_id', $shipping_address_id);
		$builder->where('user_id', $user_id);

		$query   = $builder->get();

		$address = $query->getRow();

    $weight = $this->cart->getWeight($store_id);

		if ($this->setting->get('shipping_weight', 'shipping_weight_status')) {
			$status = true;
		} else {
			$status = false;
		}

		if ($status) {
			$cost = '';

			$rates = explode(',', $this->setting->get('shipping_weight', 'shipping_weight_rate'));

			foreach ($rates as $rate) {
				$data = explode(':', $rate);

				if ($data[0] >= $weight) {
					if (isset($data[1])) {
						$cost = $data[1];
					}

					break;
				}
			}

			if ((string)$cost != '') {
				$quote_data['weight'] = array(
					'code'         => 'weight.weight',
					'title'        => lang('Text.text_weight_description', array(), $this->language->getFrontEndLocale()),
					'cost'         => $cost,
					'tax_class_id' => 0,
					'text'         => $this->currency->format($cost, $this->currency->getFrontEndCode())
				);
			}
		}

		$method_data = array();

		if ($quote_data) {
			$method_data = array(
				'code'       => 'weight',
				'title'      => lang('Text.text_weight_title', array(), $this->language->getFrontEndLocale()),
				'quote'      => $quote_data,
				'sort_order' => 1,
				'error'      => false
			);
		}

		return $method_data;
	}
}