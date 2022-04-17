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

class Currency {
    private $currencies = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();

        // Libraries
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();

        // Get currencies
        $currency_builder = $this->db->table('currency');

        $currency_query = $currency_builder->get();

        $currencies = [];

        foreach ($currency_query->getResult() as $result) {
            $this->currencies[$result->code] = [
                'currency_id' => $result->currency_id,
                'name' => $result->name,
                'code' => $result->code,
                'symbol_left' => $result->symbol_left,
                'symbol_right' => $result->symbol_right,
                'decimal_place' => $result->decimal_place,
                'value' => $result->value,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }
    }

    /**
     * Format.
     *
     */
    public function format($number, $code, $value = '', $format = true)
    {
		$symbol_left = $this->currencies[$code]['symbol_left'];
		$symbol_right = $this->currencies[$code]['symbol_right'];
		$decimal_place = $this->currencies[$code]['decimal_place'];

		if (!$value) {
			$value = $this->currencies[$code]['value'];
		}

		$amount = $value ? (float)$number * $value : (float)$number;
		
		$amount = round($amount, (int)$decimal_place);
		
		if (!$format) {
			return $amount;
		}

		$string = '';

		if ($symbol_left) {
			$string .= $symbol_left;
		}

		$string .= number_format($amount, (int)$decimal_place, lang('Common.decimal_point', [], $this->language->getCurrentCode()), lang('Common.thousand_point', [], $this->language->getCurrentCode()));

		if ($symbol_right) {
			$string .= $symbol_right;
		}

		return $string;
    }

    /**
     * Convert.
     *
     */
    public function convert($number, $from, $to)
    {
		if (isset($this->currencies[$from])) {
			$from = $this->currencies[$from]['value'];
		} else {
			$from = 1;
		}

		if (isset($this->currencies[$to])) {
			$to = $this->currencies[$to]['value'];
		} else {
			$to = 1;
		}

		return $number * ($to / $from);
    }

    /**
     * Get info.
     *
     */
    public function getInfo($code)
    {
        $builder = $this->db->table('currency');
        
        $builder->where('code', $code);

        $currency_query = $builder->get();

        $currency = [];

        if ($row = $currency_query->getRow()) {
            $currency = [
                'currency_id' => $row->currency_id,
                'name' => $row->name,
                'code' => $row->code,
                'symbol_left' => $row->symbol_left,
                'symbol_right' => $row->symbol_right,
                'decimal_place' => $row->decimal_place,
                'value' => $row->value,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $currency;
    }

    /**
     * Get current value.
     *
     */
    public function getCurrentValue()
    {
        if ($this->session->has('marketplace_currency_id')) {
            $value = $this->getValue($this->session->get('marketplace_currency_id'));
        } elseif (!empty($this->setting->get('setting_marketplace_currency_id'))) {
            $value = $this->getValue($this->setting->get('setting_marketplace_currency_id'));
        } else {
            $value = 1;
        }

        return $value;
    }

    /**
     * Get current code.
     *
     */
    public function getCurrentCode()
    {
        if ($this->session->has('marketplace_currency_id')) {
            $code = $this->getCode($this->session->get('marketplace_currency_id'));
        } elseif (!empty($this->setting->get('setting_marketplace_currency_id'))) {
            $code = $this->getCode($this->setting->get('setting_marketplace_currency_id'));
        } else {
            $code = 'USD';
        }

        return $code;
    }

    /**
     * Get current id.
     *
     */
    public function getCurrentId()
    {
        if ($this->session->has('marketplace_currency_id')) {
            $currency_id = $this->session->get('marketplace_currency_id');
        } elseif (!empty($this->setting->get('setting_marketplace_currency_id'))) {
            $currency_id = $this->setting->get('setting_marketplace_currency_id');
        } else {
            $currency_id = 1;
        }

        return $currency_id;
    }

    /**
     * Get default value.
     *
     */
    public function getDefaultValue()
    {
        if (!empty($this->setting->get('setting_marketplace_currency_id'))) {
            $value = $this->getValue($this->setting->get('setting_marketplace_currency_id'));
        } else {
            $value = 1;
        }

        return $value;
    }

    /**
     * Get default code.
     *
     */
    public function getDefaultCode()
    {
        if (!empty($this->setting->get('setting_marketplace_currency_id'))) {
            $code = $this->getCode($this->setting->get('setting_marketplace_currency_id'));
        } else {
            $code = 'USD';
        }

        return $code;
    }

    /**
     * Get default id.
     *
     */
    public function getDefaultId()
    {
        if (!empty($this->setting->get('setting_marketplace_currency_id'))) {
            $currency_id = $this->setting->get('setting_marketplace_currency_id');
        } else {
            $currency_id = 1;
        }

        return $currency_id;
    }

    /**
     * Get value.
     *
     */
    public function getValue($currency_id)
    {
        $builder = $this->db->table('currency');
        
        $builder->where('currency_id', $currency_id);

        $currency_query = $builder->get();

        $value = false;

        if ($row = $currency_query->getRow()) {
            $value = $row->value;
        }

        return $value;
    }

    /**
     * Get code.
     *
     */
    public function getCode($currency_id)
    {
        $builder = $this->db->table('currency');
        
        $builder->where('currency_id', $currency_id);

        $currency_query = $builder->get();

        $code = false;

        if ($row = $currency_query->getRow()) {
            $code = $row->code;
        }

        return $code;
    }

    /**
     * Get id.
     *
     */
    public function getId($code)
    {
        $builder = $this->db->table('currency');
        
        $builder->where('code', $code);

        $currency_query = $builder->get();

        $currency_id = false;

        if ($row = $currency_query->getRow()) {
            $currency_id = $row->currency_id;
        }

        return $currency_id;
    }

    /**
     * Refresh.
     *
     */
    public function refresh($default)
    {
        if (!empty($default)) {
            $base_currency = $default;
        } else {
            $base_currency = 'USD';
        }

        // latest rates
        $url = "https://api.currencyapi.com/v2/latest?apikey=69d26dd0-6d1e-11ec-ac55-2914da9bf7b7&base_currency=" . $base_currency;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
            
        return json_decode($response, true);
    }
}