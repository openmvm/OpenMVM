<?php

namespace Modules\OpenMVM\Localisation\Models;

class GeoZoneModel extends \CodeIgniter\Model
{

  protected $table = 'geo_zone';
	protected $primaryKey = 'geo_zone_id';
  protected $allowedFields = ['geo_zone_id', 'date_added', 'date_modified'];

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

	public function addGeoZone($data = array())
	{
		$builder = $this->db->table('geo_zone');

		if ($data['date_added'] !== null) {
			$builder->set('date_added', $data['date_added']);
		} else {
			$builder->set('date_added', date("Y-m-d H:i:s",now()));
		}

		if ($data['date_modified'] !== null) {
			$builder->set('date_modified', $data['date_modified']);
		} else {
			$builder->set('date_modified', date("Y-m-d H:i:s",now()));
		}

		$builder->insert();

		$geo_zone_id = $this->db->insertID();

    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'geo_zone_id' => $geo_zone_id,
        'language_id' => $language_id,
        'name' => $value['name'],
        'description' => $value['description'],
      );

			$builder = $this->db->table('geo_zone_description');

			$builder->insert($query_data_2);
		}

		if (!empty($data['state_to_geo_zone'])) {
			foreach ($data['state_to_geo_zone'] as $value) {
				$builder = $this->db->table('state_to_geo_zone');
				$builder->where('geo_zone_id', $geo_zone_id);
				$builder->where('country_id', $value['country_id']);
				$builder->where('state_id', $value['state_id']);
				$builder->delete();

				$builder = $this->db->table('state_to_geo_zone');
				$builder->set('geo_zone_id', $geo_zone_id);
				$builder->set('country_id', $value['country_id']);
				$builder->set('state_id', $value['state_id']);
				$builder->set('date_added', date("Y-m-d H:i:s",now()));
				$builder->insert();
			}
		}

		return $geo_zone_id;
	}

	public function editGeoZone($data = array(), $geo_zone_id)
	{
		// Update Geo Zone
		$builder = $this->db->table('geo_zone');

		if ($data['date_added'] !== null) {
			$builder->set('date_added', $data['date_added']);
		}

		if ($data['date_modified'] !== null) {
			$builder->set('date_modified', $data['date_modified']);
		} else {
			$builder->set('date_modified', date("Y-m-d H:i:s",now()));
		}

    $builder->where('geo_zone_id', $geo_zone_id);
		$builder->update($query_data);

		// Delete Old Geo Zone Description
		$builder = $this->db->table('geo_zone_description');
    $builder->where('geo_zone_id', $geo_zone_id);
		$builder->delete();

		// Insert New Geo Zone Description
    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'geo_zone_id' => $geo_zone_id,
        'language_id' => $language_id,
        'name' => $value['name'],
        'description' => $value['description'],
      );

			$builder = $this->db->table('geo_zone_description');
			$builder->insert($query_data_2);
		}

			$builder = $this->db->table('state_to_geo_zone');
			$builder->where('geo_zone_id', $geo_zone_id);
			$builder->delete();

		if (!empty($data['state_to_geo_zone'])) {
			foreach ($data['state_to_geo_zone'] as $value) {
				$builder = $this->db->table('state_to_geo_zone');
				$builder->where('geo_zone_id', $geo_zone_id);
				$builder->where('country_id', $value['country_id']);
				$builder->where('state_id', $value['state_id']);
				$builder->delete();

				$builder = $this->db->table('state_to_geo_zone');
				$builder->set('geo_zone_id', $geo_zone_id);
				$builder->set('country_id', $value['country_id']);
				$builder->set('state_id', $value['state_id']);
				$builder->set('date_added', date("Y-m-d H:i:s",now()));
				$builder->insert();
			}
		}

		return $geo_zone_id;
	}

	public function deleteGeoZone($geo_zone_id)
	{
		$builder = $this->db->table('geo_zone');
		$builder->where('geo_zone_id', $geo_zone_id);
		$builder->delete();

		$builder = $this->db->table('geo_zone_description');
		$builder->where('geo_zone_id', $geo_zone_id);
		$builder->delete();

		$builder = $this->db->table('state_to_geo_zone');
		$builder->where('geo_zone_id', $geo_zone_id);
		$builder->delete();
	}

	public function getGeoZones($data = array(), $language_id)
	{
		$builder = $this->db->table('geo_zone');
		$builder->select('*');
		$builder->join('geo_zone_description', 'geo_zone_description.geo_zone_id = geo_zone.geo_zone_id');

		if (!empty($data['filter_name'])) {
      $builder->like('geo_zone_description.name', $data['filter_name']);
		}

		$builder->where('geo_zone_description.language_id', $language_id);

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
	      'geo_zone_id' => $row->geo_zone_id,
	      'name' => $row->name,
	      'description' => $row->description,
	      'date_added' => $row->date_added,
				'date_modified' => $row->date_modified,
		  );
		}

		return $results;
	}

	public function getGeoZone($geo_zone_id)
	{
		return $this->asArray()->where(['geo_zone_id' => $geo_zone_id])->first();
	}

	public function getGeoZoneDescriptions($geo_zone_id)
	{
		$builder = $this->db->table('geo_zone_description');
		$builder->where('geo_zone_id', $geo_zone_id);
		$query = $builder->get();

		$results = array();

		foreach ($query->getResult() as $row)
		{
			$results[$row->language_id] = array(
				'geo_zone_id' => $row->geo_zone_id,
				'name' => $row->name,
				'description' => $row->description,
			);
		}

		return $results;
	}

	public function getGeoZoneDescription($geo_zone_id)
	{
		$builder = $this->db->table('geo_zone_description');
		$builder->where('geo_zone_id', $geo_zone_id);
		$builder->where('language_id', $this->language->getFrontEndId());
		$query = $builder->get();

		$row = $query->getRow();

		$result = array(
			'geo_zone_id' => $row->geo_zone_id,
			'name' => $row->name,
			'description' => $row->description,
		);

		return $result;
	}

	public function getTotalGeoZones($data = array(), $language_id)
	{
		$builder = $this->db->table('geo_zone');
		$builder->select('*');
		$builder->join('geo_zone_description', 'geo_zone_description.geo_zone_id = geo_zone.geo_zone_id');

		if (!empty($data['filter_name'])) {
      $builder->like('geo_zone_description.name', $data['filter_name']);
		}

		$builder->where('geo_zone_description.language_id', $language_id);
    
		$query = $builder->countAllResults();

		return $query;
	}

	public function getStateToGeoZones($geo_zone_id) {
		$builder = $this->db->table('state_to_geo_zone');
		$builder->where('geo_zone_id', $geo_zone_id);
		$query = $builder->get();

		$results = $query->getResultArray();

		return $results;
	}

	public function getTotalStateToGeoZoneByGeoZoneId($geo_zone_id) {
		$builder = $this->db->table('state_to_geo_zone');
		$builder->where('geo_zone_id', $geo_zone_id);
		$query = $builder->get();

		$query = $builder->countAllResults();

		return $query;
	}

	public function getTotalStateToGeoZoneByCountryId($country_id) {
		$builder = $this->db->table('state_to_geo_zone');
		$builder->where('country_id', $country_id);
		$query = $builder->get();

		$query = $builder->countAllResults();

		return $query;
	}

	public function getTotalStateToGeoZoneByStateId($state_id) {
		$builder = $this->db->table('state_to_geo_zone');
		$builder->where('state_id', $state_id);
		$query = $builder->get();

		$query = $builder->countAllResults();

		return $query;
	}
}