<?php

namespace Main\Marketplace\Models\Seller;

use CodeIgniter\Model;

class Shipping_Method_Model extends Model
{
    protected $table = 'seller_shipping_method';
    protected $primaryKey = 'seller_shipping_method_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['seller_id', 'code', 'value', 'serialized', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
    }

    public function editShippingMethod($seller_id, $code, $data = [])
    {
        $seller_shipping_method_builder = $this->db->table('seller_shipping_method');

        $seller_shipping_method_builder->where('seller_id', $seller_id);
        $seller_shipping_method_builder->where('code', $code);
        $seller_shipping_method_builder->delete();

        if (is_array($data['rate'])) {
            $rate = json_encode($data['rate']);
            $serialized = 1;
        } else {
            $rate = $data['rate'];
            $serialized = 0;
        }

        $seller_shipping_method_insert_data = [
            'seller_id' => $seller_id,
            'code' => $code,
            'rate' => $rate,
            'serialized' => $serialized,
            'status' => $data['status'],
        ];

        $seller_shipping_method_builder->insert($seller_shipping_method_insert_data);
    }

    public function getShippingMethod($code, $seller_id)
    {
        $seller_shipping_method_builder = $this->db->table('seller_shipping_method');
        
        $seller_shipping_method_builder->where('code', $code);
        $seller_shipping_method_builder->where('seller_id', $seller_id);

        $seller_shipping_method_query = $seller_shipping_method_builder->get();

        $seller_shipping_method = [];

        if ($row = $seller_shipping_method_query->getRow()) {
            if ($row->serialized) {
                $rate = json_decode($row->rate, true);
            } else {
                $rate = $row->rate;
            }

            $seller_shipping_method = [
                'seller_id' => $row->seller_id,
                'code' => $row->code,
                'rate' => $rate,
                'serialized' => $row->serialized,
                'status' => $row->status,
            ];
        }

        return $seller_shipping_method;
    }
}