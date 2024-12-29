<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class GeneralSearchController extends Controller
{
    public function search(Request $request)
    {
        if($request->option == 'user'){
            return  $this->searchUsers($request);

        }elseif($request->option == 'order'){
            return  $this->searchOrders($request);

        }elseif($request->option== 'category'){
            return  $this->searchCategories($request);

        }elseif($request->option == 'product'){
            return  $this->searchProducts($request);

        }else{
            return redirect()->back();
        }
    }

    private function searchUsers($request)
    {
        $users = User::where('name' , 'LIKE' , '%'.$request->keyword.'%')->paginate(3)->withQueryString();
        return view('admin.user.index' , compact('users'));
    }
    private function searchCategories($request)
    {
        $categories = Category::where('name' , 'LIKE' , '%'.$request->keyword.'%')->paginate(3)->withQueryString();
        return view('admin.category.index' , compact('categories'));

    }
    private function searchOrders($request)
    {
        $orders = Order::where('status' , 'LIKE' , '%'.$request->keyword.'%')->paginate(3)->withQueryString();
        return view('admin.order.index' , compact('orders'));
    }
    private function searchProducts($request)
    {
        $products = Product::where('name' , 'LIKE' , '%'.$request->keyword.'%')
            ->orWhere('brand' , 'LIKE' , '%'.$request->keyword.'%')
            ->paginate(3)
            ->withQueryString();
        return view('admin.product.index' , compact('products'));
    }
}
