<?php

namespace Main\Marketplace\Models\Account;

use CodeIgniter\Model;

class Product_Download_Model extends Model
{
    protected $table = 'product_download';
    protected $primaryKey = 'product_download_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['product_download_id', 'product_id', 'customer_id', 'seller_id', 'filename', 'mask', 'date_added'];
    protected $useTimestamps = false;
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

    public function getProductDownloads($customer_id)
    {
        $product_download_builder = $this->db->table('product_download pd');

        $product_download_builder->select('*, pdd.name AS name, op.name AS product_name, o.date_added AS date_added');

        $product_download_builder->join('product_download_description pdd', 'pd.product_download_id = pdd.product_download_id', 'left');
        $product_download_builder->join('product p', 'pd.product_id = p.product_id', 'left');
        $product_download_builder->join('order_product op', 'pd.product_id = op.product_id', 'left');
        $product_download_builder->join('order o', 'op.order_id = o.order_id', 'left');

        $product_download_builder->where('o.customer_id', $customer_id);
        $product_download_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));
        $product_download_builder->where('pdd.language_id', $this->language->getCurrentId());

        $product_download_builder->orderBy('o.date_added', 'DESC');
        $product_download_builder->orderBy('pdd.name', 'ASC');

        $product_download_query = $product_download_builder->get();

        $product_downloads = [];

        foreach ($product_download_query->getResult() as $result) {
            $product_downloads[] = [
                'product_download_id' => $result->product_download_id,
                'product_id' => $result->product_id,
                'customer_id' => $result->customer_id,
                'seller_id' => $result->seller_id,
                'name' => $result->name,
                'filename' => $result->filename,
                'mask' => $result->mask,
                'date_added' => $result->date_added,
                'order_id' => $result->order_id,
                'product_name' => $result->product_name,
            ];
        }

        return $product_downloads;
    }

    public function getProductDownload($product_download_id)
    {
        $product_download_builder = $this->db->table('product_download');
        
        $product_download_builder->where('product_download_id', $product_download_id);

        $product_download_query = $product_download_builder->get();

        $product_download = [];

        if ($row = $product_download_query->getRow()) {
            $product_download = [
                'product_download_id' => $row->product_download_id,
                'product_id' => $row->product_id,
                'customer_id' => $row->customer_id,
                'seller_id' => $row->seller_id,
                'filename' => $row->filename,
                'mask' => $row->mask,
                'date_added' => $row->date_added,
            ];
        }

        return $product_download;
    }
}