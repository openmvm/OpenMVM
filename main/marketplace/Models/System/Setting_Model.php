<?php

namespace Main\Marketplace\Models\System;

use CodeIgniter\Model;

class Setting_Model extends Model
{
    protected $table = 'setting';
    protected $primaryKey = 'setting_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['code', 'key', 'value', 'serialized'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function editSetting($code, $data)
    {
        $builder = $this->db->table('setting');

        $builder->where('code', $code);
        $builder->delete();

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
                $serialized = 1;
            } else {
                $value = $value;
                $serialized = 0;
            }

            $insert_data = [
                'code' => $code,
                'key' => $key,
                'value' => $value,
                'serialized' => $serialized,
            ];

            $builder->insert($insert_data);
        }
    }

    public function editSettingValue($code, $key, $value)
    {
        $builder = $this->db->table('setting');

        if (is_array($value)) {
            $value = json_encode($value);
            $serialized = 1;
        } else {
            $value = $value;
            $serialized = 0;
        }

        $update_data = [
            'value' => $value,
            'serialized' => $serialized,
        ];

        $builder->where('code', $code);
        $builder->where('key', $key);
        $builder->update($update_data);

        return $key;
    }

    public function getSettingValue($key)
    {
        $builder = $this->db->table('setting');
        
        $builder->where('key', $key);

        $setting_query = $builder->get();

        if ($row = $setting_query->getRow()) {
            if ($row->serialized) {
                $value = json_decode($row->value, true);
            } else {
                $value = $row->value;
            }

            return $value;
        } else {
            return null;
        }

    }
}