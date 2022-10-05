<?php

namespace Main\Admin\Models\Localisation;

use CodeIgniter\Model;

class Order_Status_Model extends Model
{
    protected $table = 'order_status';
    protected $primaryKey = 'order_status_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name'];
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

    public function addOrderStatus($data = [])
    {
        $order_status_insert_builder = $this->db->table('order_status');

        $order_status_insert_data = [
            'status' => 1,
        ];
        
        $order_status_insert_builder->insert($order_status_insert_data);

        $order_status_id = $this->db->insertID();

        // Weight class descriptions
        if (!empty($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $order_status_description_builder = $this->db->table('order_status_description');

                $order_status_description_insert_data = [
                    'order_status_id' => $order_status_id,
                    'language_id' => $language_id,
                    'name' => $value['name'],
                ];
                
                $order_status_description_builder->insert($order_status_description_insert_data);
            }
        }

        return $order_status_id;
    }

    public function editOrderStatus($order_status_id, $data = [])
    {
        $order_status_update_builder = $this->db->table('order_status');

        $order_status_update_data = [
            'status' => 1,
        ];

        $order_status_update_builder->where('order_status_id', $order_status_id);
        $order_status_update_builder->update($order_status_update_data);

        // Weight class descriptions
        $order_status_delete_builder = $this->db->table('order_status_description');

        $order_status_delete_builder->where('order_status_id', $order_status_id);
        $order_status_delete_builder->delete();

        if (!empty($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $order_status_description_insert_builder = $this->db->table('order_status_description');

                $order_status_description_insert_data = [
                    'order_status_id' => $order_status_id,
                    'language_id' => $language_id,
                    'name' => $value['name'],
                ];
                
                $order_status_description_insert_builder->insert($order_status_description_insert_data);
            }
        }

        return $order_status_id;
    }

    public function deleteOrderStatus($order_status_id)
    {
        $order_status_delete_builder = $this->db->table('order_status');

        $order_status_delete_builder->where('order_status_id', $order_status_id);
        $order_status_delete_builder->delete();

        $order_status_description_delete_builder = $this->db->table('order_status_description');

        $order_status_description_delete_builder->where('order_status_id', $order_status_id);
        $order_status_description_delete_builder->delete();
    }

    public function getOrderStatuses($data = [])
    {
        $order_status_builder = $this->db->table('order_status');

        $order_status_builder->join('order_status_description', 'order_status_description.order_status_id = order_status.order_status_id', 'left');

        $order_status_builder->where('order_status_description.language_id', $this->language->getCurrentId(true));

        $order_status_builder->orderBy('order_status_description.name', 'ASC');

        $order_status_query = $order_status_builder->get();

        $order_statuses = [];

        foreach ($order_status_query->getResult() as $result) {
            $order_statuses[] = [
                'order_status_id' => $result->order_status_id,
                'name' => $result->name,
            ];
        }

        return $order_statuses;
    }

    public function getOrderStatus($order_status_id)
    {
        $builder = $this->db->table('order_status');
        
        $builder->where('order_status_id', $order_status_id);

        $order_status_query = $builder->get();

        $order_status = [];

        if ($row = $order_status_query->getRow()) {
            $order_status = [
                'order_status_id' => $row->order_status_id,
                'status' => $row->status,
            ];
        }

        return $order_status;
    }

    public function getOrderStatusDescriptions($order_status_id)
    {
        $order_status_description_builder = $this->db->table('order_status_description');

        $order_status_description_builder->where('order_status_id', $order_status_id);

        $order_status_description_query = $order_status_description_builder->get();

        $order_status_descriptions = [];

        foreach ($order_status_description_query->getResult() as $result) {
            $order_status_descriptions[$result->language_id] = [
                'order_status_description_id' => $result->order_status_description_id,
                'order_status_id' => $result->order_status_id,
                'language_id' => $result->language_id,
                'name' => $result->name,
            ];
        }

        return $order_status_descriptions;
    }

    public function getOrderStatusDescription($order_status_id)
    {
        $order_status_description_builder = $this->db->table('order_status_description');
        
        $order_status_description_builder->where('order_status_id', $order_status_id);

        $order_status_description_query = $builder->get();

        $order_status_description = [];

        if ($row = $order_status_description_query->getRow()) {
            $order_status_description = [
                'order_status_description_id' => $row->order_status_description_id,
                'order_status_id' => $row->order_status_id,
                'language_id' => $row->language_id,
                'name' => $row->name,
            ];
        }

        return $order_status_description;
    }
}