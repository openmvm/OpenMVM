<?php

namespace App\Libraries;

class Currency
{
	private $currencies = array();

	public function __construct()
	{
		// Load Libraries
		$this->session = session();
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = db_connect();

		// Get Currencies
		$builder = $this->db->table('currency');

		$query   = $builder->get();

		foreach ($query->getResult() as $row)
		{
		  $this->currencies[$row->code] = array(
	      'currency_id'   => $row->currency_id,
	      'title'         => $row->title,
	      'code'          => $row->code,
	      'symbol_left'   => $row->symbol_left,
	      'symbol_right'  => $row->symbol_right,
	      'decimal_place' => $row->decimal_place,
	      'value'         => $row->value,
	      'status'        => $row->status,
	      'date_modified' => $row->date_modified,
		  );
		}
	}

	public function format($number, $currency, $value = '', $format = true) {
		$symbol_left = $this->currencies[$currency]['symbol_left'];
		$symbol_right = $this->currencies[$currency]['symbol_right'];
		$decimal_place = $this->currencies[$currency]['decimal_place'];

		if (!$value) {
			$value = $this->currencies[$currency]['value'];
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

		$string .= number_format($amount, (int)$decimal_place, '.', ',');

		if ($symbol_right) {
			$string .= $symbol_right;
		}

		return $string;
	}

	public function convert($value, $from, $to) {
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

		return $value * ($to / $from);
	}

  public function getBackEndValue()
  {
  	$currency = $this->getCurrencyByCode($this->getBackEndCode());

  	$value = $currency['value'];

    return $value;
  }

  public function getBackEndId()
  {
  	$currency = $this->getCurrencyByCode($this->getBackEndCode());

  	$currency_id = $currency['currency_id'];

    return $currency_id;
  }

  public function getBackEndCode()
  {
  	if ($this->session->has('backend_currency')) {
	  	$code = $this->session->get('backend_currency');
  	} else {
	  	$code = $this->setting->get('setting', 'setting_backend_currency');
  	}

    return $code;
  }

  public function getFrontEndValue()
  {
  	$currency = $this->getCurrencyByCode($this->getFrontEndCode());

  	$value = $currency['value'];

    return $value;
  }

  public function getFrontEndId()
  {
  	$currency = $this->getCurrencyByCode($this->getFrontEndCode());

  	$currency_id = $currency['currency_id'];

    return $currency_id;
  }

  public function getFrontEndCode()
  {
  	if ($this->session->has('frontend_currency')) {
	  	$code = $this->session->get('frontend_currency');
  	} else {
	  	$code = $this->setting->get('setting', 'setting_frontend_currency');
  	}

    return $code;
  }

  public function getCurrencyByCode($code)
  {
		$builder_currency = $this->db->table('currency');
		$builder_currency->where('code', $code);

		$query_currency = $builder_currency->get();
		
		$row_currency = $query_currency->getRow();

  	$currency_data = array(
  		'currency_id' => $row_currency->currency_id,
  		'title' => $row_currency->title,
  		'code' => $row_currency->code,
  		'symbol_left' => $row_currency->symbol_left,
  		'symbol_right' => $row_currency->symbol_right,
  		'decimal_place' => $row_currency->decimal_place,
  		'value' => $row_currency->value,
  		'status' => $row_currency->status,
  		'date_modified' => $row_currency->date_modified,
  	);

    return $currency_data;
  }
}