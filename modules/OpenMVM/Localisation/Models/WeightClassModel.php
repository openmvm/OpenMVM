<?php

namespace Modules\OpenMVM\Localisation\Models;

class WeightClassModel extends \CodeIgniter\Model
{

  protected $table = 'weight_class';
	protected $primaryKey = 'weight_class_id';
  protected $allowedFields = ['weight_class_id', 'value', 'sort_order', 'status'];

	public function __construct()
	{
		// Load Libraries
		$this->session = \Config\Services::session();
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		$this->phpmailer_lib = new \App\Libraries\PHPMailer_lib;
		$this->auth = new \App\Libraries\Auth;
		$this->text = new \App\Libraries\Text;
		// Load Database
		$this->db = db_connect();
	}

	public function addWeightClass($data = array())
	{
		$builder = $this->db->table('weight_class');

		if ($data['value'] !== null) {
			$builder->set('value', $data['value']);
		}

		if ($data['sort_order'] !== null) {
			$builder->set('sort_order', $data['sort_order']);
		}

		if ($data['status'] !== null) {
			$builder->set('status', $data['status']);
		}

		$builder->insert($query_data);

		$weight_class_id = $this->db->insertID();

    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'weight_class_id' => $weight_class_id,
        'language_id' => $language_id,
        'title' => $value['title'],
        'unit' => $value['unit'],
      );

			$builder = $this->db->table('weight_class_description');

			$builder->insert($query_data_2);
		}

		return $weight_class_id;
	}

	public function editWeightClass($data = array(), $weight_class_id)
	{
		// Update Weight Class
		$builder = $this->db->table('weight_class');

		if ($data['value'] !== null) {
			$builder->set('value', $data['value']);
		}

		if ($data['sort_order'] !== null) {
			$builder->set('sort_order', $data['sort_order']);
		}

		if ($data['status'] !== null) {
			$builder->set('status', $data['status']);
		}

    $builder->where('weight_class_id', $weight_class_id);
		$builder->update($query_data);

		// Delete Old Weight Class Description
		$builder = $this->db->table('weight_class_description');
    $builder->where('weight_class_id', $weight_class_id);
		$builder->delete();

		// Insert New Weight Class Description
    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'weight_class_id' => $weight_class_id,
        'language_id' => $language_id,
        'title' => $value['title'],
        'unit' => $value['unit'],
      );

			$builder = $this->db->table('weight_class_description');
			$builder->insert($query_data_2);
		}

		return $weight_class_id;
	}

	public function deleteWeightClass($weight_class_id)
	{
		$builder = $this->db->table('weight_class');
		$builder->where('weight_class_id', $weight_class_id);
		$builder->delete();

		$builder = $this->db->table('weight_class_description');
		$builder->where('weight_class_id', $weight_class_id);
		$builder->delete();
	}

	public function getWeightClasses($data = array(), $language_id)
	{
		$builder = $this->db->table('weight_class');
		$builder->select('*');
		$builder->join('weight_class_description', 'weight_class_description.weight_class_id = weight_class.weight_class_id');

		if (!empty($data['filter_name'])) {
      $builder->like('weight_class_description.title', $data['filter_name']);
		}

		$builder->where('weight_class_description.language_id', $language_id);

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
    
		$query = $builder->get();

		$results = array();

		foreach ($query->getResult() as $row)
		{
		  $results[] = array(
	      'weight_class_id' => $row->weight_class_id,
	      'value'           => $row->value,
	      'sort_order'      => $row->sort_order,
	      'status'          => $row->status,
				'title'           => $row->title,
				'unit'            => $row->unit,
		  );
		}

		return $results;
	}

	public function getWeightClass($weight_class_id)
	{
		return $this->asArray()->where(['weight_class_id' => $weight_class_id])->first();
	}

	public function getWeightClassDescriptions($weight_class_id)
	{
		$builder = $this->db->table('weight_class_description');
		$builder->where('weight_class_id', $weight_class_id);
		$query = $builder->get();

		$results = array();

		foreach ($query->getResult() as $row)
		{
			$results[$row->language_id] = array(
				'weight_class_id' => $row->weight_class_id,
				'title'           => $row->title,
				'unit'            => $row->unit,
			);
		}

		return $results;
	}

	public function getWeightClassDescription($weight_class_id, $language_id)
	{
		$builder = $this->db->table('weight_class_description');
		$builder->where('weight_class_id', $weight_class_id);
		$builder->where('language_id', $language_id);
		$query = $builder->get();

		$row = $query->getRow();

		$result = array(
			'weight_class_id' => $row->weight_class_id,
			'title'           => $row->title,
			'unit'            => $row->unit,
		);

		return $result;
	}

	public function getTotalWeightClasses($data = array(), $language_id)
	{
		$builder = $this->db->table('weight_class');
		$builder->select('*');
		$builder->join('weight_class_description', 'weight_class_description.weight_class_id = weight_class.weight_class_id');

		if (!empty($data['filter_name'])) {
      $builder->like('weight_class_description.title', $data['filter_name']);
		}

		$builder->where('weight_class_description.language_id', $language_id);
    
		$query = $builder->countAllResults();

		return $query;
	}
}