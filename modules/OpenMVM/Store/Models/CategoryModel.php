<?php

namespace Modules\OpenMVM\Store\Models;

class CategoryModel extends \CodeIgniter\Model
{

  protected $table = 'category';
	protected $primaryKey = 'category_id';
  protected $allowedFields = ['category_id', 'image', 'parent_id', 'top', 'column', 'sort_order', 'status', 'date_added', 'date_modified'];

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

	public function addCategory($data = array())
	{
		$builder = $this->db->table('category');

		if ($data['image'] !== null) {
			$image = $data['image'];
		} else {
			$image = null;
		}

		if ($data['top'] !== null) {
			$top = $data['top'];
		} else {
			$top = 0;
		}

    $query_data = array(
      'image'         => $image,
      'parent_id'     => $data['parent_id'],
      'top'           => $top,
      'column'        => $data['column'],
      'sort_order'    => $data['sort_order'],
      'status'        => $data['status'],
      'date_added'    => date("Y-m-d H:i:s",now()),
      'date_modified' => date("Y-m-d H:i:s",now()),
    );

		$builder->insert($query_data);

		$category_id = $this->db->insertID();

    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'category_id'       => $category_id,
        'language_id'       => $language_id,
        'name'              => $value['name'],
        'description'       => $value['description'],
        'meta_title'        => $value['meta_title'],
        'meta_description'  => $value['meta_description'],
        'meta_keywords'     => $value['meta_keywords'],
        'slug'              => $this->text->slugify($value['name']),
      );

			$builder = $this->db->table('category_description');

			$builder->insert($query_data_2);
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$builder = $this->db->table('category_path');
		$builder->where('category_id', $data['parent_id']);
		$builder->orderBy('level', 'ASC');
		$query = $builder->get();

    foreach ($query->getResult() as $row) {
      $query_data_3 = array(
        'category_id'  => $category_id,
        'path_id'      => $row->path_id,
        'level'        => $level
      );

			$builder = $this->db->table('category_path');
			$builder->insert($query_data_3);

      $level++;
    }

    $query_data_4 = array(
      'category_id'  => $category_id,
      'path_id'      => $category_id,
      'level'        => $level
    );

		$builder = $this->db->table('category_path');
		$builder->insert($query_data_4);

