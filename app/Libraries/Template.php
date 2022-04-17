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

class Template {
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Render the view.
     *
     */
    public function render($type, $author, $theme, $view, $data = array(), $override = false)
    {
        if ($override) {
            return view($type . '\\' . $author . '\\' . $theme . '\\Views\\' . $view, $data);
        } else {
            $default_author = 'com_openmvm';
            $default_theme = 'Basic';

            if ($type == 'ThemeAdmin') {
                $builder = $this->db->table('setting');
        
                $builder->where('key', 'setting_admin_theme');
        
                $setting_query = $builder->get();
        
                if ($row = $setting_query->getRow()) {
                    $theme = explode(':', $row->value);

                    $selected_author = $theme[0];
                    $selected_theme = $theme[1];
                } else {
                    $selected_author = $default_author;
                    $selected_theme = $default_theme;
                }

                $directory = 'theme_admin';
            } elseif ($type == 'ThemeAdminAdminSetting') {
                $selected_author = $author;
                $selected_theme = $theme;

                $type = 'ThemeAdmin';
                $directory = 'theme_admin';
            } elseif ($type == 'ThemeMarketplaceAdminSetting') {
                $selected_author = $author;
                $selected_theme = $theme;

                $type = 'ThemeMarketplace';
                $directory = 'theme_marketplace';
            } elseif ($type == 'Plugins') {
                $selected_author = $author;
                $selected_theme = $theme;

                $type = 'Plugins';
                $directory = 'plugins';
            } else {
                $builder = $this->db->table('setting');
        
                $builder->where('key', 'setting_marketplace_theme');
        
                $setting_query = $builder->get();
        
                if ($row = $setting_query->getRow()) {
                    $theme = explode(':', $row->value);

                    $selected_author = $theme[0];
                    $selected_theme = $theme[1];
                } else {
                    $selected_author = $default_author;
                    $selected_theme = $default_theme;
                }

                $directory = 'theme_marketplace';
            }

            if (is_file(ROOTPATH . $directory . '\\' . $selected_author . '\\' . $selected_theme . '\\Views\\' . $view . '.php')) {
                return view($type . '\\' . $selected_author . '\\' . $selected_theme . '\\Views\\' . $view, $data);
            } else {
                return view($type . '\\' . $default_author . '\\' . $default_theme . '\\Views\\' . $view, $data);
            }
        }

    }

}