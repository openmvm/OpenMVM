<?php

namespace Main\Marketplace\Models\Seller;

use CodeIgniter\Model;

class Option_Model extends Model
{
    protected $table = 'option';
    protected $primaryKey = 'option_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['option_id', 'seller_id', 'customer_id'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
        $this->customer = new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->text = new \App\Libraries\Text();
        // Helpers
        helper('date');
    }

    public function addOption($data = [])
    {
        $option_insert_builder = $this->db->table('option');

        $option_insert_data = [
            'seller_id' => $this->customer->getSellerId(),
            'customer_id' => $this->customer->getId(),
            'sort_order' => $data['sort_order'],
            'status' => 1,
        ];
        
        $option_insert_builder->insert($option_insert_data);

        $option_id = $this->db->insertID();

        // Option Descriptions
        if ($data['option_description']) {
            foreach ($data['option_description'] as $language_id => $value) {
                $option_description_builder = $this->db->table('option_description');

                $option_description_insert_data = [
                    'option_id' => $option_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'language_id' => $language_id,
                    'name' => $value['name'],
                ];
                
                $option_description_builder->insert($option_description_insert_data);
            }
        }

        // Option value
        if (!empty($data['option_value'])) {
            foreach ($data['option_value'] as $option_value) {
                $option_value_builder = $this->db->table('option_value');

                $option_value_insert_data = [
                    'option_id' => $option_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'sort_order' => $option_value['sort_order'],
                    'status' => 1,
                ];
                
                $option_value_builder->insert($option_value_insert_data);

                $option_value_id = $this->db->insertID();

                foreach ($option_value['description'] as $language_id => $value) {
                    $option_value_description_builder = $this->db->table('option_value_description');

                    $option_value_description_insert_data = [
                        'option_value_id' => $option_value_id,
                        'option_id' => $option_id,
                        'seller_id' => $this->customer->getSellerId(),
                        'customer_id' => $this->customer->getId(),
                        'language_id' => $language_id,
                        'name' => $value['name'],
                    ];
                    
                    $option_value_description_builder->insert($option_value_description_insert_data);
                }
            }
        }

        return $option_id;
    }

    public function editOption($option_id, $data = [])
    {
        $option_update_builder = $this->db->table('option');

        $option_update_data = [
            'sort_order' => $data['sort_order'],
            'status' => 1,
        ];

        $option_update_builder->where('seller_id', $this->customer->getSellerId());
        $option_update_builder->where('customer_id', $this->customer->getId());
        $option_update_builder->where('option_id', $option_id);
        $option_update_builder->update($option_update_data);
        
        // Delete option descriptions
        $builder = $this->db->table('option_description');

        $builder->where('option_id', $option_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        // Option Descriptions
        if (!empty($data['option_description'])) {
            foreach ($data['option_description'] as $language_id => $value) {
                $option_description_builder = $this->db->table('option_description');

                $option_description_insert_data = [
                    'option_id' => $option_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'language_id' => $language_id,
                    'name' => $value['name'],
                ];
                
                $option_description_builder->insert($option_description_insert_data);
            }
        }

        // Option value
        // Delete option value descriptions
        $builder = $this->db->table('option_value_description');

        $builder->where('option_id', $option_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        if (!empty($data['option_value'])) {
            foreach ($data['option_value'] as $option_value) {
                if (!empty($option_value['option_value_id'])) {
                    // Update option value
                    $option_value_update_builder = $this->db->table('option_value');

                    $option_value_update_data = [
                        'sort_order' => $option_value['sort_order'],
                        'status' => 1,
                    ];

                    $option_value_update_builder->where('seller_id', $this->customer->getSellerId());
                    $option_value_update_builder->where('customer_id', $this->customer->getId());
                    $option_value_update_builder->where('option_id', $option_id);
                    $option_value_update_builder->where('option_value_id', $option_value['option_value_id']);
                    $option_value_update_builder->update($option_value_update_data);

                    $option_value_id = $option_value['option_value_id'];
                } else {
                    // Insert option value
                    $option_value_builder = $this->db->table('option_value');

                    $option_value_insert_data = [
                        'option_id' => $option_id,
                        'seller_id' => $this->customer->getSellerId(),
                        'customer_id' => $this->customer->getId(),
                        'sort_order' => $option_value['sort_order'],
                        'status' => 1,
                    ];
                    
                    $option_value_builder->insert($option_value_insert_data);

                    $option_value_id = $this->db->insertID();
                }

                // Insert option value description
                foreach ($option_value['description'] as $language_id => $value) {
                    $option_value_description_builder = $this->db->table('option_value_description');

                    $option_value_description_insert_data = [
                        'option_value_id' => $option_value_id,
                        'option_id' => $option_id,
                        'seller_id' => $this->customer->getSellerId(),
                        'customer_id' => $this->customer->getId(),
                        'language_id' => $language_id,
                        'name' => $value['name'],
                    ];
                    
                    $option_value_description_builder->insert($option_value_description_insert_data);
                }
            }
        }

        return $option_id;
    }

    public function deleteOption($option_id)
    {
        // Delete option
        $builder = $this->db->table('option');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('option_id', $option_id);
        $builder->delete();

        // Delete option descriptions
        $builder = $this->db->table('option_description');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('option_id', $option_id);
        $builder->delete();

        // Delete option value
        $builder = $this->db->table('option_value');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('option_id', $option_id);
        $builder->delete();

        // Delete option value descriptions
        $builder = $this->db->table('option_value_description');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('option_id', $option_id);
        $builder->delete();
    }

    public function getOptions($data = [])
    {
        $builder = $this->db->table('option o');
        $builder->join('option_description od', 'o.option_id = od.option_id', 'left');

        $builder->where('o.seller_id', $this->customer->getSellerId());
        $builder->where('o.customer_id', $this->customer->getId());
        $builder->where('od.language_id', $this->language->getCurrentId());

        if (!empty($data['filter_name'])) {
            $builder->like('od.name', $data['filter_name']);
        }

        $builder->groupBy('od.option_id');
        
        $builder->orderBy('od.name', 'ASC');

        $option_query = $builder->get();

        $options = [];

        foreach ($option_query->getResult() as $result) {
            $options[] = [
                'option_id' => $result->option_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'name' => $result->name,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $options;
    }

    public function getOption($option_id)
    {
        $builder = $this->db->table('option o');
        $builder->join('option_description od', 'o.option_id = od.option_id', 'left');
        
        $builder->where('o.seller_id', $this->customer->getSellerId());
        $builder->where('o.customer_id', $this->customer->getId());
        $builder->where('o.option_id', $option_id);
        $builder->where('od.language_id', $this->language->getCurrentId());

        $option_query = $builder->get();

        $option = [];

        if ($row = $option_query->getRow()) {
            $option = [
                'option_id' => $row->option_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'name' => $row->name,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $option;
    }

    public function getOptionDescriptions($option_id)
    {
        $builder = $this->db->table('option_description');
        
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('option_id', $option_id);

        $option_description_query = $builder->get();

        $option_descriptions = [];

        foreach ($option_description_query->getResult() as $result) {
            $option_descriptions[$result->language_id] = [
                'name' => $result->name,
            ];
        }

        return $option_descriptions;
    }

    public function getOptionDescription($option_id)
    {
        $builder = $this->db->table('option_description');
        
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('option_id', $option_id);
        $builder->where('language_id', $this->language->getCurrentId());

        $option_description_query = $builder->get();

        $option_description = [];

        if ($row = $option_description_query->getRow()) {
            $option_description = [
                'name' => $row->name,
            ];
        }

        return $option_description;
    }

    public function getOptionValues($option_id)
    {
        $builder = $this->db->table('option_value');

        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('option_id', $option_id);
        $builder->orderBy('sort_order', 'ASC');

        $option_value_query = $builder->get();

        $option_values = [];

        foreach ($option_value_query->getResult() as $result) {
            // Get option value descriptions
            $option_value_description_data = [];

            $option_value_descriptions = $this->getOptionValueDescriptions($option_id, $result->option_value_id);

            $option_values[] = [
                'option_value_id' => $result->option_value_id,
                'option_id' => $result->option_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
                'description' => $option_value_descriptions,
            ];
        }

        return $option_values;
    }

    public function getOptionValueDescriptions($option_id, $option_value_id)
    {
        $builder = $this->db->table('option_value_description');
        
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('option_id', $option_id);
        $builder->where('option_value_id', $option_value_id);

        $option_value_description_query = $builder->get();

        $option_value_descriptions = [];

        foreach ($option_value_description_query->getResult() as $result) {
            $option_value_descriptions[$result->language_id] = [
                'name' => $result->name,
            ];
        }

        return $option_value_descriptions;
    }

    public function getOptionValue($option_id, $option_value_id)
    {
        $builder = $this->db->table('option_value ov');
        $builder->join('option_value_description ovd', 'ov.option_value_id = ovd.option_value_id', 'left');
        
        $builder->where('ov.seller_id', $this->customer->getSellerId());
        $builder->where('ov.customer_id', $this->customer->getId());
        $builder->where('ov.option_id', $option_id);
        $builder->where('ov.option_value_id', $option_value_id);
        $builder->where('ovd.language_id', $this->language->getCurrentId());

        $option_query = $builder->get();

        $option = [];

        if ($row = $option_query->getRow()) {
            $option = [
                'option_value_id' => $row->option_value_id,
                'option_id' => $row->option_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'name' => $row->name,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $option;
    }

    public function getOptionValueDescription($option_id, $option_value_id)
    {
        $builder = $this->db->table('option_value_description');
        
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->where('option_id', $option_id);
        $builder->where('option_value_id', $option_value_id);
        $builder->where('language_id', $this->language->getCurrentId());

        $option_value_description_query = $builder->get();

        $option_value_description = [];

        if ($row = $option_value_description_query->getRow()) {
            $option_value_description = [
                'name' => $row->name,
            ];
        }

        return $option_value_description;
    }
}