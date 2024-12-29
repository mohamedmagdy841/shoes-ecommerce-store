<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;

class ProductOrderStatistics extends Component
{
    public function render()
    {
        $latest_products = Product::latest()->take(5)->get();
        $latest_orders = Order::latest()->take(5)->get();

        return view('livewire.admin.product-order-statistics', compact('latest_products', 'latest_orders'));
    }
}
