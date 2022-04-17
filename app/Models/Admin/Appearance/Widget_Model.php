<?php

namespace App\Models\Admin\Appearance;

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

    public function install($location, $author, $widget)
    {
        $widget_install_builder = $this->db->table('widget_install');

        $widget_install_data = [
            'location' => $location,
            'author' => $author,
            'widget' => $widget,
        ];
        
        $widget_install_builder->insert($widget_install_data);

        return $this->db->insertID();
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

    public function uninstall($location, $author, $widget)
    {
        $widget_uninstall_builder = $this->db->table('widget_install');

        $widget_uninstall_builder->where('location', $location);
        $widget_uninstall_builder->where('author', $author);
        $widget_uninstall_builder->where('widget', $widget);
        $widget_uninstall_builder->delete();
    }

    public function addWidget($location, $author, $widget, $data = [], $dir = '')
    {
        $widget_insert_builder = $this->db->table('widget');

        $widget_insert_data = [
            'location' => $location,
            'author' => $author,
            'dir' => $dir,
            'widget' => $widget,
            'name' => lang('Text.unnamed_widget', [], $this->language->getCurrentCode(true)),
            'setting' => json_encode([]),
            'status' => 0,
        ];
        
        $widget_insert_builder->insert($widget_insert_data);

        return $this->db->insertID();
    }

    public function editWidget($location, $author, $widget, $widget_id, $data = [], $dir = '')
    {
        $widget_update_builder = $this->db->table('widget');

        $widget_update_data = [
            'dir' => $dir,
            'name' => $data['name'],
            'setting' => json_encode($data),
            'status' => $data['status'],
        ];

        $widget_update_builder->where('widget_id', $widget_id);
        $widget_update_builder->where('location', $location);
        $widget_update_builder->where('author', $author);
        $widget_update_builder->where('widget', $widget);

        $widget_update_builder->update($widget_update_data);

        return $widget_id;
    }

    public function deleteWidget($location, $author, $widget, $widget_id)
    {
        $widget_delete_builder = $this->db->table('widget');

        $widget_delete_builder->where('widget_id', $widget_id);
        $widget_delete_builder->where('location', $location);
        $widget_delete_builder->where('author', $author);
        $widget_delete_builder->where('widget', $widget);
        $widget_delete_builder->delete();
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
                'widget' => $row->widget,
                'name' => $row->name,
                'setting' => json_decode($row->setting, true),
                'status' => $row->status,
            ];
        }

        return $widget;
    }
}