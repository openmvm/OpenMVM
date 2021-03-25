<?php

namespace Modules\OpenMVM\Order\Models\Total;

class TotalModel extends \CodeIgniter\Model
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
	}

	public function getTotal($store_id, $total, $language_code)
	{
		$total['totals'][] = array(
			'code'       => 'total',
			'title'      => lang('Text.text_total', array(), $language_code),
			'value'      => max(0, $total['total']),
			'sort_order' => 99
		);
	}
}