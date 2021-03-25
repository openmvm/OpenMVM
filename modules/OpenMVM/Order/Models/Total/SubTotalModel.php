<?php

namespace Modules\OpenMVM\Order\Models\Total;

class SubTotalModel extends \CodeIgniter\Model
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		// Load Modules Libraries
		$this->cart = new \Modules\OpenMVM\Order\Libraries\Cart;
	}

	public function getTotal($store_id, $total, $language_code)
	{
		$sub_total = $this->cart->getSubTotal($store_id);

		$total['totals'][] = array(
			'code'       => 'sub_total',
			'title'      => lang('Text.text_sub_total', array(), $language_code),
			'value'      => $sub_total,
			'sort_order' => 1
		);

		$total['total'] += $sub_total;
	}
}