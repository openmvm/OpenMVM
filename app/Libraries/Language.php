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

class Language {
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
    }

    /**
     * Get current code.
     *
     */
    public function getCurrentCode($admin = false)
    {
        if ($admin) {
            if ($this->session->has('admin_language_id')) {
                $code = $this->getCode($this->session->get('admin_language_id'));
            } elseif (!empty($this->setting->get('setting_admin_language_id'))) {
                $code = $this->getCode($this->setting->get('setting_admin_language_id'));
            } else {
                $code = 'en';
            }
        } else {
            if ($this->session->has('marketplace_language_id')) {
                $code = $this->getCode($this->session->get('marketplace_language_id'));
            } elseif (!empty($this->setting->get('setting_marketplace_language_id'))) {
                $code = $this->getCode($this->setting->get('setting_marketplace_language_id'));
            } else {
                $code = 'en';
            }
        }

        return $code;
    }

    /**
     * Get current id.
     *
     */
    public function getCurrentId($admin = false)
    {
        if ($admin) {
            if ($this->session->has('admin_language_id')) {
                $language_id = $this->session->get('admin_language_id');
            } elseif (!empty($this->setting->get('setting_admin_language_id'))) {
                $language_id = $this->setting->get('setting_admin_language_id');
            } else {
                $language_id = 1;
            }
        } else {
            if ($this->session->has('marketplace_language_id')) {
                $language_id = $this->session->get('marketplace_language_id');
            } elseif (!empty($this->setting->get('setting_marketplace_language_id'))) {
                $language_id = $this->setting->get('setting_marketplace_language_id');
            } else {
                $language_id = 1;
            }
        }

        return $language_id;
    }

    /**
     * Get default code.
     *
     */
    public function getDefaultCode($admin = false)
    {
        if ($admin) {
            $code = $this->getCode($this->setting->get('setting_admin_language_id'));
        } elseif (!empty($this->setting->get('setting_marketplace_language_id'))) {
            $code = $this->getCode($this->setting->get('setting_marketplace_language_id'));
        } else {
            $code = 'en';
        }

        return $code;
    }

    /**
     * Get default id.
     *
     */
    public function getDefaultId($admin = false)
    {
        if ($admin) {
            $language_id = $this->setting->get('setting_admin_language_id');
        } elseif (!empty($this->setting->get('setting_marketplace_language_id'))) {
            $language_id = $this->setting->get('setting_marketplace_language_id');
        } else {
            $language_id = 1;
        }

        return $language_id;
    }

    /**
     * Get code.
     *
     */
    public function getCode($language_id)
    {
        $builder = $this->db->table('language');
        
        $builder->where('language_id', $language_id);

        $language_query = $builder->get();

        $code = false;

        if ($row = $language_query->getRow()) {
            $code = $row->code;
        }

        return $code;
    }

    /**
     * Get id.
     *
     */
    public function getId($code)
    {
        $builder = $this->db->table('language');
        
        $builder->where('code', $code);

        $language_query = $builder->get();

        $language_id = false;

        if ($row = $language_query->getRow()) {
            $language_id = $row->language_id;
        }

        return $language_id;
    }

    /**
     * Get info.
     *
     */
    public function getInfo($code)
    {
        $builder = $this->db->table('language');
        
        $builder->where('code', $code);

        $language_query = $builder->get();

        $language = [];

        if ($row = $language_query->getRow()) {
            $language = [
                'language_id' => $row->language_id,
                'name' => $row->name,
                'code' => $row->code,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $language;
    }
}