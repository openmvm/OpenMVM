<?php

namespace Main\Admin\Models\Page;

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
        $this->text = new \App\Libraries\Text();
    }

    public function addPage($data = [])
    {
        $page_insert_builder = $this->db->table('page');

        $page_insert_data = [
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
            'date_added' => new Time('now'),
            'date_modified' => new Time('now'),
        ];
        
        $page_insert_builder->insert($page_insert_data);

        $page_id = $this->db->insertID();

        // Page descriptions
        if (!empty($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $page_description_builder = $this->db->table('page_description');

                $page_description_insert_data = [
                    'page_id' => $page_id,
                    'language_id' => $language_id,
                    'title' => $value['title'],
                    'description' => $value['description'],
                    'slug' => $this->text->slugify($value['title']),
                ];
                
                $page_description_builder->insert($page_description_insert_data);
            }
        }

        return $page_id;
    }

    public function editPage($page_id, $data = [])
    {
        $page_update_builder = $this->db->table('page');

        $page_update_data = [
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
            'date_modified' => new Time('now'),
        ];

        $page_update_builder->where('page_id', $page_id);
        $page_update_builder->update($page_update_data);

        // Page descriptions
        $page_delete_builder = $this->db->table('page_description');

        $page_delete_builder->where('page_id', $page_id);
        $page_delete_builder->delete();

        if (!empty($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $page_description_insert_builder = $this->db->table('page_description');

                $page_description_insert_data = [
                    'page_id' => $page_id,
                    'language_id' => $language_id,
                    'title' => $value['title'],
                    'description' => $value['description'],
                    'slug' => $this->text->slugify($value['title']),
                ];
                
                $page_description_insert_builder->insert($page_description_insert_data);
            }
        }

        return $page_id;
    }

    public function deletePage($page_id)
    {
        $page_delete_builder = $this->db->table('page');

        $page_delete_builder->where('page_id', $page_id);
        $page_delete_builder->delete();

        $page_description_delete_builder = $this->db->table('page_description');

        $page_description_delete_builder->where('page_id', $page_id);
        $page_description_delete_builder->delete();
    }

    public function getPages($data = [])
    {
        $page_builder = $this->db->table('page');

        $page_builder->join('page_description', 'page_description.page_id = page.page_id', 'left');

        $page_builder->where('page_description.language_id', $this->language->getCurrentId(true));

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
        $page_description_builder->where('language_id', $this->language->getCurrentId(true));

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