<?php

namespace Main\Marketplace\Models\Localisation;

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