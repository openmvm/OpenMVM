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

class Calendar {
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
    }

    /**
     * Get months.
     *
     */
	public function getMonths() {
		$months = [
            [
                'value' => 1,
                'text' => lang('Text.january', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 2,
                'text' => lang('Text.february', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 3,
                'text' => lang('Text.march', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 4,
                'text' => lang('Text.april', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 5,
                'text' => lang('Text.may', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 6,
                'text' => lang('Text.june', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 7,
                'text' => lang('Text.july', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 8,
                'text' => lang('Text.august', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 9,
                'text' => lang('Text.september', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 10,
                'text' => lang('Text.october', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 11,
                'text' => lang('Text.november', [], $this->language->getCurrentCode()),
            ],
            [
                'value' => 12,
                'text' => lang('Text.december', [], $this->language->getCurrentCode()),
            ],
        ];

        return $months;
	}
}