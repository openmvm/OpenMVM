<?php

namespace Main\Marketplace\Models\Component\Order_Total;

use CodeIgniter\Model;

class Shipping_Model extends Model
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->session = \Config\Services::session();
        $this->setting = new \App\Libraries\Setting();
    }

    public function getTotal($order_total, $seller_id)
    {
        if ($this->session->has('checkout_shipping_method_' . $seller_id)) {
            $checkout_shipping_method = $this->session->get('checkout_shipping_method_' . $seller_id);
            
            $cost = $checkout_shipping_method['cost'];

            $order_total['totals'][] = array(
                'code'       => 'shipping',
                'title'      => $checkout_shipping_method['text'],
                'value'      => $cost,
                'sort_order' => $this->setting->get('component_order_total_shipping_sort_order')
            );

            $order_total['total'] += $cost;
        }
    }

}