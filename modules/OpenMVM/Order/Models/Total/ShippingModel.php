<?php

namespace Modules\OpenMVM\Order\Models\Total;

class ShippingModel extends \CodeIgniter\Model
{
	public function __construct()
	{
		// Load Libraries
		$this->session = session();
		$this->setting = new \App\Libraries\Setting;
		// Load Modules Libraries
		$this->cart = new \Modules\OpenMVM\Order\Libraries\Cart;
	}

	public function getTotal($store_id, $total, $language_code)
	{
		if ($this->cart->hasShipping($store_id) && !empty($this->session->get('shipping_method_' . $store_id))) {
			$shipping_method = $this->session->get('shipping_method_' . $store_id);

			$total['totals'][] = array(
				'code'       => 'shipping',
				'title'      => $shipping_method['title'],
				'value'      => $shipping_method['cost'],
				'sort_order' => 2
			);

			$total['total'] += $shipping_method['cost'];
		}
	}
}