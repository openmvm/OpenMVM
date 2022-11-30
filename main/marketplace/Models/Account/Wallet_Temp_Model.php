<?php

namespace Main\Marketplace\Models\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Wallet_Temp_Model extends Model
{
    protected $table = 'wallet_temp';
    protected $primaryKey = 'wallet_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['customer_id', 'amount', 'description', 'comment', 'date_added'];
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

    public function addWalletTemp($customer_id, $data = [])
    {
        $wallet_temp_insert_builder = $this->db->table('wallet_temp');

        $wallet_temp_insert_data = [
            'order_id' => $data['order_id'],
            'seller_id' => $data['seller_id'],
            'customer_id' => $customer_id,
            'amount' => $data['amount'],
            'description' => json_encode($data['description']),
            'comment' => json_encode($data['comment']),
            'date_added' => new Time('now'),
        ];
        
        $wallet_temp_insert_builder->insert($wallet_temp_insert_data);

        $wallet_temp_id = $this->db->insertID();

        return $wallet_temp_id;
    }

    public function getWalletTemps($customer_id)
    {
        $wallet_temp_builder = $this->db->table('wallet_temp');

        $wallet_temp_builder->where('customer_id', $customer_id);
        $wallet_temp_builder->orderBy('date_added', 'DESC');

        $wallet_temp_query = $wallet_temp_builder->get();

        $wallet_temps = [];

        foreach ($wallet_temp_query->getResult() as $result) {
            $wallet_temps[] = [
                'wallet_temp_id' => $result->wallet_temp_id,
                'order_id' => $result->order_id,
                'seller_id' => $result->seller_id,
                'customer_id' => $result->customer_id,
                'amount' => $result->amount,
                'description' => json_decode($result->description, true),
                'comment' => json_decode($result->comment, true),
                'date_added' => $result->date_added,
            ];
        }

        return $wallet_temps;
    }

    public function getWalletTemp($customer_id, $wallet_temp_id)
    {
        $wallet_temp_builder = $this->db->table('wallet_temp');
        
        $wallet_temp_builder->where('customer_id', $customer_id);
        $wallet_temp_builder->where('wallet_temp_id', $wallet_temp_id);

        $wallet_temp_query = $wallet_temp_builder->get();

        $wallet_temp = [];

        if ($row = $wallet_temp_query->getRow()) {
            $wallet_temp = [
                'wallet_temp_id' => $row->wallet_temp_id,
                'order_id' => $row->order_id,
                'seller_id' => $row->seller_id,
                'customer_id' => $row->customer_id,
                'amount' => $row->amount,
                'description' => json_decode($row->description, true),
                'comment' => json_decode($row->comment, true),
                'date_added' => $row->date_added,
            ];
        }

        return $wallet_temp;
    }

    public function getTotalAmount($customer_id)
    {
        $wallet_temp_builder = $this->db->table('wallet_temp');

        $wallet_temp_builder->select('SUM(amount) AS total');

        $wallet_temp_builder->where('customer_id', $customer_id);
        $wallet_temp_builder->groupBy('customer_id');

        $wallet_temp_query = $wallet_temp_builder->get();

        if ($row = $wallet_temp_query->getRow()) {
            return $row->total;
        } else {
            return 0;
        }
    }
}