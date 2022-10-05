<?php

namespace Main\Admin\Models\Administrator;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Administrator_Model extends Model
{
    protected $table = 'administrator';
    protected $primaryKey = 'administrator_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['firstname', 'lastname'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function addAdministrator($data = [])
    {
        $builder = $this->db->table('administrator');

        $insert_data = [
            'administrator_group_id' => $data['administrator_group_id'],
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'date_added' => new Time('now'),
            'date_modified' => new Time('now'),
            'status' => $data['status'],
        ];
        
        $builder->insert($insert_data);

        if (!empty($data['avatar'])) {
            $administrator_update_builder = $this->db->table('administrator');

            $administrator_update_data = [
                'avatar' => $data['avatar'],
            ];

            $administrator_update_builder->where('administrator_id', $administrator_id);
            $administrator_update_builder->update($administrator_update_data);
        }

        return $this->db->insertID();
    }

    public function editAdministrator($administrator_id, $data = [])
    {
        $builder = $this->db->table('administrator');

        $update_data = [
            'administrator_group_id' => $data['administrator_group_id'],
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'date_modified' => new Time('now'),
            'status' => $data['status'],
        ];

        if (!empty($data['password'])) {
            $update_data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $builder->where('administrator_id', $administrator_id);
        $builder->update($update_data);

        if (!empty($data['avatar'])) {
            $administrator_update_builder = $this->db->table('administrator');

            $administrator_update_data = [
                'avatar' => $data['avatar'],
            ];

            $administrator_update_builder->where('administrator_id', $administrator_id);
            $administrator_update_builder->update($administrator_update_data);
        }

        return $administrator_id;
    }

    public function deleteAdministrator($administrator_id)
    {
        $builder = $this->db->table('administrator');

        $builder->where('administrator_id', $administrator_id);
        $builder->delete();
    }

    public function getAdministrators($data = [])
    {
        $builder = $this->db->table('administrator');

        $administrator_query = $builder->get();

        $administrators = [];

        foreach ($administrator_query->getResult() as $result) {
            $administrators[] = [
                'administrator_id' => $result->administrator_id,
                'administrator_group_id' => $result->administrator_group_id,
                'username' => $result->username,
                'firstname' => $result->firstname,
                'lastname' => $result->lastname,
                'email' => $result->email,
                'avatar' => $result->avatar,
                'date_added' => $result->date_added,
                'date_modified' => $result->date_modified,
                'status' => $result->status,
            ];
        }

        return $administrators;
    }

    public function getAdministrator($administrator_id)
    {
        $builder = $this->db->table('administrator');
        
        $builder->where('administrator_id', $administrator_id);

        $administrator_query = $builder->get();

        $administrator = [];

        if ($row = $administrator_query->getRow()) {
            $administrator = [
                'administrator_id' => $row->administrator_id,
                'administrator_group_id' => $row->administrator_group_id,
                'username' => $row->username,
                'firstname' => $row->firstname,
                'lastname' => $row->lastname,
                'email' => $row->email,
                'avatar' => $row->avatar,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified,
               'status' => $row->status,
            ];
        }

        return $administrator;
    }
}