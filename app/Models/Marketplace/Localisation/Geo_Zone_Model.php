<?php

namespace App\Models\Marketplace\Localisation;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Geo_Zone_Model extends Model
{
    protected $table = 'geo_zone';
    protected $primaryKey = 'geo_zone_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'description', 'date_added', 'date_modified'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getGeoZones($data = [])
    {
        $builder = $this->db->table('geo_zone');

        $geo_zone_query = $builder->get();

        $geo_zones = [];

        foreach ($geo_zone_query->getResult() as $result) {
            $geo_zones[] = [
                'geo_zone_id' => $result->geo_zone_id,
                'name' => $result->name,
                'description' => $result->description,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
            ];
        }

        return $geo_zones;
    }

    public function getGeoZone($geo_zone_id)
    {
        $builder = $this->db->table('geo_zone');
        
        $builder->where('geo_zone_id', $geo_zone_id);

        $geo_zone_query = $builder->get();

        $geo_zone = [];

        if ($row = $geo_zone_query->getRow()) {
            $geo_zone = [
                'geo_zone_id' => $row->geo_zone_id,
                'name' => $row->name,
                'description' => $row->description,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
            ];
        }

        return $geo_zone;
    }

    public function getZoneToGeoZones($geo_zone_id)
    {
        $builder = $this->db->table('zone_to_geo_zone');
        
        $builder->where('geo_zone_id', $geo_zone_id);

        $zone_to_geo_zone_query = $builder->get();

        $zone_to_geo_zones = [];

        foreach ($zone_to_geo_zone_query->getResult() as $result) {
            $zone_to_geo_zones[] = [
                'zone_to_geo_zone_id' => $result->zone_to_geo_zone_id,
                'country_id' => $result->country_id,
                'zone_id' => $result->zone_id,
                'geo_zone_id' => $result->geo_zone_id,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
            ];
        }

        return $zone_to_geo_zones;
    }
}