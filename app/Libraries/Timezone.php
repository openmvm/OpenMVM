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

class Timezone {
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Helpers
        helper(['date']);
    }

    /**
     * Get timezone list.
     *
     */
    public function getList($timezoneGroup = 'ALL', $countryCode = null)
    {
        if ($timezoneGroup == 'AFRICA') {
            $timezoneGroup = \DateTimeZone::AFRICA;
        }

        if ($timezoneGroup == 'AMERICA') {
            $timezoneGroup = \DateTimeZone::AMERICA;
        }
        
        if ($timezoneGroup == 'ANTARCTICA') {
            $timezoneGroup = \DateTimeZone::ANTARCTICA;
        }
        
        if ($timezoneGroup == 'ARCTIC') {
            $timezoneGroup = \DateTimeZone::ARCTIC;
        }
        
        if ($timezoneGroup == 'ASIA') {
            $timezoneGroup = \DateTimeZone::ASIA;
        }
        
        if ($timezoneGroup == 'ATLANTIC') {
            $timezoneGroup = \DateTimeZone::ATLANTIC;
        }
        
        if ($timezoneGroup == 'AUSTRALIA') {
            $timezoneGroup = \DateTimeZone::AUSTRALIA;
        }
        
        if ($timezoneGroup == 'EUROPE') {
            $timezoneGroup = \DateTimeZone::EUROPE;
        }
        
        if ($timezoneGroup == 'INDIAN') {
            $timezoneGroup = \DateTimeZone::INDIAN;
        }
        
        if ($timezoneGroup == 'PACIFIC') {
            $timezoneGroup = \DateTimeZone::PACIFIC;
        }
        
        if ($timezoneGroup == 'UTC') {
            $timezoneGroup = \DateTimeZone::UTC;
        }
        
        if ($timezoneGroup == 'ALL') {
            $timezoneGroup = \DateTimeZone::ALL;
        }
        
        if ($timezoneGroup == 'ALL_WITH_BC') {
            $timezoneGroup = \DateTimeZone::ALL_WITH_BC;
        }
        
        if ($timezoneGroup == 'PER_COUNTRY') {
            $timezoneGroup = \DateTimeZone::PER_COUNTRY;
        }
        
        $timezone_data = [];

        $tz_stamp = now();

        $timezones = timezone_identifiers_list($timezoneGroup, $countryCode);

        foreach ($timezones as $timezone) {
            $timezone_data[] = [
                'timezone' => $timezone,
                'offset' => (new \DateTime('now', new \DateTimeZone($timezone)))->format('P'),
            ];
        }

        return $timezone_data;
    }
}