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
		$builder = $this->db->table('user_address');
		$builder->where('user_address_id', $payment_address_id);
		$builder->where('user_id', $user_id);

		$query   = $builder->get();

		$address = $query->getRow();

		if ($this->setting->get('payment_cod', 'payment_cod_status')) {
			$status = true;
		} elseif ($this->setting->get('payment_cod', 'payment_cod_total') > 0 && $this->setting->get('payment_cod', 'payment_cod_total') > $total) {
			$status = false;
		} elseif (!$this->cart->hasShipping()) {
			$status = false;
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