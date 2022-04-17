<?php

namespace App\Models\Admin\Localisation;

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

    public function addGeoZone($data = [])
    {
        $builder = $this->db->table('geo_zone');

        $insert_data = [
            'name' => $data['name'],
            'description' => $data['description'],
            'date_added' => new Time('now'),
            'date_modified' => new Time('now'),
        ];
        
        $builder->insert($insert_data);

        $geo_zone_id = $this->db->insertID();

        // Geo zones
        if (!empty($data['zone_to_geo_zone'])) {
            foreach ($data['zone_to_geo_zone'] as $zone_to_geo_zone) {
                $zone_to_geo_zone_insert_builder = $this->db->table('zone_to_geo_zone');

                $zone_to_geo_zone_insert_data = [
                    'country_id' => $zone_to_geo_zone['country_id'],
                    'zone_id' => $zone_to_geo_zone['zone_id'],
                    'geo_zone_id' => $geo_zone_id,
                    'date_added' => new Time('now'),
                    'date_modified' => new Time('now'),
                ];
                
                $zone_to_geo_zone_insert_builder->insert($zone_to_geo_zone_insert_data);
            }
        }

        return $geo_zone_id;
    }

    public function editGeoZone($geo_zone_id, $data = [])
    {
        $builder = $this->db->table('geo_zone');

        $update_data = [
            'name' => $data['name'],
            'description' => $data['description'],
            'date_added' => new Time('now'),
            'date_modified' => new Time('now'),
        ];

        $builder->where('geo_zone_id', $geo_zone_id);
        $builder->update($update_data);

        // Geo zones
        $zone_to_geo_zone_delete_builder = $this->db->table('zone_to_geo_zone');

        $zone_to_geo_zone_delete_builder->where('geo_zone_id', $geo_zone_id);
        $zone_to_geo_zone_delete_builder->delete();

        if (!empty($data['zone_to_geo_zone'])) {
            foreach ($data['zone_to_geo_zone'] as $zone_to_geo_zone) {
                $zone_to_geo_zone_insert_builder = $this->db->table('zone_to_geo_zone');

                $zone_to_geo_zone_insert_data = [
                    'country_id' => $zone_to_geo_zone['country_id'],
                    'zone_id' => $zone_to_geo_zone['zone_id'],
                    'geo_zone_id' => $geo_zone_id,
                    'date_added' => new Time('now'),
                    'date_modified' => new Time('now'),
                ];
                
                $zone_to_geo_zone_insert_builder->insert($zone_to_geo_zone_insert_data);
            }
        }

        return $geo_zone_id;
    }

    public function deleteGeoZone($geo_zone_id)
    {
        $builder = $this->db->table('geo_zone');

        $builder->where('geo_zone_id', $geo_zone_id);
        $builder->delete();
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