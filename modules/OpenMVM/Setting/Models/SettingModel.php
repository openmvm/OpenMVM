<?php

namespace Modules\OpenMVM\Setting\Models;

class SettingModel extends \CodeIgniter\Model
{
  protected $table = 'setting';

  protected $allowedFields = ['code', 'key', 'value', 'serialized'];

	public function __construct()
	{
		// Load Database
		$this->db = db_connect();
	}

	public function editSettings($code, $data = array())
	{
    $this->where('code', $code)->delete();

    foreach ($data as $key => $value) {
      if (substr($key, 0, strlen($code)) == $code) {
        if (!is_array($value)) {
          $query_data = array(
            'code'   => $code,
            'key'    => $key,
            'value'  => $value
          );

		      $this->insert($query_data);
        } else {
          $query_data = array(
            'code'       => $code,
            'key'        => $key,
            'value'      => json_encode($value, true),
            'serialized' => '1'
          );

		      $this->insert($query_data);
        }
      }
    }

    return true;
	}

  public function editSetting($code, $key, $value)
  {
    $builder = $this->db->table('setting');

    $query_data = array(
      'value' => $value,
    );

    $builder->where('code', $code);
    $builder->where('key', $key);
    $query = $builder->update($query_data);

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

	public function getSettingValue($code, $key)
	{
		$result = '';
		
		$builder = $this->db->table('setting');

	  $query_data = array(
	    'code'       => $code,
	    'key'        => $key,
	  );

		$query = $builder->getWhere($query_data);
		
		foreach ($query->getResult() as $row) {
			$result = $row->value;
		}

    if ($result) {
      return $result;
    } else {
      return null;
    }
	}
}