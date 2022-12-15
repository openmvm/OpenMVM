<?php

namespace Main\Marketplace\Models\Seller;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Seller_Category_Model extends Model
{
    protected $table = 'seller_category';
    protected $primaryKey = 'seller_category_id';
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
        $this->customer = new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
        $this->text = new \App\Libraries\Text();
    }

    public function addSellerCategory($data = [])
    {
        $builder = $this->db->table('seller_category');

        $insert_data = [
            'parent_id' => $data['parent_id'],
            'seller_id' => $this->customer->getSellerId(),
            'customer_id' => $this->customer->getId(),
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];
        
        $builder->insert($insert_data);

        $seller_category_id = $this->db->insertID();

        // Update image
        if ($data['image'] !== null) {
            $seller_category_builder = $this->db->table('seller_category');

            $seller_category_update_data = [
                'image' => $data['image'],
            ];

            $seller_category_builder->where('seller_category_id', $seller_category_id);
            $seller_category_builder->where('seller_id', $this->customer->getSellerId());
            $seller_category_builder->where('customer_id', $this->customer->getId());
            $seller_category_builder->update($seller_category_update_data);
        }

        // SellerCategory Descriptions
        if ($data['seller_category_description']) {
            foreach ($data['seller_category_description'] as $language_id => $value) {
                $seller_category_description_builder = $this->db->table('seller_category_description');

                $seller_category_description_insert_data = [
                    'seller_category_id' => $seller_category_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'language_id' => $language_id,
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'meta_title' => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keywords' => $value['meta_keywords'],
                    'slug' => $this->text->slugify($value['name']),
                ];
                
                $seller_category_description_builder->insert($seller_category_description_insert_data);
            }
        }

        // SellerCategory Path
		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

        $seller_category_path_builder = $this->db->table('seller_category_path');
        $seller_category_path_builder->where('seller_category_id', $data['parent_id']);
        $seller_category_path_builder->orderBy('level', 'ASC');
        $seller_category_path_query = $seller_category_path_builder->get();

        if ($seller_category_path_query->getResult()) {
            foreach ($seller_category_path_query->getResult() as $result) {
                $seller_category_path_insert_builder = $this->db->table('seller_category_path');

                $seller_category_path_insert_data = [
                    'seller_category_id' => $seller_category_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'path_id' => $result->path_id,
                    'level' => $level,
                ];
                
                $seller_category_path_insert_builder->insert($seller_category_path_insert_data);

                $level++;
            }
        }

        $seller_category_path_insert_builder = $this->db->table('seller_category_path');

        $seller_category_path_insert_data = [
            'seller_category_id' => $seller_category_id,
            'seller_id' => $this->customer->getSellerId(),
            'customer_id' => $this->customer->getId(),
            'path_id' => $seller_category_id,
            'level' => $level,
        ];
        
        $seller_category_path_insert_builder->insert($seller_category_path_insert_data);

        return $seller_category_id;
    }

    public function editSellerCategory($seller_category_id, $data = [])
    {
        $builder = $this->db->table('seller_category');

        $update_data = [
            'parent_id' => $data['parent_id'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];

        $builder->where('seller_category_id', $seller_category_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->update($update_data);

        // Update image
        if ($data['image'] !== null) {
            $seller_category_builder = $this->db->table('seller_category');

            $seller_category_update_data = [
                'image' => $data['image'],
            ];

            $seller_category_builder->where('seller_category_id', $seller_category_id);
            $seller_category_builder->update($seller_category_update_data);
        }
        
        // Delete seller_category descriptions
        $builder = $this->db->table('seller_category_description');

        $builder->where('seller_category_id', $seller_category_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        // SellerCategory Descriptions
        if ($data['seller_category_description']) {
            foreach ($data['seller_category_description'] as $language_id => $value) {
                $seller_category_description_builder = $this->db->table('seller_category_description');

                $seller_category_description_insert_data = [
                    'seller_category_id' => $seller_category_id,
                    'language_id' => $language_id,
                    'name' => $value['name'],
                    'description' => $value['description'],
                    'meta_title' => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keywords' => $value['meta_keywords'],
                    'slug' => $this->text->slugify($value['name']),
                ];
                
                $seller_category_description_builder->insert($seller_category_description_insert_data);
            }
        }

        // SellerCategory Path
		// MySQL Hierarchical Data Closure Table Pattern
        $seller_category_path_builder = $this->db->table('seller_category_path');
        $seller_category_path_builder->where('path_id', $seller_category_id);
        $seller_category_path_builder->orderBy('level', 'ASC');
        $seller_category_path_query = $seller_category_path_builder->get();

        if ($seller_category_path_query->getResult()) {
            foreach ($seller_category_path_query->getResult() as $seller_category_path) {
				// Delete the path below the current one
                $seller_category_path_delete_builder = $this->db->table('seller_category_path');
                $seller_category_path_delete_builder->where('seller_category_id', $seller_category_path->seller_category_id);
                $seller_category_path_delete_builder->where('seller_id', $this->customer->getSellerId());
                $seller_category_path_delete_builder->where('customer_id', $this->customer->getId());
                $seller_category_path_delete_builder->where('level <', $seller_category_path->level);
                $seller_category_path_delete_builder->delete();

				$path = [];

				// Get the nodes new parents
                $seller_category_path_builder_2 = $this->db->table('seller_category_path');
                $seller_category_path_builder_2->where('seller_category_id', $data['parent_id']);
                $seller_category_path_builder_2->where('seller_id', $this->customer->getSellerId());
                $seller_category_path_builder_2->where('customer_id', $this->customer->getId());
                $seller_category_path_builder_2->orderBy('level', 'ASC');
                $seller_category_path_query_2 = $seller_category_path_builder_2->get();

                if ($seller_category_path_query_2->getResult()) {
                    foreach ($seller_category_path_query_2->getResult() as $result) {
                        $path[] = $result->path_id;
                    }
                }

				// Get whats left of the nodes current path
                $seller_category_path_builder_3 = $this->db->table('seller_category_path');
                $seller_category_path_builder_3->where('seller_category_id', $seller_category_path->seller_category_id);
                $seller_category_path_builder_3->where('seller_id', $this->customer->getSellerId());
                $seller_category_path_builder_3->where('customer_id', $this->customer->getId());
                $seller_category_path_builder_3->orderBy('level', 'ASC');
                $seller_category_path_query_3 = $seller_category_path_builder_3->get();

                if ($seller_category_path_query_3->getResult()) {
                    foreach ($seller_category_path_query_3->getResult() as $result) {
                        $path[] = $result->path_id;
                    }
                }

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
                    $seller_category_path_replace_builder = $this->db->table('seller_category_path');

                    $seller_category_path_replace_data = [
                        'seller_category_id' => $seller_category_path->seller_category_id,
                        'seller_id' => $this->customer->getSellerId(),
                        'customer_id' => $this->customer->getId(),
                        'path_id'  => $path_id,
                        'level'  => $level,
                    ];
                    
                    $seller_category_path_replace_builder->replace($seller_category_path_replace_data);

					$level++;
                }
            }
        } else {
			// Delete the path below the current one
            $seller_category_path_delete_builder = $this->db->table('seller_category_path');
            $seller_category_path_delete_builder->where('seller_category_id', $seller_category_id);
            $seller_category_path_delete_builder->where('seller_id', $this->customer->getSellerId());
            $seller_category_path_delete_builder->where('customer_id', $this->customer->getId());
            $seller_category_path_delete_builder->delete();

			// Fix for records with no paths
			$level = 0;

            $seller_category_path_builder_2 = $this->db->table('seller_category_path');
            $seller_category_path_builder_2->where('seller_category_id', $data['parent_id']);
            $seller_category_path_builder_2->where('seller_id', $this->customer->getSellerId());
            $seller_category_path_builder_2->where('customer_id', $this->customer->getId());
            $seller_category_path_builder_2->orderBy('level', 'ASC');
            $seller_category_path_query_2 = $seller_category_path_builder_2->get();

            if ($seller_category_path_query_2->getResult()) {
                foreach ($seller_category_path_query_2->getResult() as $result) {
                    $seller_category_path_insert_builder = $this->db->table('seller_category_path');

                    $seller_category_path_insert_data = [
                        'seller_category_id' => $seller_category_id,
                        'seller_id' => $this->customer->getSellerId(),
                        'customer_id' => $this->customer->getId(),
                        'path_id'  => $result->path_id,
                        'level'  => $level,
                    ];

                    $seller_category_path_insert_builder->insert($seller_category_path_insert_data);

                    $level++;
                }
            }

            $seller_category_path_replace_builder = $this->db->table('seller_category_path');

            $seller_category_path_replace_data = [
                'seller_category_id' => $seller_category_id,
                'seller_id' => $this->customer->getSellerId(),
                'customer_id' => $this->customer->getId(),
                'path_id'  => $seller_category_id,
                'level'  => $level,
            ];
            
            $seller_category_path_replace_builder->replace($seller_category_path_replace_data);
        }

        return $seller_category_id;
    }

    public function deleteSellerCategory($seller_category_id)
    {
        // Delete seller_category
        $builder = $this->db->table('seller_category');

        $builder->where('seller_category_id', $seller_category_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        // Delete seller_category descriptions
        $builder = $this->db->table('seller_category_description');

        $builder->where('seller_category_id', $seller_category_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        // Delete seller_category paths
        $builder = $this->db->table('seller_category_path');

        $builder->groupStart();
        $builder->where('seller_category_id', $seller_category_id);
        $builder->orWhere('path_id', $seller_category_id);
        $builder->groupEnd();
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();
    }

    public function getSellerCategories($data = [], $seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller_category_path cp');
        $builder->select(" cp.seller_category_id AS seller_category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, GROUP_CONCAT(cd1.seller_category_id ORDER BY cp.level SEPARATOR '_') AS seller_category_id_path, c1.parent_id, c1.sort_order, c1.status, c1.image AS image");
        $builder->join('seller_category c1', 'cp.seller_category_id = c1.seller_category_id', 'left');
        $builder->join('seller_category c2', 'cp.path_id = c2.seller_category_id', 'left');
        $builder->join('seller_category_description cd1', 'cp.path_id = cd1.seller_category_id', 'left');
        $builder->join('seller_category_description cd2', 'cp.seller_category_id = cd2.seller_category_id', 'left');
        $builder->where('cd1.language_id ', $this->setting->get('setting_marketplace_language_id'));
        $builder->where('cd2.language_id ', $this->setting->get('setting_marketplace_language_id'));
        $builder->where('c1.seller_id', $seller_id);
        if (!empty($customer_id)) {
            $builder->where('c1.customer_id', $customer_id);
        }

        if (!empty($data['filter_name'])) {
            $builder->like('cd2.name', $data['filter_name']);
        }

        $builder->groupBy('cp.seller_category_id');

        $builder->orderBy('name', 'ASC');

        $seller_category_query = $builder->get();

        $categories = [];

        foreach ($seller_category_query->getResult() as $result) {
            $categories[] = [
                'seller_category_id' => $result->seller_category_id,
                'name' => $result->name,
                'seller_category_id_path' => $result->seller_category_id_path,
                'parent_id' => $result->parent_id,
                'image' => $result->image,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $categories;
    }

    public function getSellerCategoriesByParentId($parent_id, $seller_id)
    {
        $builder = $this->db->table('seller_category sc');
        $builder->join('seller_category_description scd', 'sc.seller_category_id = scd.seller_category_id', 'left');
        $builder->where('scd.language_id ', $this->setting->get('setting_marketplace_language_id'));
        $builder->where('sc.parent_id', $parent_id);
        $builder->where('sc.seller_id', $seller_id);

        $builder->groupBy('sc.seller_category_id');

        $builder->orderBy('sc.sort_order', 'ASC');
        $builder->orderBy('scd.name', 'ASC');

        $seller_category_query = $builder->get();

        $categories = [];

        foreach ($seller_category_query->getResult() as $result) {
            $categories[] = [
                'seller_category_id' => $result->seller_category_id,
                'name' => $result->name,
                'parent_id' => $result->parent_id,
                'image' => $result->image,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
                'slug' => $result->slug,
            ];
        }

        return $categories;
    }

    public function getSellerCategory($seller_category_id, $seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller_category');
        
        $builder->where('seller_category_id', $seller_category_id);
        $builder->where('seller_id', $seller_id);
        if (!empty($customer_id)) {
            $builder->where('customer_id', $customer_id);
        }

        $seller_category_query = $builder->get();

        $seller_category = [];

        if ($row = $seller_category_query->getRow()) {
            $seller_category = [
                'seller_category_id' => $row->seller_category_id,
                'parent_id' => $row->parent_id,
                'image' => $row->image,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $seller_category;
    }

    public function getSellerCategoryPath($seller_category_id, $seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller_category_path cp');
        $builder->select(" GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') as path ");
        $builder->join('seller_category_description cd1', 'cp.path_id = cd1.seller_category_id AND cp.seller_category_id != cp.path_id', 'left');
        $builder->where('cp.seller_category_id', $seller_category_id);
        $builder->where('cd1.language_id', $this->setting->get('setting_marketplace_language_id'));
        $builder->where('c1.seller_id', $seller_id);
        if (!empty($customer_id)) {
            $builder->where('c1.customer_id', $customer_id);
        }
        $builder->groupBy('cp.seller_category_id');

        $seller_category_query = $builder->get();

        if ($row = $seller_category_query->getRow()) {
            $path = $row->path;
        } else {
            $path = '';
        }

        return $path;
    }

    public function getSellerCategorySlugPath($seller_category_id)
    {
        $builder = $this->db->table('seller_category_path cp');
        $builder->select(" GROUP_CONCAT(cd1.slug ORDER BY level SEPARATOR '/') as path ");
        $builder->join('seller_category_description cd1', 'cp.path_id = cd1.seller_category_id AND cp.seller_category_id != cp.path_id', 'left');
        $builder->where('cp.seller_category_id', $seller_category_id);
        $builder->where('cd1.language_id', $this->language->getCurrentId());
        $builder->groupBy('cp.seller_category_id');

        $seller_category_query = $builder->get();

        if ($row = $seller_category_query->getRow()) {
            $path = $row->path;
        } else {
            $path = '';
        }

        return $path;
    }

    public function getSellerCategoryIdPath($seller_category_id)
    {
        $builder = $this->db->table('seller_category_path cp');
        $builder->select(" GROUP_CONCAT(cd1.seller_category_id ORDER BY level SEPARATOR '_') as path ");
        $builder->join('seller_category_description cd1', 'cp.path_id = cd1.seller_category_id AND cp.seller_category_id != cp.path_id', 'left');
        $builder->where('cp.seller_category_id', $seller_category_id);
        $builder->where('cd1.language_id', $this->language->getCurrentId());
        $builder->groupBy('cp.seller_category_id');

        $seller_category_query = $builder->get();

        if ($row = $seller_category_query->getRow()) {
            $path = $row->path;
        } else {
            $path = '';
        }

        return $path;
    }

    public function getSellerCategoryDescriptions($seller_category_id, $seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller_category_description');
        
        $builder->where('seller_category_id', $seller_category_id);
        $builder->where('seller_id', $seller_id);
        if (!empty($customer_id)) {
            $builder->where('customer_id', $customer_id);
        }

        $seller_category_description_query = $builder->get();

        $seller_category_descriptions = [];

        foreach ($seller_category_description_query->getResult() as $result) {
            $seller_category_descriptions[$result->language_id] = [
                'name' => $result->name,
                'description' => $result->description,
                'meta_title' => $result->meta_title,
                'meta_description' => $result->meta_description,
                'meta_keywords' => $result->meta_keywords,
                'slug' => $result->slug,
            ];
        }

        return $seller_category_descriptions;
    }

    public function getSellerCategoryDescription($seller_category_id, $seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller_category_description');
        
        $builder->where('seller_category_id', $seller_category_id);
        $builder->where('seller_id', $seller_id);
        if (!empty($customer_id)) {
            $builder->where('customer_id', $customer_id);
        }
        $builder->where('language_id', $this->setting->get('setting_marketplace_language_id'));

        $seller_category_description_query = $builder->get();

        $seller_category_description = [];

        if ($row = $seller_category_description_query->getRow()) {
            $seller_category_description = [
                'name' => $row->name,
                'description' => $row->description,
                'meta_title' => $row->meta_title,
                'meta_description' => $row->meta_description,
                'meta_keywords' => $row->meta_keywords,
                'slug' => $row->slug,
            ];
        }

        return $seller_category_description;
    }
}