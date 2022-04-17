<?php

namespace App\Models\Marketplace\Component\Order_Total;

use CodeIgniter\Model;

class Sub_Total_Model extends Model
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->cart = new \App\Libraries\Cart();
        $this->setting = new \App\Libraries\Setting();
    }

    public function getTotal($order_total, $seller_id)
    {
        $sub_total = $this->cart->getSubTotal($seller_id);

        $order_total['totals'][] = array(
            'code'       => 'sub_total',
            'title'      => lang('Text.sub_total'),
            'value'      => $sub_total,
            'sort_order' => $this->setting->get('component_order_total_sub_total_sort_order')
        );

        $order_total['total'] += $sub_total;
    }

}