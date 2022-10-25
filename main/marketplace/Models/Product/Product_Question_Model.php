<?php

namespace Main\Marketplace\Models\Product;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Product_Question_Model extends Model
{
    protected $table = 'product_question';
    protected $primaryKey = 'product_question_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['product_question_id', 'product_id', 'customer_id', 'question', 'date_added', 'status'];
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
        $this->template = new \App\Libraries\Template();
    }

    public function addProductQuestion($customer_id, $data = [])
    {
        $product_question_insert_builder = $this->db->table('product_question');

        $product_question_insert_data = [
            'product_id' => $data['product_id'],
            'customer_id' => $customer_id,
            'question' => $data['question'],
            'date_added' => new Time('now'),
            'status' => 1,
        ];
        
        $product_question_insert_builder->insert($product_question_insert_data);

        $product_question_id = $this->db->insertID();

        return $product_question_id;
    }

    public function getProductQuestions($product_id)
    {
        $product_question_builder = $this->db->table('product_question');
        
        $product_question_builder->where('product_id', $product_id);
        $product_question_builder->where('status', 1);

        $product_question_query = $product_question_builder->get();

        $product_questions = [];

        foreach ($product_question_query->getResult() as $result) {
            $product_questions[] = [
                'product_question_id' => $result->product_question_id,
                'product_id' => $result->product_id,
                'customer_id' => $result->customer_id,
                'question' => $result->question,
                'date_added' => $result->date_added,
                'status' => $result->status,
            ];
        }

        return $product_questions;
    }

    public function getProductQuestion($product_question_id)
    {
        $product_question_builder = $this->db->table('product_question');
        
        $product_question_builder->where('product_question_id', $product_question_id);
        $product_question_builder->where('status', 1);

        $product_question_query = $product_question_builder->get();

        $product_question = [];

        if ($row = $product_question_query->getRow()) {
            $product_question = [
                'product_question_id' => $row->product_question_id,
                'product_id' => $row->product_id,
                'customer_id' => $row->customer_id,
                'question' => $row->question,
                'date_added' => $row->date_added,
                'status' => $row->status,
            ];
        }

        return $product_question;
    }

    public function getProductQuestionAnswers($product_question_id)
    {
        $product_question_answer_builder = $this->db->table('product_question_answer');
        
        $product_question_answer_builder->where('product_question_id', $product_question_id);
        $product_question_answer_builder->where('status', 1);

        $product_question_answer_query = $product_question_answer_builder->get();

        $product_question_answers = [];

        foreach ($product_question_answer_query->getResult() as $result) {
            $product_question_answers[] = [
                'product_question_answer_id' => $result->product_question_answer_id,
                'product_question_id' => $result->product_question_id,
                'product_id' => $result->product_id,
                'customer_id' => $result->customer_id,
                'answer' => $result->answer,
                'date_added' => $result->date_added,
                'status' => $result->status,
            ];
        }

        return $product_question_answers;
    }
}