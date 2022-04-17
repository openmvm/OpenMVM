<?php

namespace App\Models\Admin\Localisation;

use CodeIgniter\Model;

class Country_Model extends Model
{
    protected $table = 'country';
    protected $primaryKey = 'country_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'iso_code_2', 'iso_code_3', 'dialing_code', 'sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function addCountry($data = [])
    {
        $builder = $this->db->table('country');

        $insert_data = [
            'name' => $data['name'],
            'iso_code_2' => $data['iso_code_2'],
            'iso_code_3' => $data['iso_code_3'],
            'dialing_code' => $data['dialing_code'],
            'postal_code_required' => $data['postal_code_required'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];
        
        $builder->insert($insert_data);

        return $this->db->insertID();
    }

    public function editCountry($country_id, $data = [])
    {
        $builder = $this->db->table('country');

        $update_data = [
            'name' => $data['name'],
            'iso_code_2' => $data['iso_code_2'],
            'iso_code_3' => $data['iso_code_3'],
            'dialing_code' => $data['dialing_code'],
            'postal_code_required' => $data['postal_code_required'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];

        $builder->where('country_id', $country_id);
        $builder->update($update_data);

        return $country_id;
    }

    public function deleteCountry($country_id)
    {
        $builder = $this->db->table('country');

        $builder->where('country_id', $country_id);
        $builder->delete();
    }

    public function getCountries($data = [])
    {
        $builder = $this->db->table('country');
        $builder->orderBy('sort_order', 'ASC');
        $builder->orderBy('name', 'ASC');

        $country_query = $builder->get();

        $countries = [];

        foreach ($country_query->getResult() as $result) {
            $countries[] = [
                'country_id' => $result->country_id,
                'name' => $result->name,
                'iso_code_2' => $result->iso_code_2,
                'iso_code_3' => $result->iso_code_3,
                'dialing_code' => $result->dialing_code,
                'postal_code_required' => $result->postal_code_required,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $countries;
    }

    public function getCountry($country_id)
    {
        $builder = $this->db->table('country');
        
        $builder->where('country_id', $country_id);

        $country_query = $builder->get();

        $country = [];

        if ($row = $country_query->getRow()) {
            $country = [
                'country_id' => $row->country_id,
                'name' => $row->name,
                'iso_code_2' => $row->iso_code_2,
                'iso_code_3' => $row->iso_code_3,
                'dialing_code' => $row->dialing_code,
                'postal_code_required' => $row->postal_code_required,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $country;
    }
}