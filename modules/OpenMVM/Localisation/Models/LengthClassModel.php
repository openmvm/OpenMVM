<?php

namespace Modules\OpenMVM\Localisation\Models;

class LengthClassModel extends \CodeIgniter\Model
{

  protected $table = 'length_class';
	protected $primaryKey = 'length_class_id';
  protected $allowedFields = ['length_class_id', 'value', 'sort_order', 'status'];

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

	public function addLengthClass($data = array())
	{
		$builder = $this->db->table('length_class');

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

		$length_class_id = $this->db->insertID();

    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'length_class_id' => $length_class_id,
        'language_id' => $language_id,
        'title' => $value['title'],
        'unit' => $value['unit'],
      );

			$builder = $this->db->table('length_class_description');

			$builder->insert($query_data_2);
		}

		return $length_class_id;
	}

	public function editLengthClass($data = array(), $length_class_id)
	{
		// Update Length Class
		$builder = $this->db->table('length_class');

		if ($data['value'] !== null) {
			$builder->set('value', $data['value']);
		}

		if ($data['sort_order'] !== null) {
			$builder->set('sort_order', $data['sort_order']);
		}

		if ($data['status'] !== null) {
			$builder->set('status', $data['status']);
		}

    $builder->where('length_class_id', $length_class_id);
		$builder->update($query_data);

		// Delete Old Length Class Description
		$builder = $this->db->table('length_class_description');
    $builder->where('length_class_id', $length_class_id);
		$builder->delete();

		// Insert New Length Class Description
    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'length_class_id' => $length_class_id,
        'language_id' => $language_id,
        'title' => $value['title'],
        'unit' => $value['unit'],
      );

			$builder = $this->db->table('length_class_description');
			$builder->insert($query_data_2);
		}

		return $length_class_id;
	}

	public function deleteLengthClass($length_class_id)
	{
		$builder = $this->db->table('length_class');
		$builder->where('length_class_id', $length_class_id);
		$builder->delete();

		$builder = $this->db->table('length_class_description');
		$builder->where('length_class_id', $length_class_id);
		$builder->delete();
	}

	public function getLengthClasses($data = array())
	{
		$builder = $this->db->table('length_class');
		$builder->select('*');
		$builder->join('length_class_description', 'length_class_description.length_class_id = length_class.length_class_id');

		if (!empty($data['filter_name'])) {
      $builder->like('length_class_description.title', $data['filter_name']);
		}

		$builder->where('length_class_description.language_id', $this->language->getFrontEndId());

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
	      'length_class_id' => $row->length_class_id,
	      'value'           => $row->value,
	      'sort_order'      => $row->sort_order,
	      'status'          => $row->status,
				'title'           => $row->title,
				'unit'            => $row->unit,
		  );
		}

		return $results;
	}

	public function getLengthClass($length_class_id)
	{
		return $this->asArray()->where(['length_class_id' => $length_class_id])->first();
	}

	public function getLengthClassDescriptions($length_class_id)
	{
		$builder = $this->db->table('length_class_description');
		$builder->where('length_class_id', $length_class_id);
		$query = $builder->get();

		$results = array();

		foreach ($query->getResult() as $row)
		{
			$results[$row->language_id] = array(
				'length_class_id' => $row->length_class_id,
				'title'           => $row->title,
				'unit'            => $row->unit,
			);
		}

		return $results;
	}

	public function getLengthClassDescription($length_class_id)
	{
		$builder = $this->db->table('length_class_description');
		$builder->where('length_class_id', $length_class_id);
		$builder->where('language_id', $this->language->getFrontEndId());
		$query = $builder->get();

		$row = $query->getRow();

		$result = array(
			'length_class_id' => $row->length_class_id,
			'title'           => $row->title,
			'unit'            => $row->unit,
		);

		return $result;
	}

	public function getTotalLengthClasses($data = array())
	{
		$builder = $this->db->table('length_class');
		$builder->select('*');
		$builder->join('length_class_description', 'length_class_description.length_class_id = length_class.length_class_id');

		if (!empty($data['filter_name'])) {
      $builder->like('length_class_description.title', $data['filter_name']);
		}

		$builder->where('length_class_description.language_id', $this->language->getBackEndId());
    
		$query = $builder->countAllResults();

		return $query;
	}
}