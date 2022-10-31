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
        $this->customer = new \App\Libraries\Customer();
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
        $product_question_builder = $this->db->table('product_question pq');
        $product_question_builder->join('product_question_vote pqv', 'pq.product_question_id = pqv.product_question_id', 'left');
        $product_question_builder->select('pq.product_question_id, pq.product_id, pq.customer_id, pq.question, pq.date_added, pq.status, SUM(pqv.vote) AS sum');
        
        $product_question_builder->where('product_id', $product_id);
        $product_question_builder->where('status', 1);

        $product_question_builder->orderBy('sum', 'DESC');

        $product_question_builder->groupBy('pq.product_question_id');

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
                'sum' => $result->sum,
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

    public function addProductQuestionAnswer($product_question_id, $data = [])
    {
        // Insert
        $product_question_answer_insert_builder = $this->db->table('product_question_answer');

        $product_question_answer_insert_data = [
            'product_question_id' => $product_question_id,
            'product_id' => $data['product_id'],
            'customer_id' => $this->customer->getId(),
            'seller_id' => $this->customer->getSellerId(),
            'answer' => $data['answer'],
            'date_added' => new Time('now'),
            'status' => 1,
        ];
        
        $product_question_answer_insert_builder->insert($product_question_answer_insert_data);

        $product_question_answer_id = $this->db->insertID();

        return $product_question_answer_id;
    }

    public function getProductQuestionAnswers($product_question_id, $data = [])
    {
        $product_question_answer_builder = $this->db->table('product_question_answer pqa');
        $product_question_answer_builder->join('product_question_answer_vote pqav', 'pqa.product_question_answer_id = pqav.product_question_answer_id', 'left');
        $product_question_answer_builder->select('pqa.product_question_answer_id, pqa.product_question_id, pqa.product_id, pqa.customer_id, pqa.seller_id, pqa.answer, pqa.date_added, pqa.status, COUNT(pqav.vote) AS total_vote, SUM(pqav.vote = 1) AS helpful_vote, SUM(pqav.vote = 1)/COUNT(pqav.vote) AS pct_vote');
        
        $product_question_answer_builder->where('product_question_id', $product_question_id);
        $product_question_answer_builder->where('status', 1);

        $product_question_answer_builder->orderBy('pct_vote', 'DESC');
        $product_question_answer_builder->orderBy('total_vote', 'DESC');

        $product_question_answer_builder->groupBy('pqa.product_question_answer_id');

        if (isset($data['sort'])) {
            $sort = $data['sort'];
        } else {
            $sort = 'date_added';
        }

        if (isset($data['order'])) {
            $order = $data['order'];
        } else {
            $order = 'DESC';
        }

        $product_question_answer_builder->orderBy($sort, $order);

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $product_question_answer_builder->limit($data['limit'], $data['start']);
        }

        $product_question_answer_query = $product_question_answer_builder->get();

        $product_question_answers = [];

        foreach ($product_question_answer_query->getResult() as $result) {
            $product_question_answers[] = [
                'product_question_answer_id' => $result->product_question_answer_id,
                'product_question_id' => $result->product_question_id,
                'product_id' => $result->product_id,
                'customer_id' => $result->customer_id,
                'seller_id' => $result->seller_id,
                'answer' => $result->answer,
                'date_added' => $result->date_added,
                'status' => $result->status,
            ];
        }

        return $product_question_answers;
    }

    public function getTotalProductQuestionAnswers($product_question_id, $data = [])
    {
        $product_question_answer_builder = $this->db->table('product_question_answer');
        $product_question_answer_builder->select('COUNT(product_question_answer_id) as total');
        
        $product_question_answer_builder->where('product_question_id', $product_question_id);
        $product_question_answer_builder->where('status', 1);

        if (isset($data['sort'])) {
            $sort = $data['sort'];
        } else {
            $sort = 'date_added';
        }

        if (isset($data['order'])) {
            $order = $data['order'];
        } else {
            $order = 'DESC';
        }

        $product_question_answer_builder->orderBy($sort, $order);

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $product_question_answer_builder->limit($data['limit'], $data['start']);
        }

        $product_question_answer_query = $product_question_answer_builder->get();

        if ($row = $product_question_answer_query->getRow()) {
            return $row->total;
        } else {
            return 0;
        }
    }

    public function editProductQuestionVote($product_question_id, $vote)
    {
        $product_question_vote_delete_builder = $this->db->table('product_question_vote');
        
        $product_question_vote_delete_builder->where('product_question_id', $product_question_id);
        $product_question_vote_delete_builder->where('customer_id', $this->customer->getId());

        $product_question_vote_delete_builder->delete();

        if ($vote > 0) {
            if (!empty($this->customer->getId())) {
                // Insert product question vote
                $product_question_vote_insert_builder = $this->db->table('product_question_vote');

                $product_question_vote_insert_data = [
                    'product_question_id' => $product_question_id,
                    'customer_id' => $this->customer->getId(),
                    'vote' => $vote,
                    'date_added' => now(),
                    'date_modified' => now(),
                ];
                
                $product_question_vote_insert_builder->insert($product_question_vote_insert_data);

                $product_question_vote_id = $this->db->insertID();
            }
        }
    }

    public function getSumProductQuestionVotes($product_question_id)
    {
        $product_question_vote_builder = $this->db->table('product_question_vote');
        $product_question_vote_builder->select('SUM(vote) AS sum');
        
        $product_question_vote_builder->where('product_question_id', $product_question_id);
        $product_question_vote_builder->where('customer_id > ', 0);

        $product_question_vote_query = $product_question_vote_builder->get();

        $row = $product_question_vote_query->getRow();

        if (!empty($row->sum)) {
            return $row->sum;
        } else {
            return 0;
        }
    }

    public function getTotalProductQuestionVotes($product_question_id)
    {
        $product_question_vote_builder = $this->db->table('product_question_vote');
        $product_question_vote_builder->select('COUNT(product_question_vote_id) as total');
        
        $product_question_vote_builder->where('product_question_id', $product_question_id);

        $product_question_vote_query = $product_question_vote_builder->get();

        if ($row = $product_question_vote_query->getRow()) {
            return $row->total;
        } else {
            return 0;
        }
    }

    public function editProductQuestionAnswerVote($product_question_answer_id, $vote)
    {
        $product_question_answer_vote_delete_builder = $this->db->table('product_question_answer_vote');
        
        $product_question_answer_vote_delete_builder->where('product_question_answer_id', $product_question_answer_id);
        $product_question_answer_vote_delete_builder->where('customer_id', $this->customer->getId());

        $product_question_answer_vote_delete_builder->delete();

        if (!empty($this->customer->getId())) {
            // Insert product question vote
            $product_question_answer_vote_insert_builder = $this->db->table('product_question_answer_vote');

            $product_question_answer_vote_insert_data = [
                'product_question_answer_id' => $product_question_answer_id,
                'customer_id' => $this->customer->getId(),
                'vote' => $vote,
                'date_added' => new Time('now'),
            ];
            
            $product_question_answer_vote_insert_builder->insert($product_question_answer_vote_insert_data);

            $product_question_answer_vote_id = $this->db->insertID();
        }
    }

    public function getTotalProductQuestionAnswerVotes($product_question_answer_id, $vote = null)
    {
        $product_question_answer_vote_builder = $this->db->table('product_question_answer_vote');
        $product_question_answer_vote_builder->select('COUNT(product_question_answer_vote_id) as total');
        
        $product_question_answer_vote_builder->where('product_question_answer_id', $product_question_answer_id);

        if ($vote !== null) {
            $product_question_answer_vote_builder->where('vote', $vote);
        }

        $product_question_answer_vote_query = $product_question_answer_vote_builder->get();

        if ($row = $product_question_answer_vote_query->getRow()) {
            return $row->total;
        } else {
            return 0;
        }
    }
}