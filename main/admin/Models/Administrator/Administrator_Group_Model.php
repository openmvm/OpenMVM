<?php

namespace Main\Admin\Models\Administrator;

use CodeIgniter\Model;

class Administrator_Group_Model extends Model
{
    protected $table = 'administrator_group';
    protected $primaryKey = 'administrator_group_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function addAdministratorGroup($data = [])
    {
        $builder = $this->db->table('administrator_group');

        $insert_data = [
            'name' => $data['name'],
            'permission' => isset($data['permission']) ? json_encode($data['permission']) : '',
        ];
        
        $builder->insert($insert_data);

        return $this->db->insertID();
    }

    public function editAdministratorGroup($administrator_group_id, $data = [])
    {
        $builder = $this->db->table('administrator_group');

        $update_data = [
            'name' => $data['name'],
            'permission' => isset($data['permission']) ? json_encode($data['permission']) : '',
        ];

        $builder->where('administrator_group_id', $administrator_group_id);
        $builder->update($update_data);

        return $administrator_group_id;
    }

    public function deleteAdministratorGroup($administrator_group_id)
    {
        $builder = $this->db->table('administrator_group');

        $builder->where('administrator_group_id', $administrator_group_id);
        $builder->delete();
    }

    public function getAdministratorGroups($data = [])
    {
        $builder = $this->db->table('administrator_group');

        $administrator_group_query = $builder->get();

        $administrator_groups = [];

        foreach ($administrator_group_query->getResult() as $result) {
            $administrator_groups[] = [
                'administrator_group_id' => $result->administrator_group_id,
                'name' => $result->name,
                'permission' => json_decode($result->permission, true),
            ];
        }

        return $administrator_groups;
    }

    public function getAdministratorGroup($administrator_group_id)
    {
        $builder = $this->db->table('administrator_group');
        
        $builder->where('administrator_group_id', $administrator_group_id);

        $administrator_group_query = $builder->get();

        $administrator_group = [];

        if ($row = $administrator_group_query->getRow()) {
            $administrator_group = [
                'administrator_group_id' => $row->administrator_group_id,
                'name' => $row->name,
                'permission' => json_decode($row->permission, true),
            ];
        }

        return $administrator_group;
    }
}