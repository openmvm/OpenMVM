<?php

namespace App\Models\Marketplace\Localisation;

use CodeIgniter\Model;

class Weight_Class_Model extends Model
{
    protected $table = 'weight_class';
    protected $primaryKey = 'weight_class_id';
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

    public function getWeightClasses($data = [])
    {
        $weight_class_builder = $this->db->table('weight_class');

        $weight_class_builder->join('weight_class_description', 'weight_class_description.weight_class_id = weight_class.weight_class_id', 'left');

        $weight_class_builder->where('weight_class_description.language_id', $this->language->getCurrentId());

        $weight_class_builder->orderBy('weight_class_description.title', 'ASC');

        $weight_class_query = $weight_class_builder->get();

        $weight_classes = [];

        foreach ($weight_class_query->getResult() as $result) {
            $weight_classes[] = [
                'weight_class_id' => $result->weight_class_id,
                'title' => $result->title,
                'unit' => $result->unit,
                'value' => $result->value,
            ];
        }

        return $weight_classes;
    }

    public function getWeightClass($weight_class_id)
    {
        $builder = $this->db->table('weight_class');
        
        $builder->where('weight_class_id', $weight_class_id);

        $weight_class_query = $builder->get();

        $weight_class = [];

        if ($row = $weight_class_query->getRow()) {
            $weight_class = [
                'weight_class_id' => $row->weight_class_id,
                'value' => $row->value,
            ];
        }

        return $weight_class;
    }

    public function getWeightClassDescriptions($weight_class_id)
    {
        $weight_class_description_builder = $this->db->table('weight_class_description');

        $weight_class_description_builder->where('weight_class_id', $weight_class_id);

        $weight_class_description_query = $weight_class_description_builder->get();

        $weight_class_descriptions = [];

        foreach ($weight_class_description_query->getResult() as $result) {
            $weight_class_descriptions[$result->language_id] = [
                'weight_class_description_id' => $result->weight_class_description_id,
                'weight_class_id' => $result->weight_class_id,
                'language_id' => $result->language_id,
                'title' => $result->title,
                'unit' => $result->unit,
            ];
        }

        return $weight_class_descriptions;
    }

    public function getWeightClassDescription($weight_class_id)
    {
        $weight_class_description_builder = $this->db->table('weight_class_description');
        
        $weight_class_description_builder->where('weight_class_id', $weight_class_id);

        $weight_class_description_query = $builder->get();

        $weight_class_description = [];

        if ($row = $weight_class_description_query->getRow()) {
            $weight_class_description = [
                'weight_class_description_id' => $row->weight_class_description_id,
                'weight_class_id' => $row->weight_class_id,
                'language_id' => $row->language_id,
                'title' => $row->title,
                'unit' => $row->unit,
            ];
        }

        return $weight_class_description;
    }
}