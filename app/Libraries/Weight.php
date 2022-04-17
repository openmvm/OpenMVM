<?php

/**
 * This file is part of OpenMVM.
 *
 * (c) OpenMVM <admin@openmvm.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace App\Libraries;

class Weight {
    private $weight_classes = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();

        // Get weight classes
        $weight_class_builder = $this->db->table('weight_class');

        $weight_class_builder->join('weight_class_description', 'weight_class_description.weight_class_id = weight_class.weight_class_id', 'left');

        $weight_class_builder->where('weight_class_description.language_id', $this->language->getCurrentId());

        $weight_class_builder->orderBy('weight_class_description.title', 'ASC');

        $weight_class_query = $weight_class_builder->get();

        $weight_classes = [];

        foreach ($weight_class_query->getResult() as $result) {
            $this->weight_classes[$result->weight_class_id] = [
                'weight_class_id' => $result->weight_class_id,
                'title' => $result->title,
                'unit' => $result->unit,
                'value' => $result->value,
            ];
        }
    }

    /**
     * Get unit.
     *
     */
	public function getUnit($weight_class_id) {
		if (isset($this->weight_classes[$weight_class_id])) {
			return $this->weight_classes[$weight_class_id]['unit'];
		} else {
			return '';
		}
	}

    /**
     * Format.
     *
     */
    public function format($number, $weight_class_id, $decimal_point = '.', $thousand_point = ',')
    {
		if (isset($this->weight_classes[$weight_class_id])) {
			return number_format($number, 2, $decimal_point, $thousand_point) . $this->weight_classes[$weight_class_id]['unit'];
		} else {
			return number_format($number, 2, $decimal_point, $thousand_point);
		}
    }

    /**
     * Convert.
     *
     */
    public function convert($number, $from, $to)
    {
		if ($from == $to) {
			return $number;
		}

		if (isset($this->weight_classes[$from])) {
			$from = $this->weight_classes[$from]['value'];
		} else {
			$from = 1;
		}

		if (isset($this->weight_classes[$to])) {
			$to = $this->weight_classes[$to]['value'];
		} else {
			$to = 1;
		}

		return $number * ($to / $from);
    }
}