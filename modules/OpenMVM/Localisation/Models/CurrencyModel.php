<?php

namespace Modules\OpenMVM\Localisation\Models;

class CurrencyModel extends \CodeIgniter\Model
{

  protected $table = 'currency';
	protected $primaryKey = 'currency_id';
  protected $allowedFields = ['currency_id', 'title'];

	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = db_connect();
	}

	public function addCurrency($data = array())
	{
		$builder = $this->db->table('currency');

    $query_data = array(
      'title'         => $data['title'],
      'code'          => $data['code'],
      'symbol_left'   => $data['symbol_left'],
      'symbol_right'  => $data['symbol_right'],
      'decimal_place' => $data['decimal_place'],
      'value'         => $data['value'],
      'status'        => $data['status'],
      'date_modified' => $data['date_modified'],
    );

		$builder->insert($query_data);

		return $this->db->insertID();
	}

	public function getCurrencies($data = array())
	{
		$results = array();

		$builder = $this->db->table('currency');

		if (!empty($data['sort']) && !empty($data['order'])) {
			$builder->orderBy($data['sort'], $data['order']);
		}
    if (!empty($data['start']) || !empty($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $builder->limit($data['limit'], $data['start']);
    }

		$query   = $builder->get();

		foreach ($query->getResult() as $row)
		{
		  $results[] = array(
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

		return $results;
	}

	public function getCurrency($currency_id)
	{
		return $this->asArray()->where(['currency_id' => $currency_id])->first();
	}

	public function getCurrencyByCode($code)
	{
		return $this->asArray()->where(['code' => $code])->first();
	}

	public function editCurrency($data = array(), $currency_id)
	{
		$builder = $this->db->table('currency');

    $query_data = array(
      'title'         => $data['title'],
      'code'          => $data['code'],
      'symbol_left'   => $data['symbol_left'],
      'symbol_right'  => $data['symbol_right'],
      'decimal_place' => $data['decimal_place'],
      'value'         => $data['value'],
      'status'        => $data['status'],
      'date_modified' => $data['date_modified'],
    );

		$builder->where('currency_id', $currency_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteCurrency($currency_id)
	{
		$builder = $this->db->table('currency');
		$builder->where('currency_id', $currency_id);
		$builder->delete();
	}

	public function getTotalCurrencies($data = array())
	{
		$results = array();

		$builder = $this->db->table('currency');
    
		$query = $builder->countAllResults();

		return $query;
	}
}