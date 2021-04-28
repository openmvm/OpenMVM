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
		$builder_user_address = $this->db->table('user_address');
		$builder_user_address->where('user_address_id', $shipping_address_id);
		$builder_user_address->where('user_id', $user_id);

		$query_user_address   = $builder_user_address->get();

		$address = $query_user_address->getRow();

		// Get state to origin geo zone
		$builder_state_to_origin_geo_zone = $this->db->table('state_to_geo_zone');
		$builder_state_to_origin_geo_zone->where('geo_zone_id', $this->setting->get('shipping_weight', 'shipping_weight_origin_geo_zone_id'));
		$builder_state_to_origin_geo_zone->where('country_id', $address->country_id);
		$builder_state_to_origin_geo_zone->groupStart();
		$builder_state_to_origin_geo_zone->where('state_id', $address->state_id);
		$builder_state_to_origin_geo_zone->orWhere('state_id', 0);
		$builder_state_to_origin_geo_zone->groupEnd();

		$total_origin_geo_zone_results = $builder_state_to_origin_geo_zone->countAllResults();

		// Get state to destination geo zone
		$builder_state_to_destination_geo_zone = $this->db->table('state_to_geo_zone');
		$builder_state_to_destination_geo_zone->where('geo_zone_id', $this->setting->get('shipping_weight', 'shipping_weight_destination_geo_zone_id'));
		$builder_state_to_destination_geo_zone->where('country_id', $address->country_id);
		$builder_state_to_destination_geo_zone->groupStart();
		$builder_state_to_destination_geo_zone->where('state_id', $address->state_id);
		$builder_state_to_destination_geo_zone->orWhere('state_id', 0);
		$builder_state_to_destination_geo_zone->groupEnd();

		$total_destination_geo_zone_results = $builder_state_to_destination_geo_zone->countAllResults();

    $weight = $this->cart->getWeight($store_id);

		if (empty($this->setting->get('shipping_weight', 'shipping_weight_origin_geo_zone_id')) && empty($this->setting->get('shipping_weight', 'shipping_weight_destination_geo_zone_id'))) {
			$status = true;
		} elseif ($total_origin_geo_zone_results > 0 && $total_destination_geo_zone_results > 0) {
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