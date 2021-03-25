<?php

namespace App\Libraries;

class Setting
{
	public function __construct()
	{
		// Load Database
		$this->db = \Config\Database::connect();
	}

  public function get($code, $key)
  {
		$setting_data = array();

		$query = $this->db->query("SELECT * FROM " . $this->db->getPrefix() . "setting WHERE `code` = '" . $this->db->escapeString($code) . "' AND `key` = '" . $this->db->escapeString($key) . "'");

		$result = $query->getRowArray();

		if (!$result['serialized']) {
			$setting_data = $result['value'];
		} else {
			$setting_data = json_decode($result['value'], true);
		}

		return $setting_data;
  }
}