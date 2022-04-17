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

class Url {
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    /**
     * Generate administrator link.
     *
     */
    public function administratorLink($route, $query_strings = [])
    {
        $query_string = '';
        
        if ($this->session->has('administrator_session_token')) {
            $query_string = '?administrator_token=' . $this->session->get('administrator_session_token');

            foreach ($query_strings as $key => $value) {
                $query_string .= '&' . $key . '=' . $value;
            }
        } else {
            if (!empty($query_strings)) {
                $i = 1;

                foreach ($query_strings as $key => $value) {
                    if ($i == 1) {
                        $query_string .= '?' . $key . '=' . $value;
                    } else {
                        $query_string .= '&' . $key . '=' . $value;
                    }

                    $i++;
                }
            }   
        }

        return base_url($route . $query_string);
    }

    /**
     * Generate customer link.
     *
     */
    public function customerLink($route, $query_strings = [], $token = false)
    {
        $query_string = '';

        if ($token) {
            if ($this->session->has('customer_session_token')) {
                $query_string = '?customer_token=' . $this->session->get('customer_session_token');

                if (!empty($query_strings)) {
                    foreach ($query_strings as $key => $value) {
                        $query_string .= '&' . $key . '=' . $value;
                    }
                }
            } else {
                if (!empty($query_strings)) {
                    $i = 1;
    
                    foreach ($query_strings as $key => $value) {
                        if ($i == 1) {
                            $query_string .= '?' . $key . '=' . $value;
                        } else {
                            $query_string .= '&' . $key . '=' . $value;
                        }
    
                        $i++;
                    }
                }   
            }
        } else {
            if (!empty($query_strings)) {
                $i = 1;

                foreach ($query_strings as $key => $value) {
                    if ($i == 1) {
                        $query_string .= '?' . $key . '=' . $value;
                    } else {
                        $query_string .= '&' . $key . '=' . $value;
                    }

                    $i++;
                }
            }   
        }

        return base_url($route . $query_string);
    }
}