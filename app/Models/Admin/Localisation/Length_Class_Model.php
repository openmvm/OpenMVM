<?php

namespace App\Models\Admin\Localisation;

use CodeIgniter\Model;

class Length_Class_Model extends Model
{
    protected $table = 'length_class';
    protected $primaryKey = 'length_class_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['value'];
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

    public function addLengthClass($data = [])
    {
        $length_class_insert_builder = $this->db->table('length_class');

        $length_class_insert_data = [
            'value' => $data['value'],
        ];
        
        $length_class_insert_builder->insert($length_class_insert_data);

        $length_class_id = $this->db->insertID();

        // Length class descriptions
        if (!empty($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $length_class_description_builder = $this->db->table('length_class_description');

                $length_class_description_insert_data = [
                    'length_class_id' => $length_class_id,
                    'language_id' => $language_id,
                    'title' => $value['title'],
                    'unit' => $value['unit'],
                ];
                
                $length_class_description_builder->insert($length_class_description_insert_data);
            }
        }

        return $length_class_id;
    }

    public function editLengthClass($length_class_id, $data = [])
    {
        $length_class_update_builder = $this->db->table('length_class');

        $length_class_update_data = [
            'value' => $data['value'],
        ];

        $length_class_update_builder->where('length_class_id', $length_class_id);
        $length_class_update_builder->update($length_class_update_data);

        // Length class descriptions
        $length_class_delete_builder = $this->db->table('length_class_description');

        $length_class_delete_builder->where('length_class_id', $length_class_id);
        $length_class_delete_builder->delete();

        if (!empty($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $length_class_description_insert_builder = $this->db->table('length_class_description');

                $length_class_description_insert_data = [
                    'length_class_id' => $length_class_id,
                    'language_id' => $language_id,
                    'title' => $value['title'],
                    'unit' => $value['unit'],
                ];
                
                $length_class_description_insert_builder->insert($length_class_description_insert_data);
            }
        }

        return $length_class_id;
    }

    public function deleteLengthClass($length_class_id)
    {
        $length_class_delete_builder = $this->db->table('length_class');

        $length_class_delete_builder->where('length_class_id', $length_class_id);
        $length_class_delete_builder->delete();

        $length_class_description_delete_builder = $this->db->table('length_class_description');

        $length_class_description_delete_builder->where('length_class_id', $length_class_id);
        $length_class_description_delete_builder->delete();
    }

    public function getLengthClasses($data = [])
    {
        $length_class_builder = $this->db->table('length_class');

        $length_class_builder->join('length_class_description', 'length_class_description.length_class_id = length_class.length_class_id', 'left');

        $length_class_builder->where('length_class_description.language_id', $this->language->getCurrentId(true));

        $length_class_builder->orderBy('length_class_description.title', 'ASC');

        $length_class_query = $length_class_builder->get();

        $length_classes = [];

        foreach ($length_class_query->getResult() as $result) {
            $length_classes[] = [
                'length_class_id' => $result->length_class_id,
                'title' => $result->title,
                'unit' => $result->unit,
                'value' => $result->value,
            ];
        }

        return $length_classes;
    }

    public function getLengthClass($length_class_id)
    {
        $builder = $this->db->table('length_class');
        
        $builder->where('length_class_id', $length_class_id);

        $length_class_query = $builder->get();

        $length_class = [];

        if ($row = $length_class_query->getRow()) {
            $length_class = [
                'length_class_id' => $row->length_class_id,
                'value' => $row->value,
            ];
        }

        return $length_class;
    }

    public function getLengthClassDescriptions($length_class_id)
    {
        $length_class_description_builder = $this->db->table('length_class_description');

        $length_class_description_builder->where('length_class_id', $length_class_id);

        $length_class_description_query = $length_class_description_builder->get();

        $length_class_descriptions = [];

        foreach ($length_class_description_query->getResult() as $result) {
            $length_class_descriptions[$result->language_id] = [
                'length_class_description_id' => $result->length_class_description_id,
                'length_class_id' => $result->length_class_id,
                'language_id' => $result->language_id,
                'title' => $result->title,
                'unit' => $result->unit,
            ];
        }

        return $length_class_descriptions;
    }

    public function getLengthClassDescription($length_class_id)
    {
        $length_class_description_builder = $this->db->table('length_class_description');
        
        $length_class_description_builder->where('length_class_id', $length_class_id);

        $length_class_description_query = $builder->get();

        $length_class_description = [];

        if ($row = $length_class_description_query->getRow()) {
            $length_class_description = [
                'length_class_description_id' => $row->length_class_description_id,
                'length_class_id' => $row->length_class_id,
                'language_id' => $row->language_id,
                'title' => $row->title,
                'unit' => $row->unit,
            ];
        }

        return $length_class_description;
    }
}