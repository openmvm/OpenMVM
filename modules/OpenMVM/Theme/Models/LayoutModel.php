<?php

namespace Modules\OpenMVM\Theme\Models;

class LayoutModel extends \CodeIgniter\Model
{

  protected $table = 'layout';
	protected $primaryKey = 'layout_id';
  protected $allowedFields = ['layout_id', 'location', 'name'];

	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		// Load Database
		$this->db = db_connect();
	}

	public function addLayout($location, $data = array())
	{
		$builder_layout = $this->db->table('layout');

    $query_data_layout = array(
      'location' => $location,
      'name' => $data['name'],
    );

		$builder_layout->insert($query_data_layout);

		$layout_id = $this->db->insertID();

		if (!empty($data['layout_route'])) {
			foreach ($data['layout_route'] as $layout_route) {
				$builder_layout_route = $this->db->table('layout_route');

		    $query_data_layout_route = array(
		      'layout_id' => $layout_id,
		      'route' => $layout_route['route'],
		    );

				$builder_layout_route->insert($query_data);
			}
		}

		return $layout_id;
	}

	public function editLayout($location, $data = array(), $layout_id)
	{
		$builder_layout = $this->db->table('layout');

    $query_data_layout = array(
      'name'       => $data['name'],
    );

		$builder_layout->where('layout_id', $layout_id);
		$builder_layout->where('location', $location);
		$query_layout = $builder_layout->update($query_data_layout);

		$builder_layout_route = $this->db->table('layout_route');
		$builder_layout_route->where('layout_id', $layout_id);
		$builder_layout_route->delete();

		if (!empty($data['layout_route'])) {
			foreach ($data['layout_route'] as $layout_route) {
				$builder_layout_route = $this->db->table('layout_route');

		    $query_data_layout_route = array(
		      'layout_id' => $layout_id,
		      'route' => $layout_route['route'],
		    );

				$builder_layout_route->insert($query_data_layout_route);
			}
		}

		if ($query_layout) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteLayout($location, $layout_id)
	{
		$builder = $this->db->table('layout');
		$builder->where('layout_id', $layout_id);
		$builder->where('location', $location);
		$builder->delete();
	}

	public function getLayouts($location, $data = array())
	{
		$results = array();

		$builder = $this->db->table('layout');
		$builder->where('location', $location);

		if (!empty($data['sort']) && !empty($data['order'])) {
			$builder->orderBy($data['sort'], $data['order']);
		} else {
			$builder->orderBy('name', 'ASC');
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
        'layout_id'    => $row->layout_id,
		  	'name'        => $row->name,
		  );
		}

		return $results;
	}

	public function getLayout($location, $layout_id)
	{
		return $this->asArray()->where(['layout_id' => $layout_id, 'location' => $location])->first();
	}

	public function getLayoutRoutes($layout_id) {
		$builder = $this->db->table('layout_route');
		$builder->where('layout_id', $layout_id);
		$builder->orderBy('route', 'ASC');

		$query   = $builder->get();

		return $query->getResultArray();;
	}

	public function getLayoutModules($location, $layout_id) {
		$builder = $this->db->table('layout_module');
		$builder->where('layout_id', $layout_id);
		$builder->where('location', $location);
		$builder->orderBy('position', 'ASC');
		$builder->orderBy('sort_order', 'ASC');

		$query   = $builder->get();

		return $query->getResultArray();
	}

	public function getTotalLayouts($location, $data = array())
	{
		$results = array();

		$builder = $this->db->table('layout');
		$builder->where('location', $location);
    
		$query = $builder->countAllResults();

		return $query;
	}
}