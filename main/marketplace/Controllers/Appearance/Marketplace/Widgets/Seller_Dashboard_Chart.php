<?php

namespace Main\Marketplace\Controllers\Appearance\Marketplace\Widgets;

class Seller_Dashboard_Chart extends \App\Controllers\BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Library
        $this->calendar = new \App\Libraries\Calendar();
        $this->currency = new \App\Libraries\Currency();
        $this->customer = new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->request = \Config\Services::request();
        $this->setting = new \App\Libraries\Setting();
        $this->template = new \App\Libraries\Template();
        $this->url = new \App\Libraries\Url();
        // Model
        $this->model_appearance_widget = new \Main\Marketplace\Models\Appearance\Widget_Model();
        $this->model_appearance_widgets_seller_dashboard_chart = new \Main\Marketplace\Models\Appearance\Widgets\Seller_Dashboard_Chart_Model();
        $this->model_seller_seller = new \Main\Marketplace\Models\Seller\Seller_Model();
        $this->model_seller_order = new \Main\Marketplace\Models\Seller\Order_Model();
    }

    public function index($widget_id)
    {
        static $widget = 0;     

        // Get widget info
        $widget_info = $this->model_appearance_widget->getWidget($widget_id);

        if ($widget_info) {
            $setting = $widget_info['setting'];

            $data['widget_id'] = $widget_id;

            // Get seller info
            $seller_info = $this->model_seller_seller->getSeller($this->customer->getSellerId());

            if ($seller_info) {
                // Generate years
                $data['years'] = [];

                for ($i = 1900; $i < date("Y") + 1; $i++) {
                    $data['years'][] = $i;
                }

                arsort($data['years']);

                $data['url_appearance_marketplace_widget_seller_dashboard_chart_get_orders'] = $this->url->customerLink('marketplace/appearance/marketplace/widgets/seller_dashboard_chart/get_orders', '', true);
                $data['url_appearance_marketplace_widget_seller_dashboard_chart_get_revenue'] = $this->url->customerLink('marketplace/appearance/marketplace/widgets/seller_dashboard_chart/get_revenue', '', true);
                $data['url_appearance_marketplace_widget_seller_dashboard_chart_get_months'] = $this->url->customerLink('marketplace/appearance/marketplace/widgets/seller_dashboard_chart/get_months', '', true);
                $data['url_appearance_marketplace_widget_seller_dashboard_chart_get_days'] = $this->url->customerLink('marketplace/appearance/marketplace/widgets/seller_dashboard_chart/get_days', '', true);

                $data['language_lib'] = $this->language;

                $data['widget'] = $widget++;
                
                // Generate view
                $template_setting = [
                    'location' => 'ThemeMarketplace',
                    'author' => 'com_openmvm',
                    'theme' => 'Basic',
                    'view' => 'Appearance\Marketplace\Widgets\seller_dashboard_chart',
                    'permission' => false,
                    'override' => false,
                ];
                return $this->template->render($template_setting, $data);
            }
        }
    }

    public function get_orders()
    {
        $json = [];

        $filter_data = [];

        $results = [];

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'day') {
            $filter_data = [
                'filter_date' => null,
            ];

            $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalOrdersByDay($this->customer->getSellerId(), $filter_data);
        }

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'week') {
            $filter_data = [];

            $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalOrdersByWeek($this->customer->getSellerId(), $filter_data);
        }

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'month') {
            $filter_data = [
                'filter_year' => null,
                'filter_month' => null,
            ];

            $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalOrdersByMonth($this->customer->getSellerId(), $filter_data);
        }

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'year') {
            $filter_data = [
                'filter_year' => null,
            ];

            $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalOrdersByYear($this->customer->getSellerId(), $filter_data);
        }

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'custom') {
            $filter_data = [
                'filter_date' => $this->request->getPost('year') . '-' . $this->request->getPost('month') . '-' . $this->request->getPost('day'),
                'filter_year' => $this->request->getPost('year'),
                'filter_month' => $this->request->getPost('month'),
                'filter_day' => $this->request->getPost('day'),
            ];

            if (!empty($this->request->getPost('day'))) {
                $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalOrdersByDay($this->customer->getSellerId(), $filter_data);
            } elseif ($this->request->getPost('month')) {
                $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalOrdersByMonth($this->customer->getSellerId(), $filter_data);
            } elseif ($this->request->getPost('year')) {
                $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalOrdersByYear($this->customer->getSellerId(), $filter_data);
            }
        }

        $chart_data = [
            'datasets' => [
                [
                    'label' => lang('Text.orders', [], $this->language->getCurrentCode()),
                    'data'=> $results,
                    'backgroundColor' => ["#36a2eb"],
                    'borderWidth'=> 0,
                ]
            ],
        ];
