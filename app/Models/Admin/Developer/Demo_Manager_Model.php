<?php

namespace App\Models\Admin\Developer;

use CodeIgniter\Model;

class Demo_Manager_Model extends Model
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function import()
    {
        if (file_exists(ROOTPATH . 'openmvm_demo_data.sql')) {
            $templine = '';

            $database = file(ROOTPATH . 'openmvm_demo_data.sql');

            foreach ($database as $line) {
                if (substr($line, 0, 2) == '--' || substr($line,0,2) == "/*" || $line == '') {
                    continue;
                }

                $templine .= $line;

                if (substr(trim($line), -1, 1) == ';') {
                    $templine = str_replace("DROP TABLE IF EXISTS `omvm_", "DROP TABLE IF EXISTS `" . $this->db->getPrefix(), $templine);
                    $templine = str_replace("CREATE TABLE `omvm_", "CREATE TABLE `" . $this->db->getPrefix(), $templine);
                    $templine = str_replace("INSERT INTO `omvm_", "INSERT INTO `" . $this->db->getPrefix(), $templine);
                    $templine = str_replace("ALTER TABLE `omvm_", "ALTER TABLE `" . $this->db->getPrefix(), $templine);

                    $this->db->query($templine);
                    $templine = '';
                }
            }
            
            unlink(ROOTPATH . 'openmvm_demo_data.sql');
        }
    }
}