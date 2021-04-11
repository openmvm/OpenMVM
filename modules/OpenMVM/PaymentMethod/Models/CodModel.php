<?php

namespace Modules\OpenMVM\PaymentMethod\Models;

class CodModel extends \CodeIgniter\Model
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		// Load Modules Libraries
		$this->cart = new \Modules\OpenMVM\Order\Libraries\Cart;
		// Load Database
		$this->db = db_connect();
	}

	public function getMethod($payment_address_id, $total, $user_id)
	{
		// Get address info
		$builder_user_address = $this->db->table('user_address');
		$builder_user_address->where('user_address_id', $payment_address_id);
		$builder_user_address->where('user_id', $user_id);

		$query_user_address   = $builder_user_address->get();

		$address = $query_user_address->getRow();

		// Get state to geo zone
		$builder_state_to_geo_zone = $this->db->table('state_to_geo_zone');
		$builder_state_to_geo_zone->where('geo_zone_id', $this->setting->get('payment_cod', 'payment_cod_geo_zone_id'));
		$builder_state_to_geo_zone->where('country_id', $address->country_id);
		$builder_state_to_geo_zone->groupStart();
		$builder_state_to_geo_zone->where('state_id', $address->state_id);
		$builder_state_to_geo_zone->orWhere('state_id', 0);
		$builder_state_to_geo_zone->groupEnd();

		$total_results = $builder_state_to_geo_zone->countAllResults();

		if ($this->setting->get('payment_cod', 'payment_cod_total') > 0 && $this->setting->get('payment_cod', 'payment_cod_total') > $total) {
			$status = false;
		// } elseif (!$this->cart->hasShipping()) {
		// 	$status = false;
		} elseif (empty($this->setting->get('payment_bank_transfer', 'payment_bank_transfer_geo_zone_id'))) {
			$status = true;
		} elseif ($total_results > 0) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'cod',
				'title'      => lang('Text.text_cod_title', array(), $this->language->getFrontEndLocale()),
				'terms'      => '',
				'sort_order' => 1,
			);
		}

		return $method_data;
	}
}