//file_put_contents(WRITEPATH . 'temp/openmvm.log', json_encode($results));
        $json['results'] = $chart_data;

        $json['alert'] = json_encode($this->request->getPost());

        return $this->response->setJSON($json);
    }

    public function get_revenue()
    {
        $json = [];

        $filter_data = [];

        $results = [];

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'day') {
            $filter_data = [
                'filter_date' => null,
            ];

            $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalRevenueByDay($this->customer->getSellerId(), $filter_data);
        }

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'week') {
            $filter_data = [];

            $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalRevenueByWeek($this->customer->getSellerId(), $filter_data);
        }

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'month') {
            $filter_data = [
                'filter_year' => null,
                'filter_month' => null,
            ];

            $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalRevenueByMonth($this->customer->getSellerId(), $filter_data);
        }

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'year') {
            $filter_data = [
                'filter_year' => null,
            ];

            $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalRevenueByYear($this->customer->getSellerId(), $filter_data);
        }

        if (!empty($this->request->getPost('type')) && $this->request->getPost('type') == 'custom') {
            $filter_data = [
                'filter_date' => $this->request->getPost('year') . '-' . $this->request->getPost('month') . '-' . $this->request->getPost('day'),
                'filter_year' => $this->request->getPost('year'),
                'filter_month' => $this->request->getPost('month'),
                'filter_day' => $this->request->getPost('day'),
            ];

            if (!empty($this->request->getPost('day'))) {
                $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalRevenueByDay($this->customer->getSellerId(), $filter_data);
            } elseif ($this->request->getPost('month')) {
                $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalRevenueByMonth($this->customer->getSellerId(), $filter_data);
            } elseif ($this->request->getPost('year')) {
                $results = $this->model_appearance_widgets_seller_dashboard_chart->getTotalRevenueByYear($this->customer->getSellerId(), $filter_data);
            }
        }

        $chart_data = [
            'datasets' => [
                [
                    'label' => lang('Text.revenue_in', ['currency' => 'USD'], $this->language->getCurrentCode()),
                    'data'=> $results,
                    'backgroundColor' => ["#ff6384"],
                    'borderWidth'=> 0,
                ]
            ],
        ];
//file_put_contents(WRITEPATH . 'temp/openmvm.log', json_encode($results));
        $json['results'] = $chart_data;

        $json['alert'] = json_encode($this->request->getPost());

        return $this->response->setJSON($json);
    }

    public function get_months()
    {
        $json = [];

        $json['months'] = $this->calendar->getMonths();

        return $this->response->setJSON($json);
    }

    public function get_days()
    {
        $json = [];

        if (!empty($this->request->getPost('year'))) {
            $year = $this->request->getPost('year');
        } else {
            $year = 0;
        }

        if (!empty($this->request->getPost('month'))) {
            $month = $this->request->getPost('month');
        } else {
            $month = 0;
        }

        if (!empty($year) && !empty($month)) {
            $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            for ($i = 1; $i <= $number; $i++) {
                $json['days'][] = $i;
            }
        } else {
            $json['days'] = [];
        }

        return $this->response->setJSON($json);
    }
}
