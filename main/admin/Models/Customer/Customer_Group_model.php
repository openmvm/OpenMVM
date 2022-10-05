<?php

namespace Main\Admin\Models\Customer;

use CodeIgniter\Model;

class Customer_Group_Model extends Model
{
    protected $table = 'customer_group';
    protected $primaryKey = 'customer_group_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'email_verification'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function addCustomerGroup($data = [])
    {
        $builder = $this->db->table('customer_group');

        $insert_data = [
            'name' => $data['name'],
            'email_verification' => $data['email_verification'],
        ];
        
        $builder->insert($insert_data);

        return $this->db->insertID();
    }

    public function editCustomerGroup($customer_group_id, $data = [])
    {
        $builder = $this->db->table('customer_group');

        $update_data = [
            'name' => $data['name'],
            'email_verification' => $data['email_verification'],
        ];

        $builder->where('customer_group_id', $customer_group_id);
        $builder->update($update_data);

        return $customer_group_id;
    }

    public function deleteCustomerGroup($customer_group_id)
    {
        $builder = $this->db->table('customer_group');

        $builder->where('customer_group_id', $customer_group_id);
        $builder->delete();
    }

    public function getCustomerGroups($data = [])
    {
        $builder = $this->db->table('customer_group');

        $customer_group_query = $builder->get();

        $customer_groups = [];

        foreach ($customer_group_query->getResult() as $result) {
            $customer_groups[] = [
                'customer_group_id' => $result->customer_group_id,
                'name' => $result->name,
                'email_verification' => $result->email_verification,
            ];
        }

        return $customer_groups;
    }

    public function getCustomerGroup($customer_group_id)
    {
        $builder = $this->db->table('customer_group');
        
        $builder->where('customer_group_id', $customer_group_id);

        $customer_group_query = $builder->get();

        $customer_group = [];

        if ($row = $customer_group_query->getRow()) {
            $customer_group = [
                'customer_group_id' => $row->customer_group_id,
                'name' => $row->name,
                'email_verification' => $row->email_verification,
            ];
        }

        return $customer_group;
    }
}