<?php

namespace Main\Marketplace\Models\Seller;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Seller_Faq_Model extends Model
{
    protected $table = 'seller_faq';
    protected $primaryKey = 'seller_faq_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['sort_order', 'status'];
    protected $useTimestamps = false;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // Libraries
        $this->customer = new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->setting = new \App\Libraries\Setting();
        $this->text = new \App\Libraries\Text();
    }

    public function addSellerFaq($data = [])
    {
        $builder = $this->db->table('seller_faq');

        $insert_data = [
            'seller_id' => $this->customer->getSellerId(),
            'customer_id' => $this->customer->getId(),
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];
        
        $builder->insert($insert_data);

        $seller_faq_id = $this->db->insertID();

        // Seller Faq Descriptions
        if ($data['seller_faq_description']) {
            foreach ($data['seller_faq_description'] as $language_id => $value) {
                $seller_faq_description_builder = $this->db->table('seller_faq_description');

                $seller_faq_description_insert_data = [
                    'seller_faq_id' => $seller_faq_id,
                    'seller_id' => $this->customer->getSellerId(),
                    'customer_id' => $this->customer->getId(),
                    'language_id' => $language_id,
                    'question' => $value['question'],
                    'answer' => $value['answer'],
                    'slug' => $this->text->slugify($value['question']),
                ];
                
                $seller_faq_description_builder->insert($seller_faq_description_insert_data);
            }
        }

        return $seller_faq_id;
    }

    public function editSellerFaq($seller_faq_id, $data = [])
    {
        $builder = $this->db->table('seller_faq');

        $update_data = [
            'sort_order' => $data['sort_order'],
            'status' => $data['status'],
        ];

        $builder->where('seller_faq_id', $seller_faq_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->update($update_data);
        
        // Delete seller faq descriptions
        $builder = $this->db->table('seller_faq_description');

        $builder->where('seller_faq_id', $seller_faq_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        // Seller Faq Descriptions
        if ($data['seller_faq_description']) {
            foreach ($data['seller_faq_description'] as $language_id => $value) {
                $seller_faq_description_builder = $this->db->table('seller_faq_description');

                $seller_faq_description_insert_data = [
                    'seller_faq_id' => $seller_faq_id,
                    'language_id' => $language_id,
                    'question' => $value['question'],
                    'answer' => $value['answer'],
                    'slug' => $this->text->slugify($value['question']),
                ];
                
                $seller_faq_description_builder->insert($seller_faq_description_insert_data);
            }
        }

        return $seller_faq_id;
    }

    public function deleteSellerFaq($seller_faq_id)
    {
        // Delete seller_faq
        $builder = $this->db->table('seller_faq');

        $builder->where('seller_faq_id', $seller_faq_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();

        // Delete seller faq descriptions
        $builder = $this->db->table('seller_faq_description');

        $builder->where('seller_faq_id', $seller_faq_id);
        $builder->where('seller_id', $this->customer->getSellerId());
        $builder->where('customer_id', $this->customer->getId());
        $builder->delete();
    }

    public function getSellerFaqs($data = [], $seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller_faq sf');

        $builder->join('seller_faq_description sfd', 'sf.seller_faq_id = sfd.seller_faq_id', 'left');

        $builder->where('sfd.language_id ', $this->setting->get('setting_marketplace_language_id'));
        $builder->where('sf.seller_id', $seller_id);
        if (!empty($customer_id)) {
            $builder->where('sf.customer_id', $customer_id);
        }

        $builder->groupBy('sf.seller_faq_id');

        $builder->orderBy('sf.sort_order', 'ASC');

        $seller_faq_query = $builder->get();

        $faqs = [];

        foreach ($seller_faq_query->getResult() as $result) {
            $faqs[] = [
                'seller_faq_id' => $result->seller_faq_id,
                'question' => $result->question,
                'answer' => $result->answer,
                'sort_order' => $result->sort_order,
                'status' => $result->status,
            ];
        }

        return $faqs;
    }

    public function getSellerFaq($seller_faq_id, $seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller_faq');
        
        $builder->where('seller_faq_id', $seller_faq_id);
        $builder->where('seller_id', $seller_id);
        if (!empty($customer_id)) {
            $builder->where('customer_id', $customer_id);
        }

        $seller_faq_query = $builder->get();

        $seller_faq = [];

        if ($row = $seller_faq_query->getRow()) {
            $seller_faq = [
                'seller_faq_id' => $row->seller_faq_id,
                'sort_order' => $row->sort_order,
                'status' => $row->status,
            ];
        }

        return $seller_faq;
    }

    public function getSellerFaqDescriptions($seller_faq_id, $seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller_faq_description');
        
        $builder->where('seller_faq_id', $seller_faq_id);
        $builder->where('seller_id', $seller_id);
        if (!empty($customer_id)) {
            $builder->where('customer_id', $customer_id);
        }

        $seller_faq_description_query = $builder->get();

        $seller_faq_descriptions = [];

        foreach ($seller_faq_description_query->getResult() as $result) {
            $seller_faq_descriptions[$result->language_id] = [
                'question' => $result->question,
                'answer' => $result->answer,
                'slug' => $result->slug,
            ];
        }

        return $seller_faq_descriptions;
    }

    public function getSellerFaqDescription($seller_faq_id, $seller_id, $customer_id = null)
    {
        $builder = $this->db->table('seller_faq_description');
        
        $builder->where('seller_faq_id', $seller_faq_id);
        $builder->where('seller_id', $seller_id);
        if (!empty($customer_id)) {
            $builder->where('customer_id', $customer_id);
        }
        $builder->where('language_id', $this->setting->get('setting_marketplace_language_id'));

        $seller_faq_description_query = $builder->get();

        $seller_faq_description = [];

        if ($row = $seller_faq_description_query->getRow()) {
            $seller_faq_description = [
                'answer' => $row->answer,
                'question' => $row->question,
                'slug' => $row->slug,
            ];
        }

        return $seller_faq_description;
    }
}