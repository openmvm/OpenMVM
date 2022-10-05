<?php

namespace Main\Marketplace\Models\Seller;

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

    public function addGeoZone($seller_id, $data = [])
    {
        $builder = $this->db->table('seller_geo_zone');

        $insert_data = [
            'seller_id' => $seller_id,
            'name' => $data['name'],
            'description' => $data['description'],
            'date_added' => new Time('now'),
            'date_modified' => new Time('now'),
        ];
        
        $builder->insert($insert_data);

        $seller_geo_zone_id = $this->db->insertID();

        // Geo zones
        if (!empty($data['seller_zone_to_geo_zone'])) {
            foreach ($data['seller_zone_to_geo_zone'] as $seller_zone_to_geo_zone) {
                $seller_zone_to_geo_zone_insert_builder = $this->db->table('seller_zone_to_geo_zone');

                $seller_zone_to_geo_zone_insert_data = [
                    'seller_id' => $seller_id,
                    'country_id' => $seller_zone_to_geo_zone['country_id'],
                    'zone_id' => $seller_zone_to_geo_zone['zone_id'],
                    'seller_geo_zone_id' => $seller_geo_zone_id,
                    'date_added' => new Time('now'),
                    'date_modified' => new Time('now'),
                ];
                
                $seller_zone_to_geo_zone_insert_builder->insert($seller_zone_to_geo_zone_insert_data);
            }
        }

        return $seller_geo_zone_id;
    }

    public function editGeoZone($seller_id, $seller_geo_zone_id, $data = [])
    {
        $builder = $this->db->table('seller_geo_zone');

        $update_data = [
            'name' => $data['name'],
            'description' => $data['description'],
            'date_added' => new Time('now'),
            'date_modified' => new Time('now'),
        ];

        $builder->where('seller_id', $seller_id);
        $builder->where('seller_geo_zone_id', $seller_geo_zone_id);
        $builder->update($update_data);

        // Geo zones
        $seller_zone_to_geo_zone_delete_builder = $this->db->table('seller_zone_to_geo_zone');

        $seller_zone_to_geo_zone_delete_builder->where('seller_geo_zone_id', $seller_geo_zone_id);
        $seller_zone_to_geo_zone_delete_builder->delete();

        if (!empty($data['seller_zone_to_geo_zone'])) {
            foreach ($data['seller_zone_to_geo_zone'] as $seller_zone_to_geo_zone) {
                $seller_zone_to_geo_zone_insert_builder = $this->db->table('seller_zone_to_geo_zone');

                $seller_zone_to_geo_zone_insert_data = [
                    'seller_id' => $seller_id,
                    'country_id' => $seller_zone_to_geo_zone['country_id'],
                    'zone_id' => $seller_zone_to_geo_zone['zone_id'],
                    'seller_geo_zone_id' => $seller_geo_zone_id,
                    'date_added' => new Time('now'),
                    'date_modified' => new Time('now'),
                ];
                
                $seller_zone_to_geo_zone_insert_builder->insert($seller_zone_to_geo_zone_insert_data);
            }
        }

        return $seller_geo_zone_id;
    }

    public function deleteGeoZone($seller_id, $seller_geo_zone_id)
    {
        $builder = $this->db->table('seller_geo_zone');

        $builder->where('seller_id', $seller_id);
        $builder->where('seller_geo_zone_id', $seller_geo_zone_id);
        $builder->delete();
    }

    public function getGeoZones($seller_id, $data = [])
    {
        $builder = $this->db->table('seller_geo_zone');

        $builder->where('seller_id', $seller_id);

        $seller_geo_zone_query = $builder->get();

        $seller_geo_zones = [];

        foreach ($seller_geo_zone_query->getResult() as $result) {
            $seller_geo_zones[] = [
                'seller_geo_zone_id' => $result->seller_geo_zone_id,
                'name' => $result->name,
                'description' => $result->description,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
            ];
        }

        return $seller_geo_zones;
    }

    public function getGeoZone($seller_id, $seller_geo_zone_id)
    {
        $builder = $this->db->table('seller_geo_zone');
        
        $builder->where('seller_id', $seller_id);
        $builder->where('seller_geo_zone_id', $seller_geo_zone_id);

        $seller_geo_zone_query = $builder->get();

        $seller_geo_zone = [];

        if ($row = $seller_geo_zone_query->getRow()) {
            $seller_geo_zone = [
                'seller_geo_zone_id' => $row->seller_geo_zone_id,
                'name' => $row->name,
                'description' => $row->description,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
            ];
        }

        return $seller_geo_zone;
    }

    public function getZoneToGeoZones($seller_id, $seller_geo_zone_id)
    {
        $builder = $this->db->table('seller_zone_to_geo_zone');
        
        $builder->where('seller_id', $seller_id);
        $builder->where('seller_geo_zone_id', $seller_geo_zone_id);

        $seller_zone_to_geo_zone_query = $builder->get();

        $seller_zone_to_geo_zones = [];

        foreach ($seller_zone_to_geo_zone_query->getResult() as $result) {
            $seller_zone_to_geo_zones[] = [
                'seller_zone_to_geo_zone_id' => $result->seller_zone_to_geo_zone_id,
                'country_id' => $result->country_id,
                'zone_id' => $result->zone_id,
                'seller_geo_zone_id' => $result->seller_geo_zone_id,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
            ];
        }

        return $seller_zone_to_geo_zones;
    }
}