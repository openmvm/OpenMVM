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

        // Libraries
        $this->administrator = new \App\Libraries\Administrator();
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
    }

    /**
     * Render the view.
     *
     */
    public function render($setting = [], $data = [])
    {
        if (!empty($setting['location'])) {
            $location = $setting['location'];
        } else {
            $location = 'ThemeMarketplace';
        }

        if (!empty($setting['author'])) {
            $author = $setting['author'];
        } else {
            $author = 'com_openmvm';
        }

        if (!empty($setting['theme'])) {
            $theme = $setting['theme'];
        } else {
            $theme = 'Basic';
        }

        if (!empty($setting['view'])) {
            $view = $setting['view'];
        } else {
            $view = '';
        }

        if (!empty($setting['permission'])) {
            $permission = $setting['permission'];
        } else {
            $permission = false;
        }

        if (!empty($setting['override'])) {
            $override = $setting['override'];
        } else {
            $override = false;
        }

        if (!empty($setting['widget'])) {
            $widget = $setting['widget'];
        } else {
            $widget = false;
        }

        if ($override) {
            return view($location . '\\' . $author . '\\' . $theme . '\\Views\\' . $view, $data);
        } else {
            $default_author = 'com_openmvm';
            $default_theme = 'Basic';

            if ($location == 'ThemeAdmin') {
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

                //$selected_author = 'com_example';
                //$selected_theme = 'Volt';

                $directory = 'theme_admin';

                $locale = $this->language->getCurrentCode(true);
            } elseif ($location == 'ThemeAdminAdminSetting') {
                $selected_author = $author;
                $selected_theme = $theme;

                $location = 'ThemeAdmin';
                $directory = 'theme_admin';
            } elseif ($location == 'ThemeMarketplaceAdminSetting') {
                $selected_author = $author;
                $selected_theme = $theme;

                $location = 'ThemeMarketplace';
                $directory = 'theme_marketplace';

                $locale = $this->language->getCurrentCode(true);
            } elseif ($location == 'Plugins') {
                $selected_author = $author;
                $selected_theme = $theme;

                $location = 'Plugins';
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

                $locale = $this->language->getCurrentCode();
            }

            // Cache
            if (!empty($_SERVER['QUERY_STRING'])) {
                $query_string = '?' . $_SERVER['QUERY_STRING'];
            } else {
                $query_string = '';
            }

            if ($this->setting->get('performance_cache_status')) {
                if ($widget) {
                    $cache = ['cache' => $this->setting->get('performance_cache_ttl'), 'cache_name' => $locale . '-' . md5($directory . '/' . $selected_author . '/' . $selected_theme . '/Views/' . $view . json_encode($data) . uri_string() . $query_string . $data['widget'])];
                } else {
                    $cache = ['cache' => $this->setting->get('performance_cache_ttl'), 'cache_name' => $locale . '-' . md5($directory . '/' . $selected_author . '/' . $selected_theme . '/Views/' . $view . json_encode($data) . uri_string() . $query_string)];
                }
            } else {
                $cache = [];
            }

            if (!empty($permission)) {
                if ($this->administrator->hasPermission('access', $permission)) {
                    if (is_file(ROOTPATH . $directory . '\\' . $selected_author . '\\' . $selected_theme . '\\Views\\' . $view . '.php')) {
                        return view($location . '\\' . $selected_author . '\\' . $selected_theme . '\\Views\\' . $view, $data, $cache);
                    } else {
                        return view($location . '\\' . $default_author . '\\' . $default_theme . '\\Views\\' . $view, $data, $cache);
                    }
                } else {
                    if (is_file(ROOTPATH . $directory . '\\' . $selected_author . '\\' . $selected_theme . '\\Views\\Common\\permission.php')) {
                        return view($location . '\\' . $selected_author . '\\' . $selected_theme . '\\Views\\Common\\permission', $data, $cache);
                    } else {
                        return view($location . '\\' . $default_author . '\\' . $default_theme . '\\Views\\Common\\permission', $data, $cache);
                    }
                }
            } else {
                if (is_file(ROOTPATH . $directory . '\\' . $selected_author . '\\' . $selected_theme . '\\Views\\' . $view . '.php')) {
                    return view($location . '\\' . $selected_author . '\\' . $selected_theme . '\\Views\\' . $view, $data, $cache);
                } else {
                    return view($location . '\\' . $default_author . '\\' . $default_theme . '\\Views\\' . $view, $data, $cache);
                }
            }
        }

    }

}