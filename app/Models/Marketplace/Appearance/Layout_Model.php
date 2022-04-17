<?php

namespace App\Models\Marketplace\Appearance;

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

    public function getLayoutRouteByRoute($route)
    {
        $layout_route_builder = $this->db->table('layout_route');
        
        $layout_route_builder->where('route', $route);

        $layout_route_query = $layout_route_builder->get();

        $layout_route = [];

        if ($row = $layout_route_query->getRow()) {
            $layout_route = [
                'layout_route_id' => $row->layout_route_id,
                'layout_id' => $row->layout_id,
                'route' => $row->route,
            ];
        }

        return $layout_route;
    }
}