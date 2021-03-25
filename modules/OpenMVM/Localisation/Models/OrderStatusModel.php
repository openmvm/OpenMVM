<?php

namespace Modules\OpenMVM\Localisation\Models;

class OrderStatusModel extends \CodeIgniter\Model
{

  protected $table = 'order_status';
	protected $primaryKey = 'order_status_id';
  protected $allowedFields = ['order_status_id', 'language_id', 'name'];

	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		// Load Database
		$this->db = db_connect();
	}

	public function addOrderStatus($data = array())
	{
		foreach ($data['order_status'] as $language_id => $value) {
			if (!empty($order_status_id)) {
				$builder = $this->db->table('order_status');

		    $query_data = array(
		      'order_status_id' => $order_status_id,
		      'language_id' => $language_id,
		      'name' => $value['name'],
		    );

				$builder->insert($query_data);
			} else {
				$builder = $this->db->table('order_status');

		    $query_data = array(
		      'language_id' => $language_id,
		      'name' => $value['name'],
		    );

				$builder->insert($query_data);

				$order_status_id = $this->db->insertID();
			}
		}

		return $order_status_id;
	}

	public function editOrderStatus($order_status_id, $data = array())
	{
		$builder = $this->db->table('order_status');
		$builder->where('order_status_id', $order_status_id);
		$builder->delete();

		$builder = $this->db->table('order_status');

    $query_data = array(
      'order_status_id' => $order_status_id,
      'language_id' => $language_id,
      'name' => $value['name'],
    );

		$builder->where('order_status', $order_status);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteOrderStatus($order_status_id)
	{
		$builder = $this->db->table('order_status');
		$builder->where('order_status_id', $order_status_id);
		$builder->delete();
	}

	public function getOrderStatus($order_status_id)
	{
		return $this->asArray()->where(['order_status_id' => $order_status_id, 'language_id' => $this->language->getBackEndId()])->first();
	}

	public function getOrderStatuses($data = array())
	{
		$results = array();

		$builder = $this->db->table('order_status');

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
        'order_status_id' => $row->order_status_id,
	      'language_id' => $row->language_id,
		  	'name' => $row->name,
		  );
		}

		return $results;
	}

	public function getOrderStatusDescriptions($order_status_id) {
		$order_status_data = array();

		$builder = $this->db->table('order_status');
		$builder->where('order_status_id', $order_status_id);

		$query   = $builder->get();

		foreach ($query->getResult() as $row)
		{
			$order_status_data[$row->language_id] = array('name' => $row->name);
		}

		return $order_status_data;
	}

	public function getTotalOrderStatuses($data = array())
	{
		$results = array();

		$builder = $this->db->table('order_status');
		$builder->where('language_id', $this->language->getBackEndId());
    
		$query = $builder->countAllResults();

		return $query;
	}
}