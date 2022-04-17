<?php

namespace App\Models\Marketplace\Localisation;

use CodeIgniter\Model;

class Country_Model extends Model
{
    protected $table = 'country';
    protected $primaryKey = 'country_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'iso_code_2', 'iso_code_3', 'dialing_code', 'postal_code_required', 'address_format', 'sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getCountries($data = [])
    {
        $country_builder = $this->db->table('country');

        $country_query = $country_builder->get();

        $countries = [];

        foreach ($country_query->getResult() as $result) {
            $countries[] = [
                'country_id' => $result->country_id,
                'name' => $result->name,
                'iso_code_2' => $result->iso_code_2,
                'iso_code_3' => $result->iso_code_3,
                'dialing_code' => $result->dialing_code,
                'postal_code_required' => $result->postal_code_required,
                'address_format' => $result->address_format,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $countries;
    }

    public function getCountry($country_id)
    {
        $country_builder = $this->db->table('country');
        
        $country_builder->where('country_id', $country_id);

        $country_query = $country_builder->get();

        $country = [];

        if ($row = $country_query->getRow()) {
            $country = [
                'country_id' => $row->country_id,
                'name' => $row->name,
                'iso_code_2' => $row->iso_code_2,
                'iso_code_3' => $row->iso_code_3,
                'dialing_code' => $row->dialing_code,
                'postal_code_required' => $row->postal_code_required,
                'address_format' => $row->address_format,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $country;
    }
}