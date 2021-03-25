<?php

namespace Modules\OpenMVM\ShippingMethod\Models;

class FlatModel extends \CodeIgniter\Model
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
		// Get address info
		$builder = $this->db->table('user_address');
		$builder->where('user_address_id', $shipping_address_id);
		$builder->where('user_id', $user_id);

		$query   = $builder->get();

		$address = $query->getRow();

		if ($this->setting->get('shipping_flat', 'shipping_flat_status')) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$quote_data = array();

			$cost = $this->setting->get('shipping_flat', 'shipping_flat_cost');

			$quote_data['flat'] = array(
				'code'         => 'flat.flat',
				'title'        => lang('Text.text_flat_description', array(), $this->language->getFrontEndLocale()),
				'cost'         => $cost,
				'tax_class_id' => 0,
				'text'         => $this->currency->format($cost, $this->currency->getFrontEndCode())
			);

			$quote_data['flat_plus'] = array(
				'code'         => 'flat.flat_plus',
				'title'        => lang('Text.text_flat_description', array(), $this->language->getFrontEndLocale()),
				'cost'         => $cost + 10,
				'tax_class_id' => 0,
				'text'         => $this->currency->format($cost + 10, $this->currency->getFrontEndCode())
			);

			$method_data = array(
				'code'       => 'flat',
				'title'      => lang('Text.text_flat_title', array(), $this->language->getFrontEndLocale()),
				'quote'      => $quote_data,
				'sort_order' => 1,
				'error'      => false
			);
		}

		return $method_data;
	}
}