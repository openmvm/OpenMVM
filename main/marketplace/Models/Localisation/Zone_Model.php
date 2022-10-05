<?php

namespace Main\Marketplace\Models\Localisation;

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

    public function getZones($data = [])
    {
        $zone_builder = $this->db->table('zone');

        $zone_query = $zone_builder->get();

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
        $zone_builder = $this->db->table('zone');
        
        $zone_builder->where('zone_id', $zone_id);

        $zone_query = $zone_builder->get();

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
        $zone_builder = $this->db->table('zone');

        $zone_builder->where('country_id', $country_id);

        $zone_query = $zone_builder->get();

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