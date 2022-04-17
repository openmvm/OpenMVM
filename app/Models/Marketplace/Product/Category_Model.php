<?php

namespace App\Models\Marketplace\Product;

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
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
    }

    public function getCategories($parent_id = null)
    {
        $builder = $this->db->table('category_path cp');
        $builder->select("cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS category_path, GROUP_CONCAT(cd1.category_id ORDER BY cp.level SEPARATOR '_') AS category_id_path, cd2.name AS name, cd1.slug AS slug, c1.parent_id AS parent_id, c1.sort_order AS sort_order, c1.status AS status, c1.image AS image");
        $builder->join('category c1', 'cp.category_id = c1.category_id', 'left');
        $builder->join('category c2', 'cp.path_id = c2.category_id', 'left');
        $builder->join('category_description cd1', 'cp.path_id = cd1.category_id', 'left');
        $builder->join('category_description cd2', 'cp.category_id = cd2.category_id', 'left');
        $builder->where('cd1.language_id', $this->language->getCurrentId());
        $builder->where('cd2.language_id', $this->language->getCurrentId());
        if (isset($parent_id)) {
            $builder->where('c1.parent_id', $parent_id);
        }
        $builder->groupBy('cp.category_id');
        $builder->orderBy('category_path', 'ASC');

        $category_query = $builder->get();

        $categories = [];

        foreach ($category_query->getResult() as $result) {
            $categories[] = [
                'category_id' => $result->category_id,
                'name' => $result->name,
                'category_path' => $result->category_path,
                'category_id_path' => $result->category_id_path,
                'slug' => $result->slug,
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
        $builder->where('cd1.language_id', $this->language->getCurrentId());
        $builder->groupBy('cp.category_id');

        $category_query = $builder->get();

        if ($row = $category_query->getRow()) {
            $path = $row->path;
        } else {
            $path = '';
        }

        return $path;
    }

    public function getCategorySlugPath($category_id)
    {
        $builder = $this->db->table('category_path cp');
        $builder->select(" GROUP_CONCAT(cd1.slug ORDER BY level SEPARATOR '/') as path ");
        $builder->join('category_description cd1', 'cp.path_id = cd1.category_id AND cp.category_id != cp.path_id', 'left');
        $builder->where('cp.category_id', $category_id);
        $builder->where('cd1.language_id', $this->language->getCurrentId());
        $builder->groupBy('cp.category_id');

        $category_query = $builder->get();

        if ($row = $category_query->getRow()) {
            $path = $row->path;
        } else {
            $path = '';
        }

        return $path;
    }

    public function getCategoryIdPath($category_id)
    {
        $builder = $this->db->table('category_path cp');
        $builder->select(" GROUP_CONCAT(cd1.category_id ORDER BY level SEPARATOR '_') as path ");
        $builder->join('category_description cd1', 'cp.path_id = cd1.category_id AND cp.category_id != cp.path_id', 'left');
        $builder->where('cp.category_id', $category_id);
        $builder->where('cd1.language_id', $this->language->getCurrentId());
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
                'slug' => $result->slug,
            ];
        }

        return $category_descriptions;
    }

    public function getCategoryDescription($category_id)
    {
        $builder = $this->db->table('category_description');
        
        $builder->where('category_id', $category_id);
        $builder->where('language_id', $this->language->getCurrentId());

        $category_description_query = $builder->get();

        $category_description = [];

        if ($row = $category_description_query->getRow()) {
            $category_description = [
                'name' => $row->name,
                'description' => $row->description,
                'meta_title' => $row->meta_title,
                'meta_description' => $row->meta_description,
                'meta_keywords' => $row->meta_keywords,
                'slug' => $row->slug,
            ];
        }

        return $category_description;
    }
}