<?php

namespace Modules\OpenMVM\Localisation\Models;

class LanguageModel extends \CodeIgniter\Model
{

  protected $table = 'language';
	protected $primaryKey = 'language_id';
  protected $allowedFields = ['language_id', 'name'];

	public function __construct()
	{
		// Load Services
		$this->uri = service('uri');
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		// Load Helper
		helper(['url']);
		// Load Database
		$this->db = db_connect();
	}

	public function addLanguage($data = array())
	{
		$builder = $this->db->table('language');

    $query_data = array(
      'name'       => $data['name'],
      'code'       => $data['code'],
      'locale'     => $data['locale'],
      'image'      => $data['image'],
      'directory'  => $data['directory'],
      'sort_order' => $data['sort_order'],
      'status'     => $data['status'],
    );

		$builder->insert($query_data);

		return $this->db->insertID();
	}

	public function getLanguages($data = array())
	{
		$results = array();

		$builder = $this->db->table('language');

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
        'language_id' => $row->language_id,
		  	'name'        => $row->name,
	      'code'        => $row->code,
	      'locale'      => $row->locale,
	      'image'       => $row->image,
	      'directory'   => $row->directory,
	      'sort_order'  => $row->sort_order,
	      'status'      => $row->status,
		  );
		}

		return $results;
	}

	public function getLanguage($language_id)
	{
		return $this->asArray()->where(['language_id' => $language_id])->first();
	}

	public function getLanguageByCode($code)
	{
		return $this->asArray()->where(['code' => $code])->first();
	}

	public function editLanguage($data = array(), $language_id)
	{
		$builder = $this->db->table('language');

    $query_data = array(
      'name'       => $data['name'],
      'code'       => $data['code'],
      'locale'     => $data['locale'],
      'image'      => $data['image'],
      'directory'  => $data['directory'],
      'sort_order' => $data['sort_order'],
      'status'     => $data['status'],
    );

		$builder->where('language_id', $language_id);
		$query = $builder->update($query_data);

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteLanguage($language_id)
	{
		$builder = $this->db->table('language');
		$builder->where('language_id', $language_id);
		$builder->delete();
	}

	public function getTotalLanguages($data = array())
	{
		$results = array();

		$builder = $this->db->table('language');
    
		$query = $builder->countAllResults();

		return $query;
	}
}