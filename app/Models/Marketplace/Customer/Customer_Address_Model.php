<?php

namespace App\Models\Marketplace\Customer;

use CodeIgniter\Model;

class Customer_Address_Model extends Model
{
    protected $table = 'customer_address';
    protected $primaryKey = 'customer_address_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['customer_id', 'firstname', 'lastname', 'address_1', 'address_2', 'city', 'country_id', 'zone_id', 'telephone'];
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

    public function addCustomerAddress($customer_id, $data = [])
    {
        $customer_address_insert_builder = $this->db->table('customer_address');

        $customer_address_insert_data = [
            'customer_id' => $customer_id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address_1' => $data['address_1'],
            'address_2' => $data['address_2'],
            'city' => $data['city'],
            'country_id' => $data['country_id'],
            'zone_id' => $data['zone_id'],
            'telephone' => $data['telephone'],
        ];
        
        $customer_address_insert_builder->insert($customer_address_insert_data);

        $customer_address_id = $this->db->insertID();

        return $customer_address_id;
    }

    public function editCustomerAddress($customer_id, $customer_address_id, $data = [])
    {
        $customer_address_update_builder = $this->db->table('customer_address');

        $customer_address_update_data = [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address_1' => $data['address_1'],
            'address_2' => $data['address_2'],
            'city' => $data['city'],
            'country_id' => $data['country_id'],
            'zone_id' => $data['zone_id'],
            'telephone' => $data['telephone'],
        ];

        $customer_address_update_builder->where('customer_id', $customer_id);
        $customer_address_update_builder->where('customer_address_id', $customer_address_id);
        $customer_address_update_builder->update($customer_address_update_data);

        return $customer_address_id;
    }

    public function deleteCustomerAddress($customer_id, $customer_address_id)
    {
        $builder = $this->db->table('customer_address');

        $builder->where('customer_id', $customer_id);
        $builder->where('customer_address_id', $customer_address_id);
        $builder->delete();
    }

    public function getCustomerAddresses($customer_id, $data = [])
    {
        $customer_address_builder = $this->db->table('customer_address');

        $customer_address_builder->where('customer_id', $customer_id);

        $customer_address_query = $customer_address_builder->get();

        $customer_addresses = [];

        foreach ($customer_address_query->getResult() as $result) {
            // Get country info
            $country_builder = $this->db->table('country');
        
            $country_builder->where('country_id', $result->country_id);
    
            $country_query = $country_builder->get();
    
            $country = [];
    
            if ($row = $country_query->getRow()) {
                $country = $row->name;
            } else {
                $country = '';
            }

            // Get zone info
            $zone_builder = $this->db->table('zone');
        
            $zone_builder->where('zone_id', $result->zone_id);
    
            $zone_query = $zone_builder->get();
    
            $zone = [];
    
            if ($row = $zone_query->getRow()) {
                $zone = $row->name;
            } else {
                $zone = '';
            }
        
            $customer_addresses[] = [
                'customer_address_id' => $result->customer_address_id,
                'customer_id' => $result->customer_id,
                'firstname' => $result->firstname,
                'lastname' => $result->lastname,
                'address_1' => $result->address_1,
                'address_2' => $result->address_2,
                'city' => $result->city,
                'country_id' => $result->country_id,
                'country' => $country,
                'zone_id' => $result->zone_id,
                'zone' => $zone,
                'telephone' => $result->telephone,
            ];
        }

        return $customer_addresses;
    }

    public function getCustomerAddress($customer_id, $customer_address_id)
    {
        $customer_address_builder = $this->db->table('customer_address');
        
        $customer_address_builder->where('customer_id', $customer_id);
        $customer_address_builder->where('customer_address_id', $customer_address_id);

        $customer_address_query = $customer_address_builder->get();

        $customer_address = [];

        if ($row = $customer_address_query->getRow()) {
            // Get country info
            $country_builder = $this->db->table('country');
        
            $country_builder->where('country_id', $row->country_id);
    
            $country_query = $country_builder->get();
    
            $country = [];
    
            if ($country_row = $country_query->getRow()) {
                $country = $country_row->name;
            } else {
                $country = '';
            }

            // Get zone info
            $zone_builder = $this->db->table('zone');
        
            $zone_builder->where('zone_id', $row->zone_id);
    
            $zone_query = $zone_builder->get();
    
            $zone = [];
    
            if ($zone_row = $zone_query->getRow()) {
                $zone = $zone_row->name;
            } else {
                $zone = '';
            }
        
            $customer_address = [
                'customer_address_id' => $row->customer_address_id,
                'customer_id' => $row->customer_id,
                'firstname' => $row->firstname,
                'lastname' => $row->lastname,
                'address_1' => $row->address_1,
                'address_2' => $row->address_2,
                'city' => $row->city,
                'country_id' => $row->country_id,
                'country' => $country,
                'zone_id' => $row->zone_id,
                'zone' => $zone,
                'telephone' => $row->telephone,
            ];
        }

        return $customer_address;
    }
}