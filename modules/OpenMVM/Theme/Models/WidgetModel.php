<?php

namespace Modules\OpenMVM\Theme\Models;

class WidgetModel extends \CodeIgniter\Model
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		// Load Database
		$this->db = db_connect();
	}
  public function addWidget($location, $provider, $dir, $code)
  {
    $builder = $this->db->table('widget');

    $query_data = array(
      'location' => $location,
      'provider' => $provider,
      'dir'      => $dir,
      'name'     => '',
      'code'     => $code,
      'setting'  => '',
      'status'   => 0,
    );

    $builder->insert($query_data);

    return $this->db->insertID();
  }

  public function editWidget($widget_id, $data = array())
  {
    $builder = $this->db->table('widget');

    $query_data = array(
      'name'      => $data['name'],
      'setting'   => json_encode($data),
      'status'    => $data['status'],
    );

    $builder->where('widget_id', $widget_id);
    $query = $builder->update($query_data);

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public function deleteWidget($widget_id)
  {
    $builder = $this->db->table('widget');
    $builder->where('widget_id', $widget_id);
    $builder->delete();
  }

	public function getInstalled($location) {
		$widget_data = array();

		$builder = $this->db->table('widget_install');
		$builder->where('location', $location);
		$builder->orderBy('code', 'ASC');
		$query = $builder->get();

		foreach ($query->getResult() as $result) {
			$widget_data[] = array(
				'provider' => $result->provider,
				'dir' => $result->dir,
				'code' => $result->code,
			);
		}

		return $widget_data;
	}

	public function install($location, $provider, $dir, $code) {
		$builder = $this->db->table('widget_install');
		$builder->set('location', $location);
		$builder->set('provider', $provider);
		$builder->set('dir', $dir);
		$builder->set('code', $code);
		$query = $builder->insert();

		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function uninstall($location, $provider, $dir, $code) {
		$builder = $this->db->table('widget_install');
		$builder->where('location', $location);
		$builder->where('provider', $provider);
		$builder->where('dir', $dir);
		$builder->where('code', $code);
		$query = $builder->delete();

		if ($query) {
			return true;
		} else {
			return false;
		}
	}	

  public function getWidget($widget_id, $status = null)
  {
    $builder = $this->db->table('widget');

    $builder->where('widget_id', $widget_id);

    if ($status !== null) {
    	$builder->where('status', $status);
    }

    $query   = $builder->get();

    return $query->getRowArray();
  }

  public function getWidgets($location, $provider, $dir, $code)
  {
    $results = array();

    $builder = $this->db->table('widget');

    $builder->where('location', $location);
    $builder->where('provider', $provider);
    $builder->where('dir', $dir);
    $builder->where('code', $code);

    $query   = $builder->get();

    foreach ($query->getResult() as $row)
    {
      $results[] = array(
        'widget_id' => $row->widget_id,
        'location'  => $row->location,
        'provider'  => $row->provider,
        'dir'       => $row->dir,
        'name'      => $row->name,
        'code'      => $row->code,
        'setting'   => $row->setting,
      );
    }

    return $results;
  }
}