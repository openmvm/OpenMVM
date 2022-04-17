<?php

namespace App\Models\Admin\Localisation;

use CodeIgniter\Model;

class Language_Model extends Model
{
    protected $table = 'language';
    protected $primaryKey = 'language_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'code', 'sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function addLanguage($data = [])
    {
        $builder = $this->db->table('language');

        $insert_data = [
            'name' => $data['name'],
            'code' => $data['code'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];
        
        $builder->insert($insert_data);

        return $this->db->insertID();
    }

    public function editLanguage($language_id, $data = [])
    {
        $builder = $this->db->table('language');

        $update_data = [
            'name' => $data['name'],
            'code' => $data['code'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];

        $builder->where('language_id', $language_id);
        $builder->update($update_data);

        return $language_id;
    }

    public function deleteLanguage($language_id)
    {
        $builder = $this->db->table('language');

        $builder->where('language_id', $language_id);
        $builder->delete();
    }

    public function getLanguages($data = [])
    {
        $builder = $this->db->table('language');

        $language_query = $builder->get();

        $languages = [];

        foreach ($language_query->getResult() as $result) {
            $languages[] = [
                'language_id' => $result->language_id,
                'name' => $result->name,
                'code' => $result->code,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $languages;
    }

    public function getLanguage($language_id)
    {
        $builder = $this->db->table('language');
        
        $builder->where('language_id', $language_id);

        $language_query = $builder->get();

        $language = [];

        if ($row = $language_query->getRow()) {
            $language = [
                'language_id' => $row->language_id,
                'name' => $row->name,
                'code' => $row->code,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $language;
    }
}