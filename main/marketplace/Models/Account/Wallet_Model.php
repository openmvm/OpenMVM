<?php

namespace Main\Marketplace\Models\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Wallet_Model extends Model
{
    protected $table = 'wallet';
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

    public function addWallet($customer_id, $data = [])
    {
        $wallet_insert_builder = $this->db->table('wallet');

        $wallet_insert_data = [
            'customer_id' => $customer_id,
            'amount' => $data['amount'],
            'description' => json_encode($data['description']),
            'comment' => json_encode($data['comment']),
            'date_added' => new Time('now'),
        ];
        
        $wallet_insert_builder->insert($wallet_insert_data);

        $wallet_id = $this->db->insertID();

        return $wallet_id;
    }

    public function getWallets($customer_id)
    {
        $wallet_builder = $this->db->table('wallet');

        $wallet_builder->where('customer_id', $customer_id);
        $wallet_builder->orderBy('date_added', 'DESC');

        $wallet_query = $wallet_builder->get();

        $wallets = [];

        foreach ($wallet_query->getResult() as $result) {
            $wallets[] = [
                'wallet_id' => $result->wallet_id,
                'customer_id' => $result->customer_id,
                'amount' => $result->amount,
                'description' => json_decode($result->description, true),
                'comment' => json_decode($result->comment, true),
                'date_added' => $result->date_added,
            ];
        }

        return $wallets;
    }

    public function getWallet($customer_id, $wallet_id)
    {
        $wallet_builder = $this->db->table('wallet');
        
        $wallet_builder->where('customer_id', $customer_id);
        $wallet_builder->where('wallet_id', $wallet_id);

        $wallet_query = $wallet_builder->get();

        $wallet = [];

        if ($row = $wallet_query->getRow()) {
            $wallet = [
                'wallet_id' => $row->wallet_id,
                'customer_id' => $row->customer_id,
                'amount' => $row->amount,
                'description' => json_decode($row->description, true),
                'comment' => json_decode($row->comment, true),
                'date_added' => $row->date_added,
            ];
        }

        return $wallet;
    }

    public function getTotalAmount($customer_id)
    {
        $wallet_builder = $this->db->table('wallet');

        $wallet_builder->select('SUM(amount) AS total');

        $wallet_builder->where('customer_id', $customer_id);
        $wallet_builder->groupBy('customer_id');

        $wallet_query = $wallet_builder->get();

        if ($row = $wallet_query->getRow()) {
            return $row->total;
        } else {
            return 0;
        }
    }
}