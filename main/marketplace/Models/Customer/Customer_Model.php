<?php

namespace Main\Marketplace\Models\Customer;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Customer_Model extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['customer_group_id', 'firstname', 'lastname', 'telephone', 'email', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
    }

    public function addCustomer($data = [])
    {
        $customer_insert_builder = $this->db->table('customer');

        $customer_insert_data = [
            'customer_group_id' => $this->setting->get('setting_customer_group_id'),
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'status' => 1,
            'date_added' => new Time('now'),
            'date_modified' => new Time('now'),
        ];
        
        $customer_insert_builder->insert($customer_insert_data);

        $customer_id = $this->db->insertID();

        return $customer_id;
    }

    public function editCustomer($customer_id, $data = [])
    {
        $customer_update_builder = $this->db->table('customer');

        $customer_update_data = [
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'date_modified' => new Time('now'),
        ];

        $customer_update_builder->where('customer_id', $customer_id);
        $customer_update_builder->update($customer_update_data);

        return $customer_id;
    }

    public function deleteCustomer($customer_id)
    {
        $builder = $this->db->table('customer');

        $builder->where('customer_id', $customer_id);
        $builder->delete();
    }

    public function getCustomers($data = [])
    {
        $builder = $this->db->table('customer');

        $customer_query = $builder->get();

        $customers = [];

        foreach ($customer_query->getResult() as $result) {
            $customers[] = [
                'customer_id' => $result->customer_id,
                'customer_group_id' => $result->customer_group_id,
                'username' => $result->username,
                'firstname' => $result->firstname,
                'lastname' => $result->lastname,
                'telephone' => $result->telephone,
                'email' => $result->email,
                'status' => $result->status,
                ];
        }

        return $customers;
    }

    public function getCustomer($customer_id)
    {
        $builder = $this->db->table('customer');
        
        $builder->where('customer_id', $customer_id);

        $customer_query = $builder->get();

        $customer = [];

        if ($row = $customer_query->getRow()) {
            $customer = [
                'customer_id' => $row->customer_id,
                'customer_group_id' => $row->customer_group_id,
                'username' => $row->username,
                'firstname' => $row->firstname,
                'lastname' => $row->lastname,
                'telephone' => $row->telephone,
                'email' => $row->email,
                'status' => $row->status,
            ];
        }

        return $customer;
    }

    public function getCustomerAddresses($customer_id)
    {
        $builder = $this->db->table('customer_address');

        $customer_address_query = $builder->get();

        $customer_addresses = [];

        foreach ($customer_address_query->getResult() as $result) {
            $customer_addresses[] = [
                'customer_address_id' => $result->customer_address_id,
                'customer_id' => $result->customer_id,
                'firstname' => $result->firstname,
                'lastname' => $result->lastname,
                'address_1' => $result->address_1,
                'address_2' => $result->address_2,
                'city' => $result->city,
                'country_id' => $result->country_id,
                'zone_id' => $result->zone_id,
                'telephone' => $result->telephone,
            ];
        }

        return $customer_addresses;
    }
}