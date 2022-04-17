<?php

namespace App\Models\Marketplace\Component\Order_Total;

use CodeIgniter\Model;

class Total_Model extends Model
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
    }

    public function getTotal($order_total, $seller_id)
    {
        $order_total['totals'][] = array(
            'code'       => 'total',
            'title'      => lang('Text.total'),
            'value'      => max(0, $order_total['total']),
            'sort_order' => $this->setting->get('component_order_total_total_sort_order')
        );
    }

}