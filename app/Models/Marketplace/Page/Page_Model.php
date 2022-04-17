<?php

namespace App\Models\Marketplace\Page;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Page_Model extends Model
{
    protected $table = 'page';
    protected $primaryKey = 'page_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->language = new \App\Libraries\Language();
    }

    public function getPages($data = [])
    {
        $page_builder = $this->db->table('page');

        $page_builder->join('page_description', 'page_description.page_id = page.page_id', 'left');

        $page_builder->where('page_description.language_id', $this->language->getCurrentId());

        if (!empty($data['filter_name'])) {
            $page_builder->like('page_description.title', $data['filter_name']);
        }

        $page_builder->orderBy('page_description.title', 'ASC');

        $page_query = $page_builder->get();

        $pages = [];

        foreach ($page_query->getResult() as $result) {
            $pages[] = [
                'page_id' => $result->page_id,
                'title' => $result->title,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
                'slug' => $result->slug,
            ];
        }

        return $pages;
    }

    public function getPage($page_id)
    {
        $builder = $this->db->table('page');
        
        $builder->where('page_id', $page_id);

        $page_query = $builder->get();

        $page = [];

        if ($row = $page_query->getRow()) {
            $page = [
                'page_id' => $row->page_id,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $page;
    }

    public function getPageDescriptions($page_id)
    {
        $page_description_builder = $this->db->table('page_description');

        $page_description_builder->where('page_id', $page_id);

        $page_description_query = $page_description_builder->get();

        $page_descriptions = [];

        foreach ($page_description_query->getResult() as $result) {
            $page_descriptions[$result->language_id] = [
                'page_description_id' => $result->page_description_id,
                'page_id' => $result->page_id,
                'language_id' => $result->language_id,
                'title' => $result->title,
                'description' => $result->description,
                'slug' => $result->slug,
            ];
        }

        return $page_descriptions;
    }

    public function getPageDescription($page_id)
    {
        $page_description_builder = $this->db->table('page_description');
        
        $page_description_builder->where('page_id', $page_id);
        $page_description_builder->where('language_id', $this->language->getCurrentId());

        $page_description_query = $page_description_builder->get();

        $page_description = [];

        if ($row = $page_description_query->getRow()) {
            $page_description = [
                'page_description_id' => $row->page_description_id,
                'page_id' => $row->page_id,
                'language_id' => $row->language_id,
                'title' => $row->title,
                'description' => $row->description,
                'slug' => $row->slug,
            ];
        }

        return $page_description;
    }
}