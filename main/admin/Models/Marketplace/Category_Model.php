<?php

namespace Main\Admin\Models\Marketplace;

use CodeIgniter\Model;

class Category_Model extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['parent_id', 'sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // Libraries
        $this->setting = new \App\Libraries\Setting();
        $this->text = new \App\Libraries\Text();
    }

    public function addCategory($data = [])
    {
        $builder = $this->db->table('category');

        $insert_data = [
            'parent_id' => $data['parent_id'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];
        
        $builder->insert($insert_data);

        $category_id = $this->db->insertID();

        // Update image
        if ($data['image'] !== null) {
            $category_builder = $this->db->table('category');

            $category_update_data = [
                'image' => $data['image'],
            ];

            $category_builder->where('category_id', $category_id);
            $category_builder->update($category_update_data);
        }

        // Category Descriptions
        if ($data['category_description']) {
            foreach ($data['category_description'] as $language_id => $value) {
                $category_description_builder = $this->db->table('category_description');

                $category_description_insert_data = [
                    'category_id' => $category_id,
                    'language_id' => $language_id,
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'meta_title' => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keywords' => $value['meta_keywords'],
                    'slug' => $this->text->slugify($value['name']),
                ];
                
                $category_description_builder->insert($category_description_insert_data);
            }
        }

        // Category Path
		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

        $category_path_builder = $this->db->table('category_path');
        $category_path_builder->where('category_id', $data['parent_id']);
        $category_path_builder->orderBy('level', 'ASC');
        $category_path_query = $category_path_builder->get();

        if ($category_path_query->getResult()) {
            foreach ($category_path_query->getResult() as $result) {
                $category_path_insert_builder = $this->db->table('category_path');

                $category_path_insert_data = [
                    'category_id' => $category_id,
                    'path_id' => $result->path_id,
                    'level' => $level,
                ];
                
                $category_path_insert_builder->insert($category_path_insert_data);

                $level++;
            }
        }

        $category_path_insert_builder = $this->db->table('category_path');

        $category_path_insert_data = [
            'category_id' => $category_id,
            'path_id' => $category_id,
            'level' => $level,
        ];
        
        $category_path_insert_builder->insert($category_path_insert_data);

        return $category_id;
    }

    public function editCategory($category_id, $data = [])
    {
        $builder = $this->db->table('category');

        $update_data = [
            'parent_id' => $data['parent_id'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];

        $builder->where('category_id', $category_id);
        $builder->update($update_data);

        // Update image
        if ($data['image'] !== null) {
            $category_builder = $this->db->table('category');

            $category_update_data = [
                'image' => $data['image'],
            ];

            $category_builder->where('category_id', $category_id);
            $category_builder->update($category_update_data);
        }
        
        // Delete category descriptions
        $builder = $this->db->table('category_description');

        $builder->where('category_id', $category_id);
        $builder->delete();

        // Category Descriptions
        if ($data['category_description']) {
            foreach ($data['category_description'] as $language_id => $value) {
                $category_description_builder = $this->db->table('category_description');

                $category_description_insert_data = [
                    'category_id' => $category_id,
                    'language_id' => $language_id,
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'meta_title' => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keywords' => $value['meta_keywords'],
                    'slug' => $this->text->slugify($value['name']),
                ];
                
                $category_description_builder->insert($category_description_insert_data);
            }
        }

        // Category Path
		// MySQL Hierarchical Data Closure Table Pattern
        $category_path_builder = $this->db->table('category_path');
        $category_path_builder->where('path_id', $category_id);
        $category_path_builder->orderBy('level', 'ASC');
        $category_path_query = $category_path_builder->get();

        if ($category_path_query->getResult()) {
            foreach ($category_path_query->getResult() as $category_path) {
				// Delete the path below the current one
                $category_path_delete_builder = $this->db->table('category_path');
                $category_path_delete_builder->where('category_id', $category_path->category_id);
                $category_path_delete_builder->where('level <', $category_path->level);
                $category_path_delete_builder->delete();

				$path = [];

				// Get the nodes new parents
                $category_path_builder_2 = $this->db->table('category_path');
                $category_path_builder_2->where('category_id', $data['parent_id']);
                $category_path_builder_2->orderBy('level', 'ASC');
                $category_path_query_2 = $category_path_builder_2->get();

                if ($category_path_query_2->getResult()) {
                    foreach ($category_path_query_2->getResult() as $result) {
                        $path[] = $result->path_id;
                    }
                }

				// Get whats left of the nodes current path
                $category_path_builder_3 = $this->db->table('category_path');
                $category_path_builder_3->where('category_id', $category_path->category_id);
                $category_path_builder_3->orderBy('level', 'ASC');
                $category_path_query_3 = $category_path_builder_3->get();

                if ($category_path_query_3->getResult()) {
                    foreach ($category_path_query_3->getResult() as $result) {
                        $path[] = $result->path_id;
                    }
                }

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
                    $category_path_replace_builder = $this->db->table('category_path');

                    $category_path_replace_data = [
                        'category_id' => $category_path->category_id,
                        'path_id'  => $path_id,
                        'level'  => $level,
                    ];
                    
                    $category_path_replace_builder->replace($category_path_replace_data);

					$level++;
                }
            }
        } else {
			// Delete the path below the current one
            $category_path_delete_builder = $this->db->table('category_path');
            $category_path_delete_builder->where('category_id', $category_id);
            $category_path_delete_builder->delete();

			// Fix for records with no paths
			$level = 0;

            $category_path_builder_2 = $this->db->table('category_path');
            $category_path_builder_2->where('category_id', $data['parent_id']);
            $category_path_builder_2->orderBy('level', 'ASC');
            $category_path_query_2 = $category_path_builder_2->get();

            if ($category_path_query_2->getResult()) {
                foreach ($category_path_query_2->getResult() as $result) {
                    $category_path_insert_builder = $this->db->table('category_path');

                    $category_path_insert_data = [
                        'category_id' => $category_id,
                        'path_id'  => $result->path_id,
                        'level'  => $level,
                    ];

                    $category_path_insert_builder->insert($category_path_insert_data);

                    $level++;
                }
            }

            $category_path_replace_builder = $this->db->table('category_path');

            $category_path_replace_data = [
                'category_id' => $category_id,
                'path_id'  => $category_id,
                'level'  => $level,
            ];
            
            $category_path_replace_builder->replace($category_path_replace_data);
        }

        return $category_id;
    }

    public function deleteCategory($category_id)
    {
        // Delete category
        $builder = $this->db->table('category');

        $builder->where('category_id', $category_id);
        $builder->delete();

        // Delete category descriptions
        $builder = $this->db->table('category_description');

        $builder->where('category_id', $category_id);
        $builder->delete();

        // Delete category paths
        $builder = $this->db->table('category_path');

        $builder->where('category_id', $category_id);
        $builder->orWhere('path_id', $category_id);
        $builder->delete();
    }

    public function getCategories($data = [])
    {
        $builder = $this->db->table('category_path cp');
        $builder->select(" cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order, c1.status, c1.image AS image");
        $builder->join('category c1', 'cp.category_id = c1.category_id', 'left');
        $builder->join('category c2', 'cp.path_id = c2.category_id', 'left');
        $builder->join('category_description cd1', 'cp.path_id = cd1.category_id', 'left');
        $builder->join('category_description cd2', 'cp.category_id = cd2.category_id', 'left');
        $builder->where('cd1.language_id ', $this->setting->get('setting_admin_language_id'));
        $builder->where('cd2.language_id ', $this->setting->get('setting_admin_language_id'));

        if (!empty($data['filter_name'])) {
            $builder->like('cd2.name', $data['filter_name']);
        }

        $builder->groupBy('cp.category_id');

        //$builder->orderBy('sort_order', 'ASC');
        $builder->orderBy('name', 'ASC');

        $category_query = $builder->get();

        $categories = [];

        foreach ($category_query->getResult() as $result) {
            $categories[] = [
                'category_id' => $result->category_id,
                'name' => $result->name,
                'parent_id' => $result->parent_id,
                'image' => $result->image,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $categories;
    }

    public function getCategory($category_id)
    {
        $builder = $this->db->table('category');
        
        $builder->where('category_id', $category_id);

        $category_query = $builder->get();

        $category = [];

        if ($row = $category_query->getRow()) {
            $category = [
                'category_id' => $row->category_id,
                'parent_id' => $row->parent_id,
                'image' => $row->image,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $category;
    }

    public function getCategoryPath($category_id)
    {
        $builder = $this->db->table('category_path cp');
        $builder->select(" GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') as path ");
        $builder->join('category_description cd1', 'cp.path_id = cd1.category_id AND cp.category_id != cp.path_id', 'left');
        $builder->where('cp.category_id', $category_id);
        $builder->where('cd1.language_id', $this->setting->get('setting_admin_language_id'));
        $builder->groupBy('cp.category_id');

        $category_query = $builder->get();

        if ($row = $category_query->getRow()) {
            $path = $row->path;
        } else {
            $path = '';
        }

        return $path;
    }

    public function getCategoryDescriptions($category_id)
    {
        $builder = $this->db->table('category_description');
        
        $builder->where('category_id', $category_id);

        $category_description_query = $builder->get();

        $category_descriptions = [];

        foreach ($category_description_query->getResult() as $result) {
            $category_descriptions[$result->language_id] = [
                'name' => $result->name,
                'description' => $result->description,
                'meta_title' => $result->meta_title,
                'meta_description' => $result->meta_description,
                'meta_keywords' => $result->meta_keywords,
            ];
        }

        return $category_descriptions;
    }

    public function getCategoryDescription($category_id)
    {
        $builder = $this->db->table('category_description');
        
        $builder->where('category_id', $category_id);
        $builder->where('language_id', $this->setting->get('setting_admin_language_id'));

        $category_description_query = $builder->get();

        $category_description = [];

        if ($row = $category_description_query->getRow()) {
            $category_description = [
                'name' => $row->name,
                'description' => $row->description,
                'meta_title' => $row->meta_title,
                'meta_description' => $row->meta_description,
                'meta_keywords' => $row->meta_keywords,
            ];
        }

        return $category_description;
    }
}