<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductFilterService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class ApiShopController extends Controller
{
    use HttpResponse;

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
            'price_range' => (array) $request->input('price_range', []),
            'sort_by' => $request->input('sort_by'),
        ];

        $filterOptions = $this->productFilterService->getFilters();
        $products = $this->productFilterService->filterProducts($filters);

        $data = [
            'categories' => CategoryResource::collection($filterOptions['categories']),
            'products' => ProductResource::collection($products)->response()->getData(true),
            'brands' => $filterOptions['brands'],
            'colors' => $filterOptions['colors'],
            'selectedColor' => $filters['colors'],
        ];

        return $this->sendResponse($data, 'Products retrieved successfully.');
    }}
