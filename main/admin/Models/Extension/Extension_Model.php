<?php

namespace Main\Admin\Models\Extension;

use CodeIgniter\Model;

class Extension_Model extends Model
{
    protected $table = 'extension';
    protected $primaryKey = 'extension_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['type', 'value'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function installExtension($type, $value)
    {
        $builder = $this->db->table('extension');

        $insert_data = [
            'type' => $type,
            'value' => $value,
        ];
        
        $builder->insert($insert_data);

        return $this->db->insertID();
    }

    public function uninstallExtension($type, $value)
    {
        $builder = $this->db->table('extension');

        $builder->where('type', $type);
        $builder->where('value', $value);
        $builder->delete();
    }

    public function getInstalledExtensions($data = [])
    {
        $builder = $this->db->table('extension');

        $extension_query = $builder->get();

        $extensions = [];

        foreach ($extension_query->getResult() as $result) {
            $extensions[] = [
                'extension_id' => $result->extension_id,
                'type' => $result->type,
                'value' => $result->value,
            ];
        }

        return $extensions;
    }

    public function getInstalledExtension($type, $value)
    {
        $builder = $this->db->table('extension');
        
        $builder->where('type', $type);
        $builder->where('value', $value);

        $extension_query = $builder->get();

        $extension = [];

        if ($row = $extension_query->getRow()) {
            $extension = [
                'extension_id' => $row->extension_id,
                'type' => $row->type,
                'value' => $row->value,
            ];
        }

        return $extension;
    }
}