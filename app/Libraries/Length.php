<?php

namespace App\Libraries;

class Length
{
	private $lengths = array();

	public function __construct()
	{
		// Load Database
		$this->db = \Config\Database::connect();
		// Get length classes
		$builder = $this->db->table('length_class');
		$builder->select('*');
		$builder->join('length_class_description', 'length_class_description.length_class_id = length_class.length_class_id');

		$query = $builder->get();

		foreach ($query->getResult() as $result) {
			$this->lengths[$result->length_class_id] = array(
				'length_class_id' => $result->length_class_id,
				'title' => $result->title,
				'unit' => $result->unit,
				'value' => $result->value,
			);
		}
	}

	public function convert($value, $from, $to) {
		if ($from == $to) {
			return $value;
		}

		if (isset($this->lengths[$from])) {
			$from = $this->lengths[$from]['value'];
		} else {
			$from = 1;
		}

		if (isset($this->lengths[$to])) {
			$to = $this->lengths[$to]['value'];
		} else {
			$to = 1;
		}

		return $value * ($to / $from);
	}

	public function format($value, $length_class_id, $decimal_point = '.', $thousand_point = ',') {
		if (isset($this->lengths[$length_class_id])) {
			return number_format($value, 2, $decimal_point, $thousand_point) . $this->lengths[$length_class_id]['unit'];
		} else {
			return number_format($value, 2, $decimal_point, $thousand_point);
		}
	}

	public function getUnit($length_class_id) {
		if (isset($this->lengths[$length_class_id])) {
			return $this->lengths[$length_class_id]['unit'];
		} else {
			return '';
		}
	}
}