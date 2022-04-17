<?php

namespace App\Models\Admin\Appearance;

use CodeIgniter\Model;

class Layout_Model extends Model
{
    protected $table = 'layout';
    protected $primaryKey = 'layout_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['location', 'name'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function addLayout($location, $data = [])
    {
        $layout_insert_builder = $this->db->table('layout');

        $layout_insert_data = [
            'location' => $location,
            'name' => $data['name'],
        ];
        
        $layout_insert_builder->insert($layout_insert_data);

        $layout_id = $this->db->insertID();

        // Routes
        if (!empty($data['route'])) {
            foreach ($data['route'] as $route) {
                $layout_route_insert_builder = $this->db->table('layout_route');

                $layout_route_insert_data = [
                    'layout_id' => $layout_id,
                    'route' => $route['route'],
                ];
                
                $layout_route_insert_builder->insert($layout_route_insert_data);
            }
        }

        return $layout_id;
    }

    public function editLayout($location, $layout_id, $data = [])
    {
        $layout_update_builder = $this->db->table('layout');

        $update_data = [
            'name' => $data['name'],
        ];

        $layout_update_builder->where('layout_id', $layout_id);
        $layout_update_builder->where('location', $location);
        $layout_update_builder->update($update_data);

        // Routes
        $layout_route_delete_builder = $this->db->table('layout_route');

        $layout_route_delete_builder->where('layout_id', $layout_id);
        $layout_route_delete_builder->delete();

        if (!empty($data['route'])) {
            foreach ($data['route'] as $route) {
                $layout_route_insert_builder = $this->db->table('layout_route');

                $layout_route_insert_data = [
                    'layout_id' => $layout_id,
                    'route' => $route['route'],
                ];
                
                $layout_route_insert_builder->insert($layout_route_insert_data);
            }
        }

        return $layout_id;
    }

    public function deleteLayout($layout_id)
    {
        $layout_delete_builder = $this->db->table('layout');

        $layout_delete_builder->where('layout_id', $layout_id);
        $layout_delete_builder->delete();

        $layout_route_delete_builder = $this->db->table('layout_route');

        $layout_route_delete_builder->where('layout_id', $layout_id);
        $layout_route_delete_builder->delete();
    }

    public function getLayouts($data = [])
    {
        $layout_builder = $this->db->table('layout');
        $layout_builder->orderBy('name', 'ASC');

        $layout_query = $layout_builder->get();

        $layouts = [];

        foreach ($layout_query->getResult() as $result) {
            $layouts[] = [
                'layout_id' => $result->layout_id,
                'location' => $result->location,
                'name' => $result->name,
            ];
        }

        return $layouts;
    }

    public function getLayout($layout_id)
    {
        $layout_builder = $this->db->table('layout');
        
        $layout_builder->where('layout_id', $layout_id);

        $layout_query = $layout_builder->get();

        $layout = [];

        if ($row = $layout_query->getRow()) {
            $layout = [
                'layout_id' => $row->layout_id,
                'location' => $row->location,
                'name' => $row->name,
            ];
        }

        return $layout;
    }

    public function getLayoutRoutes($layout_id)
    {
        $layout_route_builder = $this->db->table('layout_route');

        $layout_route_builder->where('layout_id', $layout_id);
        $layout_route_builder->orderBy('route', 'ASC');

        $layout_route_query = $layout_route_builder->get();

        $layout_routes = [];

        foreach ($layout_route_query->getResult() as $result) {
            $layout_routes[] = [
                'layout_route_id' => $result->layout_route_id,
                'layout_id' => $result->layout_id,
                'route' => $result->route,
            ];
        }

        return $layout_routes;
    }
}