<?php

/**
 * This file is part of OpenMVM.
 *
 * (c) OpenMVM <admin@openmvm.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace App\Libraries;

class Setting {
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Get setting value.
     *
     */
    public function get($key)
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