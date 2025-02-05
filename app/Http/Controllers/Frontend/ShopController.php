<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductFilterService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $productFilterService;
    public function __construct(ProductFilterService $productFilterService)
    {
        $this->productFilterService = $productFilterService;
    }

    public function index(Request $request)
    {
        $filters = [
            'categories' => $request->input('categories', []),
            'brands' => $request->input('brands', []),
            'colors' => $request->input('colors', []),
            'price_range' => (array) $request->input('price_range', null),
            'sort_by' => $request->input('sort_by', null),
        ];

        $filterOptions = $this->productFilterService->getFilters();
        $products = $this->productFilterService->filterProducts($filters);

        return view('frontend.shop', array_merge($filterOptions, [
            'products' => $products,
            'selectedColor' => $filters['colors'],
        ]));
    }
}
