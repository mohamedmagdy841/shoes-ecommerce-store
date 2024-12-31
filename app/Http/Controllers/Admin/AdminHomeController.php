<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class AdminHomeController extends Controller
{
    public function index()
    {
        $orders_chart_options = [
            'chart_title' => __('keywords.orders_by_month'),
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'line',


        ];

        $products_chart_options = [
            'chart_title' => __('keywords.products_by_category'),
            'report_type' => 'group_by_relationship',
            'model' => 'App\Models\Product',
            'relationship_name' => 'category',
            'group_by_field' => 'name',
            'chart_height' => 100,
            'chart_type' => 'pie',

        ];

        $orders_chart = new LaravelChart($orders_chart_options);
        $products_chart = new LaravelChart($products_chart_options);

        return view('admin.index', compact('orders_chart', 'products_chart'));
    }
}
