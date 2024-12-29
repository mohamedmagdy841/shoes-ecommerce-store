<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class AdminDashboardStatistics extends Component
{
    public function render()
    {
        $categories_count = Category::count();
        $products_count = Product::count();
        $users_count = User::count();
        $orders_count = Order::count();

        return view('livewire.admin.admin-dashboard-statistics', get_defined_vars());
    }
}
