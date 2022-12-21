<?php

namespace Main\Marketplace\Models\Appearance\Widgets;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Seller_Dashboard_Chart_Model extends Model
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        // Libraries
        $this->setting = new \App\Libraries\Setting();
        $this->customer = new \App\Libraries\Customer();
        $this->language = new \App\Libraries\Language();
        $this->text = new \App\Libraries\Text();
        // Helpers
        helper('date');
    }

    public function getTotalOrdersByDay($seller_id, $data = [])
    {
        $order_data = [];

        if (!empty($data['filter_date'])) {
            $selected_date = 'DATE("' . $data['filter_date'] . '")';
        } else {
            $selected_date = 'DATE(NOW())';
        }

        for ($i = 1; $i < 25; $i++) {
            $order_data[$i] = 0;
        }

        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('COUNT(o.order_id) AS total, HOUR(o.date_added) AS hour');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));
        $order_builder->where('DATE(o.date_added)', $selected_date, false);

        $order_builder->groupBy('HOUR(o.date_added)');

        $order_builder->orderBy('o.date_added', 'ASC');

        $order_query = $order_builder->get();

        foreach ($order_query->getResult() as $result) {
            $order_data[$result->hour] = $result->total;
        }

        return $order_data;
    }

    public function getTotalOrdersByWeek($seller_id, $data = [])
    {
        $order_data = [];

        $date_start = strtotime('-' . date('w') . ' days');

        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', $date_start + ($i * 86400));

            $order_data[date('D', strtotime($date))] = 0;
        }

        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('COUNT(o.order_id) AS total, o.date_added');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));
        $order_builder->where('DATE(o.date_added)', 'DATE("' . date('Y-m-d', $date_start) . '")', false);

        $order_builder->groupBy('DAYNAME(o.date_added)');

        $order_query = $order_builder->get();

        foreach ($order_query->getResult() as $result) {
            $order_data[date('D', strtotime($result['date_added']))] = $result->total;
        }

        return $order_data;
    }

    public function getTotalOrdersByMonth($seller_id, $data = [])
    {
        $order_data = [];

        if (!empty($data['filter_year']) && !empty($data['filter_month'])) {
            $selected_year = $data['filter_year'];
            $selected_month = $data['filter_month'];
        } else {
            $selected_year = date('Y');
            $selected_month = date('m');
        }

        for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year); $i++) {
            $date = $selected_year . '-' . $selected_month . '-' . $i;

            $order_data[date('j', strtotime($date))] = 0;
        }

        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('COUNT(o.order_id) AS total, o.date_added');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));
        $order_builder->where('DATE(o.date_added) >=', 'DATE("' . $selected_year . '-' . $selected_month . '-1")', false);
        $order_builder->where('MONTH(o.date_added)', $selected_month, false);
        $order_builder->where('YEAR(o.date_added)', $selected_year, false);

        $order_builder->groupBy('DATE(o.date_added)');

        $order_query = $order_builder->get();

        foreach ($order_query->getResult() as $result) {
            $order_data[date('j', strtotime($result->date_added))] = $result->total;
        }

        return $order_data;
    }

    public function getTotalOrdersByYear($seller_id, $data = [])
    {
        $order_data = [];

        if (!empty($data['filter_year'])) {
            $selected_year = $data['filter_year'];
        } else {
            $selected_year = 'YEAR(NOW())';
        }

        for ($i = 1; $i <= 12; $i++) {
            $order_data[date('M', mktime(0, 0, 0, $i))] = 0;
        }

        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('COUNT(o.order_id) AS total, o.date_added');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));
        $order_builder->where('YEAR(o.date_added)', $selected_year, false);

        $order_builder->groupBy('MONTH(o.date_added)');

        $order_query = $order_builder->get();

        foreach ($order_query->getResult() as $result) {
            $order_data[date('M', strtotime($result->date_added))] = $result->total;
        }

        return $order_data;
    }

    public function getTotalRevenueByDay($seller_id, $data = [])
    {
        $order_data = [];

        if (!empty($data['filter_date'])) {
            $selected_date = 'DATE("' . $data['filter_date'] . '")';
        } else {
            $selected_date = 'DATE(NOW())';
        }

        for ($i = 1; $i < 25; $i++) {
            $order_data[$i] = 0;
        }

        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('SUM(ot.value) AS total, HOUR(o.date_added) AS hour');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));
        $order_builder->where('DATE(o.date_added)', $selected_date, false);

        $order_builder->groupBy('HOUR(o.date_added)');

        $order_builder->orderBy('o.date_added', 'ASC');

        $order_query = $order_builder->get();

        foreach ($order_query->getResult() as $result) {
            $order_data[$result->hour] = $result->total;
        }

        return $order_data;
    }

    public function getTotalRevenueByWeek($seller_id, $data = [])
    {
        $order_data = [];

        $date_start = strtotime('-' . date('w') . ' days');

        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', $date_start + ($i * 86400));

            $order_data[date('D', strtotime($date))] = 0;
        }

        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('SUM(ot.value) AS total, o.date_added');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));
        $order_builder->where('DATE(o.date_added)', 'DATE("' . date('Y-m-d', $date_start) . '")', false);

        $order_builder->groupBy('DAYNAME(o.date_added)');

        $order_query = $order_builder->get();

        foreach ($order_query->getResult() as $result) {
            $order_data[date('D', strtotime($result['date_added']))] = $result->total;
        }

        return $order_data;
    }

    public function getTotalRevenueByMonth($seller_id, $data = [])
    {
        $order_data = [];

        if (!empty($data['filter_year']) && !empty($data['filter_month'])) {
            $selected_year = $data['filter_year'];
            $selected_month = $data['filter_month'];
        } else {
            $selected_year = date('Y');
            $selected_month = date('m');
        }

        for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year); $i++) {
            $date = $selected_year . '-' . $selected_month . '-' . $i;

            $order_data[date('j', strtotime($date))] = 0;
        }

        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('SUM(ot.value) AS total, o.date_added');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));
        $order_builder->where('DATE(o.date_added) >=', 'DATE("' . $selected_year . '-' . $selected_month . '-1")', false);
        $order_builder->where('MONTH(o.date_added)', $selected_month, false);
        $order_builder->where('YEAR(o.date_added)', $selected_year, false);

        $order_builder->groupBy('DATE(o.date_added)');

        $order_query = $order_builder->get();

        foreach ($order_query->getResult() as $result) {
            $order_data[date('j', strtotime($result->date_added))] = $result->total;
        }

        return $order_data;
    }

    public function getTotalRevenueByYear($seller_id, $data = [])
    {
        $order_data = [];

        if (!empty($data['filter_year'])) {
            $selected_year = $data['filter_year'];
        } else {
            $selected_year = 'YEAR(NOW())';
        }

        for ($i = 1; $i <= 12; $i++) {
            $order_data[date('M', mktime(0, 0, 0, $i))] = 0;
        }

        $order_builder = $this->db->table('order_total ot');
        $order_builder->join('order o', 'ot.order_id = o.order_id');

        $order_builder->select('SUM(ot.value) AS total, o.date_added');
        
        $order_builder->where('ot.seller_id', $seller_id);
        $order_builder->where('ot.code', 'sub_total');
        $order_builder->where('o.order_status_id', $this->setting->get('setting_completed_order_status_id'));
        $order_builder->where('YEAR(o.date_added)', $selected_year, false);

        $order_builder->groupBy('MONTH(o.date_added)');

        $order_query = $order_builder->get();

        foreach ($order_query->getResult() as $result) {
            $order_data[date('M', strtotime($result->date_added))] = $result->total;
        }

        return $order_data;
    }
}