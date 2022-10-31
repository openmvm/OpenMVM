<?php

namespace Main\Marketplace\Controllers\Product;

class Customer_Question extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Model
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_product_product = new \Main\Marketplace\Models\Product\Product_Model();
        $this->model_product_product_question = new \Main\Marketplace\Models\Product\Product_Question_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
    }

    public function index()
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        // Get product info
        $product_info = $this->model_product_product->getProduct($this->uri->getSegment($this->uri->getTotalSegments()));

        if ($product_info) {
            if (strlen($product_info['name']) > 36) {
                $product_name = substr($product_info['name'], 0, 36) . '...';
            } else {
                $product_name = $product_info['name'];
            }

            $breadcrumbs[] = array(
                'text' => $product_name,
                'href' => $this->url->customerLink('marketplace/product/product/get/' . $product_info['slug']),
                'active' => false,
            );

            $breadcrumbs[] = array(
                'text' => lang('Text.customer_questions', [], $this->language->getCurrentCode()),
                'href' => $this->url->customerLink('marketplace/product/customer_question'),
                'active' => true,
            );

            $data['heading_title'] = lang('Heading.customer_questions_and_answers', [], $this->language->getCurrentCode());

            $data['product_name'] = $product_name;
            $data['product_url'] = $this->url->customerLink('marketplace/product/product/get/' . $product_info['slug']);

            // Product image
            if (is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
                $data['thumb'] = $this->image->resize($product_info['main_image'], 100, 100, true);
            } else {
                $data['thumb'] = $this->image->resize('no_image.png', 100, 100, true);
            }

            if (is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
                $data['image'] = $this->image->resize($product_info['main_image'], 512, 512, true);
            } else {
                $data['image'] = $this->image->resize('no_image.png', 512, 512, true);
            }

            // Seller info
            $seller_info = $this->model_seller_seller->getSeller($product_info['seller_id']);

            $data['store_name'] = $seller_info['store_name'];
            $data['store_url'] = $this->url->customerLink('marketplace/seller/seller/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id']);          

            // Get customer questions
            $data['customer_questions'] = [];

            $customer_questions = $this->model_product_product_question->getProductQuestions($product_info['product_id']);

            foreach ($customer_questions as $customer_question) {
                // Get customer info
                $question_customer_info = $this->model_customer_customer->getCustomer($customer_question['customer_id']);

                if ($question_customer_info) {
                    // Get total customer question answer
                    $customer_question_answer_total = $this->model_product_product_question->getTotalProductQuestionAnswers($customer_question['product_question_id']);

                    if ($customer_question_answer_total > 0) {
                        // Get customer question answers
                        $customer_question_answer_data = [];

                        $filter_data = [
                            'start' => 0,
                            'limit' => 1,
                        ];

                        $customer_question_answers = $this->model_product_product_question->getProductQuestionAnswers($customer_question['product_question_id'], $filter_data);

                        foreach ($customer_question_answers as $customer_question_answer) {
                            $seller_data = [];
                            
                            // Get customer info
                            $answer_customer_info = $this->model_customer_customer->getCustomer($customer_question_answer['customer_id']);

                            if ($answer_customer_info) {
                                // Get seller info
                                $seller_info = $this->model_seller_seller->getSeller($customer_question_answer['seller_id']);

                                if ($seller_info) {
                                    $seller_data = [
                                        'seller_id' => $seller_info['seller_id'],
                                        'store_name' => $seller_info['store_name'],
                                    ];
                                }

                                $customer_question_answer_data[] = [
                                    'product_question_answer_id' => $customer_question_answer['product_question_answer_id'],
                                    'product_question_id' => $customer_question_answer['product_question_id'],
                                    'product_id' => $customer_question_answer['product_id'],
                                    'customer_id' => $customer_question_answer['customer_id'],
                                    'customer' => $answer_customer_info,
                                    'seller_id' => $customer_question_answer['seller_id'],
                                    'seller' => $seller_data,
                                    'answer' => nl2br($customer_question_answer['answer']),
                                    'date_added' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($customer_question_answer['date_added'])),
                                    'status' => $customer_question_answer['status'],
                                ];
                            }
                        }

                        // Get sum customer question votes
                        $sum_customer_question_vote = $this->model_product_product_question->getSumProductQuestionVotes($customer_question['product_question_id']);

                        $data['customer_questions'][] = [
                            'product_question_id' => $customer_question['product_question_id'],
                            'product_id' => $customer_question['product_id'],
                            'customer_id' => $customer_question['customer_id'],
                            'question' => $customer_question['question'],
                            'sum_vote' => $sum_customer_question_vote,
                            'answer' => $customer_question_answer_data,
                            'total_answer' => $customer_question_answer_total,
                            'date_added' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($customer_question['date_added'])),
                            'status' => $customer_question['status'],
                            'href' => $this->url->customerLink('marketplace/product/customer_question/get/' . $customer_question['product_question_id']),
                        ];
                    }
                }
            }

            // Vote customer question
            $data['vote_customer_question'] = $this->url->customerLink('marketplace/product/product/vote_product_question', ['product_id' => $product_info['product_id']], true); 

            // Get customer question answers
            $data['get_customer_question_answers'] = $this->url->customerLink('marketplace/product/product/get_product_question_answers'); 

            // Header
            $header_params = array(
                'title' => lang('Heading.customer_questions', [], $this->language->getCurrentCode()),
                'breadcrumbs' => $breadcrumbs,
            );
            $data['header'] = $this->marketplace_header->index($header_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->marketplace_footer->index($footer_params);

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Product\customer_question_list',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        } else {
            $data['message'] = lang('Error.no_data_found', [], $this->language->getCurrentCode());
    
            // Libraries
            $data['language_lib'] = $this->language;

            // Header
            $header_params = array(
                'title' => lang('Heading.not_found', [], $this->language->getCurrentCode()),
            );
            $data['header'] = $this->marketplace_header->index($header_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->marketplace_footer->index($footer_params);
    
            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Common\error',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }

    public function get($product_question_id)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        // Get product question info
        $product_question_info = $this->model_product_product_question->getProductQuestion($product_question_id);

        if ($product_question_info) {
            $product_id = $product_question_info['product_id'];

            // Get product info
            $product_info = $this->model_product_product->getProduct($product_id);

            if (strlen($product_info['name']) > 36) {
                $product_name = substr($product_info['name'], 0, 36) . '...';
            } else {
                $product_name = $product_info['name'];
            }

            $breadcrumbs[] = array(
                'text' => $product_name,
                'href' => $this->url->customerLink('marketplace/product/product/get/' . $product_info['slug']),
                'active' => false,
            );

            $breadcrumbs[] = array(
                'text' => lang('Text.customer_questions', [], $this->language->getCurrentCode()),
                'href' => $this->url->customerLink('marketplace/product/customer_question/' . $product_info['product_id']),
                'active' => false,
            );

            if (strlen($product_question_info['question']) > 36) {
                $question = substr($product_question_info['question'], 0, 36) . '...';
            } else {
                $question = $product_question_info['question'];
            }

            $breadcrumbs[] = array(
                'text' => $question,
                'href' => $this->url->customerLink('marketplace/product/customer_question/get/' . $product_question_info['product_question_id']),
                'active' => true,
            );

            $data['heading_title'] = $product_question_info['question'];

            $data['date_added'] = date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($product_question_info['date_added']));

            $data['product_name'] = $product_info['name'];
            $data['product_id'] = $product_info['product_id'];
            $data['product_url'] = $this->url->customerLink('marketplace/product/product/get/' . $product_info['slug']);
            $data['seller_id'] = $product_info['seller_id'];

            // Images
            if (is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
                $data['thumb'] = $this->image->resize($product_info['main_image'], 100, 100, true);
            } else {
                $data['thumb'] = $this->image->resize('no_image.png', 100, 100, true);
            }

            if (is_file(ROOTPATH . 'public/assets/images/' . $product_info['main_image'])) {
                $data['image'] = $this->image->resize($product_info['main_image'], 512, 512, true);
            } else {
                $data['image'] = $this->image->resize('no_image.png', 512, 512, true);
            }

            // Seller info
            $seller_info = $this->model_seller_seller->getSeller($product_info['seller_id']);

            $data['store_name'] = $seller_info['store_name'];
            $data['store_url'] = $this->url->customerLink('marketplace/seller/seller/get/' . $seller_info['slug'] . '-s' . $seller_info['seller_id']);   

            // Get customer question answers
            $data['customer_question_answers'] = [];

            // Get total customer question answer
            $customer_question_answer_total = $this->model_product_product_question->getTotalProductQuestionAnswers($product_question_info['product_question_id']);

            $customer_question_answers = $this->model_product_product_question->getProductQuestionAnswers($product_question_info['product_question_id']);

            foreach ($customer_question_answers as $customer_question_answer) {
                $seller_data = [];
                
                // Get customer info
                $answer_customer_info = $this->model_customer_customer->getCustomer($customer_question_answer['customer_id']);

                if ($answer_customer_info) {
                    // Get seller info
                    $seller_info = $this->model_seller_seller->getSeller($customer_question_answer['seller_id']);

                    if ($seller_info) {
                        $seller_data = [
                            'seller_id' => $seller_info['seller_id'],
                            'store_name' => $seller_info['store_name'],
                        ];
                    }

                    $data['customer_question_answers'][] = [
                        'product_question_answer_id' => $customer_question_answer['product_question_answer_id'],
                        'product_question_id' => $customer_question_answer['product_question_id'],
                        'product_id' => $customer_question_answer['product_id'],
                        'customer_id' => $customer_question_answer['customer_id'],
                        'customer' => $answer_customer_info,
                        'seller_id' => $customer_question_answer['seller_id'],
                        'seller' => $seller_data,
                        'answer' => nl2br($customer_question_answer['answer']),
                        'date_added' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($customer_question_answer['date_added'])),
                        'status' => $customer_question_answer['status'],
                    ];
                }
            }

            $data['logged_in'] = $this->customer->isLoggedIn();

            $data['login'] = $this->url->customerLink('marketplace/account/login');

            // Add customer question answer
            $data['add_customer_question_answer'] = $this->url->customerLink('marketplace/product/customer_question/add_customer_question_answer', ['product_question_id' => $product_question_info['product_question_id']], true); 

            // Get customer question answers
            $data['get_customer_question_answers'] = $this->url->customerLink('marketplace/product/customer_question/get_customer_question_answers', ['product_question_id' => $product_question_info['product_question_id']]); 

            // Header
            $header_params = array(
                'title' => $product_question_info['question'],
                'breadcrumbs' => $breadcrumbs,
            );
            $data['header'] = $this->marketplace_header->index($header_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->marketplace_footer->index($footer_params);

            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Product\customer_question',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        } else {
            $data['message'] = lang('Error.no_data_found', [], $this->language->getCurrentCode());
    
            // Libraries
            $data['language_lib'] = $this->language;

            // Header
            $header_params = array(
                'title' => lang('Heading.not_found', [], $this->language->getCurrentCode()),
            );
            $data['header'] = $this->marketplace_header->index($header_params);
            // Footer
            $footer_params = array();
            $data['footer'] = $this->marketplace_footer->index($footer_params);
    
            // Generate view
            $template_setting = [
                'location' => 'ThemeMarketplace',
                'author' => 'com_openmvm',
                'theme' => 'Basic',
                'view' => 'Common\error',
                'permission' => false,
                'override' => false,
            ];
            return $this->template->render($template_setting, $data);
        }
    }

    public function add_customer_question_answer()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $this->validation->setRule('answer', lang('Entry.answer', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                // Query
                $query = $this->model_product_product_question->addProductQuestionAnswer($this->request->getGet('product_question_id'), $json_data);

                $json['success']['toast'] = lang('Success.product_question_answer_add', [], $this->language->getCurrentCode());
            } else {
                // Errors
                $json['error']['toast'] = lang('Error.form', [], $this->language->getCurrentCode());

                if ($this->validation->hasError('answer')) {
                    $json['error']['answer'] = $this->validation->getError('answer');
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function get_customer_question_answers()
    {
        // Get customer question answers
        $data['customer_question_answers'] = [];

        if (!empty($this->request->getGet('product_question_id'))) {
            $customer_question_answers = $this->model_product_product_question->getProductQuestionAnswers($this->request->getGet('product_question_id'));  

            foreach ($customer_question_answers as $customer_question_answer) {
                // Get customer info
                $customer_info = $this->model_customer_customer->getCustomer($customer_question_answer['customer_id']);

                if ($customer_info) {
                    if (!empty($customer_question_answer['seller_id'])) {
                        // Get seller info
                        $seller_info = $this->model_seller_seller->getSeller($customer_question_answer['seller_id']);

                        $seller_data = $seller_info;
                    } else {
                        $seller_data = [];
                    }

                    // Get product info
                    $product_info = $this->model_product_product->getProduct($customer_question_answer['product_id']);

                    if ($product_info) {
                        $product_seller_id = $product_info['seller_id'];
                    } else {
                        $product_seller_id = 0;
                    }

                    // Get total customer question answer votes
                    $total_customer_question_answer_votes = $this->model_product_product_question->getTotalProductQuestionAnswerVotes($customer_question_answer['product_question_answer_id']);

                    // Get total helpful customer question answer votes
                    $total_helpful_customer_question_answer_votes = $this->model_product_product_question->getTotalProductQuestionAnswerVotes($customer_question_answer['product_question_answer_id'], 1);

                    $data['customer_question_answers'][] = [
                        'product_question_answer_id' => $customer_question_answer['product_question_answer_id'],
                        'product_question_id' => $customer_question_answer['product_question_id'],
                        'product_id' => $customer_question_answer['product_id'],
                        'product_seller_id' => $product_seller_id,
                        'customer_id' => $customer_question_answer['customer_id'],
                        'customer' => $customer_info,
                        'seller_id' => $customer_question_answer['seller_id'],
                        'seller' => $seller_data,
                        'answer' => nl2br($customer_question_answer['answer']),
                        'total_customer_question_answer_votes' => $total_customer_question_answer_votes,
                        'total_helpful_customer_question_answer_votes' => $total_helpful_customer_question_answer_votes,
                        'date_added' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($customer_question_answer['date_added'])),
                        'status' => $customer_question_answer['status'],
                    ];
                }
            }   
        }

        // Vote customer question answer
        $data['vote_customer_question_answer'] = $this->url->customerLink('marketplace/product/customer_question/vote_customer_question_answer', '', true);

        // Libraries
        $data['language_lib'] = $this->language;

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Product\customer_question_answer',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function vote_customer_question_answer()
    {
        $json = [];

        if (!empty($this->request->getPost('product_question_answer_id'))) {
            if ($this->session->has('error_login')) {
                $json['error'] = lang('Error.must_login', [], $this->language->getCurrentCode());
            } else {
                // Edit product question vote
                $query = $this->model_product_product_question->editProductQuestionAnswerVote($this->request->getPost('product_question_answer_id'), $this->request->getPost('vote'));

                // Get total customer question answer votes
                $total_customer_question_answer_votes = $this->model_product_product_question->getTotalProductQuestionAnswerVotes($this->request->getPost('product_question_answer_id'));

                // Get total helpful customer question answer votes
                $total_helpful_customer_question_answer_votes = $this->model_product_product_question->getTotalProductQuestionAnswerVotes($this->request->getPost('product_question_answer_id'), 1);

                $json['vote_text'] = lang('Text.people_found_this_answer_helpful', ['helpful' => $total_helpful_customer_question_answer_votes, 'total' => $total_customer_question_answer_votes]);

                $json['success']['toast'] = lang('Success.product_question_answer_vote');
          
            }
        }

        return $this->response->setJSON($json);
    }
}
