<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class ApiHomeController extends Controller
{
    use HttpResponse;
    public function index()
    {
        $home_products = Product::active()->with('images')->latest()->limit(16)->get();
        $cheapest_products = Product::active()->with('images')->orderBy('price')->limit(9)->get();
        $categories = Category::active()->get();

        $data = [
            'home_products' => ProductResource::collection($home_products),
            'cheapest_products' => ProductResource::collection($cheapest_products),
            'categories' => CategoryResource::collection($categories)
        ];
        return $this->sendResponse($data, 'Success', 200);
    }
}
