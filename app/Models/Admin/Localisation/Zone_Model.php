<?php

namespace App\Models\Admin\Localisation;

use CodeIgniter\Model;

class Zone_Model extends Model
{
    protected $table = 'zone';
    protected $primaryKey = 'zone_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'country_id', 'code', 'sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function addZone($data = [])
    {
        $builder = $this->db->table('zone');

        $insert_data = [
            'name' => $data['name'],
            'country_id' => $data['country_id'],
            'code' => $data['code'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];
        
        $builder->insert($insert_data);

        return $this->db->insertID();
    }

    public function editZone($zone_id, $data = [])
    {
        $builder = $this->db->table('zone');

        $update_data = [
            'name' => $data['name'],
            'country_id' => $data['country_id'],
            'code' => $data['code'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];

        $builder->where('zone_id', $zone_id);
        $builder->update($update_data);

        return $zone_id;
    }

    public function deleteZone($zone_id)
    {
        $builder = $this->db->table('zone');

        $builder->where('zone_id', $zone_id);
        $builder->delete();
    }

    public function getZones($data = [])
    {
        $builder = $this->db->table('zone');
        $builder->orderBy('sort_order', 'ASC');
        $builder->orderBy('name', 'ASC');

        $zone_query = $builder->get();

        $zones = [];

        foreach ($zone_query->getResult() as $result) {
            $zones[] = [
                'zone_id' => $result->zone_id,
                'name' => $result->name,
                'country_id' => $result->country_id,
                'code' => $result->code,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $zones;
    }

    public function getZone($zone_id)
    {
        $builder = $this->db->table('zone');
        
        $builder->where('zone_id', $zone_id);

        $zone_query = $builder->get();

        $zone = [];

        if ($row = $zone_query->getRow()) {
            $zone = [
                'zone_id' => $row->zone_id,
                'name' => $row->name,
                'country_id' => $row->country_id,
                'code' => $row->code,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $zone;
    }

    public function getZonesByCountryId($country_id, $data = [])
    {
        $builder = $this->db->table('zone');
        $builder->where('country_id', $country_id);
        $builder->orderBy('sort_order', 'ASC');
        $builder->orderBy('name', 'ASC');

        $zone_query = $builder->get();

        $zones = [];

        foreach ($zone_query->getResult() as $result) {
            $zones[] = [
                'zone_id' => $result->zone_id,
                'name' => $result->name,
                'country_id' => $result->country_id,
                'code' => $result->code,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $zones;
    }
}