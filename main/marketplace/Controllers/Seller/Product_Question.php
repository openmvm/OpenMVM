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
        $this->model_seller_product = new \Main\Marketplace\Models\Seller\Product_Model();
        $this->model_seller_product_question = new \Main\Marketplace\Models\Seller\Product_Question_Model();
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
        
        $product_question_info = $this->model_seller_product_question->getProductQuestion($this->customer->getId(), $this->uri->getSegment($this->uri->getTotalSegments()));

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
}
