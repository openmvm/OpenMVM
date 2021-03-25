<?php

namespace Modules\OpenMVM\ShippingMethod\Models;

class ShippingMethodModel extends \CodeIgniter\Model
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		// Load Database
		$this->db = db_connect();
	}

	public function getInstalled() {
		$shipping_method_data = array();

		$builder = $this->db->table('shipping_method_install');
		$builder->orderBy('code', 'ASC');
		$query = $builder->get();

		foreach ($query->getResult() as $result) {
			$shipping_method_data[] = array(
				'provider' => $result->provider,
				'code' => $result->code,
			);
		}

		return $shipping_method_data;
	}

	public function install($provider, $code) {
		$builder = $this->db->table('shipping_method_install');
		$builder->set('provider', $provider);
		$builder->set('code', $code);
		$query = $builder->insert();

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function uninstall($provider, $code) {
		$builder = $this->db->table('shipping_method_install');
		$builder->where('provider', $provider);
		$builder->where('code', $code);
		$query = $builder->delete();

		if ($query) {
			return true;
		} else {
			return false;
		}
	}	
}