<?php

namespace Main\Marketplace\Controllers\Seller;

class Product_Question extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Models
        $this->model_customer_customer = new \Main\Marketplace\Models\Customer\Customer_Model();
        $this->model_seller_product = new \Main\Marketplace\Models\Seller\Product_Model();
        $this->model_seller_product_question = new \Main\Marketplace\Models\Seller\Product_Question_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
    }

    public function index()
    {
        $data = [];

        return $this->get_list($data);
    }

    public function edit()
    {
        $data['heading_title'] = lang('Heading.product_question_edit', [], $this->language->getCurrentCode());

        $data['action'] = $this->url->customerLink('marketplace/seller/product_question/save/' . $this->uri->getSegment($this->uri->getTotalSegments()), '', true);

        return $this->get_form($data);
    }

    public function get_list($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.questions', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/product_question', '', true),
            'active' => true,
        );

        $data['heading_title'] = lang('Heading.questions', [], $this->language->getCurrentCode());

        // Get product questions
        $data['product_questions'] = [];

        $product_questions = $this->model_seller_product_question->getProductQuestions();

        foreach ($product_questions as $product_question) {
            // Get product info
            $product_info = $this->model_seller_product->getProduct($product_question['product_id']);

            if ($product_info) {
                // Get product description
                $product_description = $this->model_seller_product->getProductDescription($product_info['product_id']);

                $data['product_questions'][] = [
                    'product_question_id' => $product_question['product_question_id'],
                    'product_id' => $product_question['product_id'],
                    'product' => $product_description['name'],
                    'total_answer' => $this->model_seller_product_question->getTotalProductQuestionAnswers($product_question['product_question_id']),
                    'customer_id' => $product_question['customer_id'],
                    'question' => $product_question['question'],
                    'date_added' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($product_question['date_added'])),
                    'status' => $product_question['status'],
                    'edit' => $this->url->customerLink('marketplace/seller/product_question/edit/' . $product_question['product_question_id'], '', true),
                ];
            }
        }

        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => lang('Heading.questions', [], $this->language->getCurrentCode()),
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
            'view' => 'Seller\product_question_list',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function get_form($data)
    {
        $breadcrumbs[] = array(
            'text' => lang('Text.home', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('/'),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.my_account', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/account/account', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.questions', [], $this->language->getCurrentCode()),
            'href' => $this->url->customerLink('marketplace/seller/product_question', '', true),
            'active' => false,
        );

        $breadcrumbs[] = array(
            'text' => lang('Text.edit', [], $this->language->getCurrentCode()),
            'href' => '',
            'active' => true,
        );
        
        $product_question_info = $this->model_seller_product_question->getProductQuestion($this->uri->getSegment($this->uri->getTotalSegments()));

        if ($product_question_info) {
            $data['product_question_id'] = $product_question_info['product_question_id'];
        } else {
            $data['product_question_id'] = 0;
        }

        if ($product_question_info) {
            $data['product_id'] = $product_question_info['product_id'];
        } else {
            $data['product_id'] = 0;
        }

        if ($product_question_info) {
            $data['customer_id'] = $product_question_info['customer_id'];
        } else {
            $data['customer_id'] = 0;
        }

        if ($product_question_info) {
            $data['question'] = $product_question_info['question'];
        } else {
            $data['question'] = '';
        }

        if ($product_question_info) {
            $data['date_added'] = date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($product_question_info['date_added']));
        } else {
            $data['date_added'] = '';
        }

        $data['add_product_question_answer'] = $this->url->customerLink('marketplace/seller/product_question/add_product_question_answer', '', true);
        $data['get_product_question_answers'] = $this->url->customerLink('marketplace/seller/product_question/get_product_question_answers', ['product_question_id' => $data['product_question_id']], true);

        $data['language_lib'] = $this->language;

        // Header
        $header_params = array(
            'title' => $data['heading_title'],
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
            'view' => 'Seller\product_question_form',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }

    public function add_product_question_answer()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $json_data = $this->request->getJSON(true);

            $this->validation->setRule('answer', lang('Entry.answer', [], $this->language->getCurrentCode()), 'required');

            if ($this->validation->withRequest($this->request)->run($json_data)) {
                // Query
                $query = $this->model_seller_product_question->addProductQuestionAnswer($this->request->getGet('product_question_id'), $json_data);

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

    public function get_product_question_answers()
    {
        // Get product question answers
        $data['product_question_answers'] = [];

        if (!empty($this->request->getGet('product_question_id'))) {
            $product_question_answers = $this->model_seller_product_question->getProductQuestionAnswers($this->request->getGet('product_question_id'));  

            foreach ($product_question_answers as $product_question_answer) {
                // Get customer info
                $customer_info = $this->model_customer_customer->getCustomer($product_question_answer['customer_id']);

                if ($customer_info) {
                    if (!empty($product_question_answer['seller_id'])) {
                        // Get seller info
                        $seller_info = $this->model_seller_seller->getSeller($product_question_answer['seller_id']);

                        $seller_data = $seller_info;
                    } else {
                        $seller_data = [];
                    }

                    $data['product_question_answers'][] = [
                        'product_question_answer_id' => $product_question_answer['product_question_answer_id'],
                        'product_question_id' => $product_question_answer['product_question_id'],
                        'product_id' => $product_question_answer['product_id'],
                        'customer_id' => $product_question_answer['customer_id'],
                        'customer' => $customer_info,
                        'seller_id' => $product_question_answer['seller_id'],
                        'seller' => $seller_data,
                        'answer' => nl2br($product_question_answer['answer']),
                        'date_added' => date(lang('Common.date_format', [], $this->language->getCurrentCode()), strtotime($product_question_answer['date_added'])),
                        'status' => $product_question_answer['status'],
                    ];
                }
            }   
        }

        // Libraries
        $data['language_lib'] = $this->language;

        // Generate view
        $template_setting = [
            'location' => 'ThemeMarketplace',
            'author' => 'com_openmvm',
            'theme' => 'Basic',
            'view' => 'Seller\product_question_answer',
            'permission' => false,
            'override' => false,
        ];
        return $this->template->render($template_setting, $data);
    }
}
