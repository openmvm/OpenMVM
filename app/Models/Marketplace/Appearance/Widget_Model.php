<?php

namespace App\Models\Marketplace\Appearance;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Widget_Model extends Model
{
    protected $table = 'widget';
    protected $primaryKey = 'widget_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['location', 'dir'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->language = new \App\Libraries\Language();
    }

    public function isInstalled($location, $author, $widget)
    {
        $widget_install_builder = $this->db->table('widget_install');
        
        $widget_install_builder->where('location', $location);
        $widget_install_builder->where('author', $author);
        $widget_install_builder->where('widget', $widget);

        $widget_install_query = $widget_install_builder->get();

        $widget_install = [];

        if ($row = $widget_install_query->getRow()) {
            return true;
        } else {
            return false;
        }
    }

    public function getWidgets($location, $author, $widget, $data = [], $status = null)
    {
        $widget_builder = $this->db->table('widget');

        $widget_builder->where('location', $location);
        $widget_builder->where('author', $author);
        $widget_builder->where('widget', $widget);

        if (isset($status)) {
            $widget_builder->where('status', $status);
        }

        $widget_query = $widget_builder->get();

        $widgets = [];

        foreach ($widget_query->getResult() as $result) {
            $widgets[] = [
                'widget_id' => $result->widget_id,
                'location' => $result->location,
                'author' => $result->author,
                'dir' => $result->dir,
                'widget' => $result->widget,
                'name' => $result->name,
                'setting' => json_decode($result->setting, true),
                'status' => $result->status,
            ];
        }

        return $widgets;
    }

    public function getWidget($widget_id)
    {
        $widget_builder = $this->db->table('widget');
        
        $widget_builder->where('widget_id', $widget_id);

        $widget_query = $widget_builder->get();

        $widget = [];

        if ($row = $widget_query->getRow()) {
            $widget = [
                'widget_id' => $row->widget_id,
                'location' => $row->location,
                'author' => $row->author,
                'dir' => $row->dir,
                'widget' => $row->widget,
                'name' => $row->name,
                'setting' => json_decode($row->setting, true),
                'status' => $row->status,
            ];
        }

        return $widget;
    }
}