		return $category_id;
	}

	public function editCategory($data = array(), $category_id)
	{
		$builder = $this->db->table('category');

		if ($data['image'] !== null) {
			$image = $data['image'];
		} else {
			$image = null;
		}

    $query_data = array(
      'image'         => $image,
      'parent_id'     => $data['parent_id'],
      'top'           => $data['top'],
      'column'        => $data['column'],
      'sort_order'    => $data['sort_order'],
      'status'        => $data['status'],
      'date_modified' => date("Y-m-d H:i:s",now()),
    );

    $builder->where('category_id', $category_id);
		$builder->update($query_data);

		// Delete Old Category Description
		$builder = $this->db->table('category_description');
		$builder->where('category_id', $category_id);
		$builder->delete();

		// Insert New Category Description
    foreach ($data['description'] as $language_id => $value) {
      $query_data_2 = array(
        'category_id'       => $category_id,
        'language_id'       => $language_id,
        'name'              => $value['name'],
        'description'       => $value['description'],
        'meta_title'        => $value['meta_title'],
        'meta_description'  => $value['meta_description'],
        'meta_keywords'     => $value['meta_keywords'],
        'slug'              => $this->text->slugify($value['name']),
      );

			$builder = $this->db->table('category_description');
      $builder->where('category_id', $category_id);
			$builder->insert($query_data_2);
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$builder = $this->db->table('category_path');
    $builder->where('path_id', $category_id);
    $builder->orderBy('level', 'ASC');
		$query_1 = $builder->get();

    if ($query_1->getResult()) {
      foreach ($query_1->getResult() as $category_path) {
        // Delete the path below the current one
				$builder = $this->db->table('category_path');
    		$builder->where('category_id', $category_path->category_id);
    		$builder->where('level <', $category_path->level);
				$builder->delete();

        $path = array();

        // Get the nodes new parents
				$builder = $this->db->table('category_path');
    		$builder->where('category_id', $data['parent_id']);
    		$builder->orderBy('level', 'ASC');
        $query_2 = $builder->get();
        foreach ($query_2->getResult() as $result) {
					$path[] = $result->path_id;
				}

        // Get whats left of the nodes current path
				$builder = $this->db->table('category_path');
    		$builder->where('category_id', $category_path->category_id);
    		$builder->orderBy('level', 'ASC');
        $query_3 = $builder->get();
        foreach ($query_3->getResult() as $result) {
					$path[] = $result->path_id;
				}

        // Combine the paths with a new level
        $level = 0;
        foreach ($path as $path_id) {
          $query_data_3 = array(
            'category_id' => $category_path->category_id,
            'path_id'     => $path_id,
            'level'       => $level,
          );
					$builder = $this->db->table('category_path');
					$builder->replace($query_data_3);
          $level++;
        }
      }
    } else {
      // Delete the path below the current one
			$builder = $this->db->table('category_path');
    	$builder->where('category_id', $category_id);
			$builder->delete();

      // Fix for records with no paths
      $level = 0;
			$builder = $this->db->table('category_path');
    	$builder->where('category_id', $data['parent_id']);
    	$builder->orderBy('level', 'ASC');
      $query_4 = $builder->get();
      foreach ($query_4->getResult() as $result) {
        $query_data_4 = array(
          'category_id'  => $category_id,
          'path_id'      => $result->path_id,
          'level'        => $level
        );

				$builder->insert($query_data_4);
        $level++;
      }
      $query_data_5 = array(
        'category_id' => $category_id,
        'path_id'     => $article_category_id,
        'level'       => $level,
      );
			$builder = $this->db->table('category_path');
			$builder->replace($query_data_5);
    }

		return $category_id;
	}

	public function deleteCategory($category_id)
	{
		$builder = $this->db->table('category');
		$builder->where('category_id', $category_id);
		$builder->delete();

		$builder = $this->db->table('category_description');
		$builder->where('category_id', $category_id);
		$builder->delete();

		$builder = $this->db->table('category_path');
		$builder->where('category_id', $category_id);
		$builder->delete();
	}

	public function getCategories($data = array(), $language_id)
	{
		$builder = $this->db->table('category_path cp');
    $builder->select('cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS path, cd2.name AS name, cd2.slug AS slug, c1.status, c1.image, c1.parent_id, c1.top, c1.sort_order', false);
    $builder->join('category c1', 'cp.category_id = c1.category_id', 'left');
    $builder->join('category c2', 'cp.path_id = c2.category_id', 'left');
    $builder->join('category_description cd1', 'cp.path_id = cd1.category_id', 'left');
    $builder->join('category_description cd2', 'cp.category_id = cd2.category_id', 'left');

		$builder->where('cd1.language_id', $language_id);
		$builder->where('cd2.language_id', $language_id);

    if (!empty($data['filter_name'])) {
    	$builder->like('cd2.name', $data['filter_name']);
    }

    if ($data['filter_category'] !== null) {
    	$builder->like('c1.parent_id', $data['filter_category']);
    }

    if ($data['filter_status'] !== null) {
    	$builder->where('c1.status', $data['filter_status']);
    }

    $builder->groupBy('cp.category_id');

		if (!empty($data['sort']) && !empty($data['order'])) {
    	$builder->orderBy($data['sort'], $data['order']);
		} else {
    	$builder->orderBy('c1.sort_order', 'ASC');
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

    if ($query) {
	    foreach ($query->getResult() as $row) {
				$results[] = array(
					'category_id'      => $row->category_id,
					'path'             => $row->path,
					'name'             => $row->name,
					'description'      => $row->description,
					'meta_title'       => $row->meta_title,
					'meta_description' => $row->meta_description,
					'meta_keywords'    => $row->meta_keywords,
					'slug'             => $row->slug,
					'image'            => $row->image,
					'top'              => $row->top,
					'sort_order'       => $row->sort_order,
					'status'           => $row->status,
					'date_added'       => $row->date_added,
					'date_modified'    => $row->date_modified,
				);
	    }
    }

    return $results;
	}

	public function getCategory($category_id, $language_id = null)
	{
		$builder = $this->db->table('category_path cp');
    $builder->select('cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS path, cd2.name AS name, cd2.slug AS slug, c1.status, c1.image, c1.parent_id, c1.top, c1.sort_order', false);
    $builder->join('category c1', 'cp.category_id = c1.category_id', 'left');
    $builder->join('category c2', 'cp.path_id = c2.category_id', 'left');
    $builder->join('category_description cd1', 'cp.path_id = cd1.category_id', 'left');
    $builder->join('category_description cd2', 'cp.category_id = cd2.category_id', 'left');

    if ($language_id !== null) {
			$builder->where('cd1.language_id', $language_id);
			$builder->where('cd2.language_id', $language_id);
    }
		$builder->where('c1.category_id', $category_id);

		$query = $builder->get();

		return $query->getRowArray();
	}

	public function getCategoryDescriptions($category_id)
	{
		$builder = $this->db->table('category_description');
		$builder->where('category_id', $category_id);
		$query = $builder->get();

		$results = array();

		foreach ($query->getResult() as $row)
		{
			$results[$row->language_id] = array(
				'name'              => $row->name,
				'description'       => $row->description,
				'meta_title'        => $row->meta_title,
				'meta_description'  => $row->meta_description,
				'meta_keywords'     => $row->meta_keywords,
				'slug'              => $row->slug,
			);
		}

		return $results;
	}

	public function getCategoryDescription($category_id, $language_id)
	{
		$builder = $this->db->table('category_description');
		$builder->where('category_id', $category_id);
		$builder->where('language_id', $language_id);
		$query = $builder->get();

		$row = $query->getRow();

		$result = array(
			'name'              => $row->name,
			'description'       => $row->description,
			'meta_title'        => $row->meta_title,
			'meta_description'  => $row->meta_description,
			'meta_keywords'     => $row->meta_keywords,
			'slug'              => $row->slug,
		);

		return $result;
	}

	public function getTotalCategories($data = array(), $language_id)
	{
		$builder = $this->db->table('category c');
    $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');

		$builder->where('cd.language_id', $language_id);

    if (!empty($data['filter_name'])) {
    	$builder->like('cd.name', $data['filter_name']);
    }

    if (!empty($data['filter_category'])) {
    	$builder->like('c.parent_id', $data['filter_category']);
    }
		
    $query = $builder->countAllResults();

    return $query;
	}
}