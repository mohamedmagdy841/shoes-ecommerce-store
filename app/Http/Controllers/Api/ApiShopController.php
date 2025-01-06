<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class ApiShopController extends Controller
{
    use HttpResponse;

    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Product::groupBy('brand')->pluck('brand');
        $colors = Product::groupBy('color')->pluck('color');

        $selectedCategories = $request->input('categories', []);
        $selectedBrand = $request->input('brands', []);
        $selectedColor = $request->input('colors', []);
        $priceRange = $request->input('price_range');
        $sortBy = $request->input('sort_by');

        $products = Product::with('images')
            ->active()
            ->when(!empty($selectedCategories), function ($query) use ($selectedCategories) {
                $query->whereIn('category_id', $selectedCategories);})
            ->when(!empty($selectedBrand), function ($query) use ($selectedBrand) {
                $query->whereIn('brand', $selectedBrand);})
            ->when(!empty($selectedColor), function ($query) use ($selectedColor) {
                $query->whereIn('color', $selectedColor);})
            ->when($priceRange, function ($query) use ($priceRange) {
                if ($priceRange === '50-100') {
                    $query->whereBetween('price', [50, 100]);
                } elseif ($priceRange === '100-150') {
                    $query->whereBetween('price', [100, 150]);
                } elseif ($priceRange === '150-200') {
                    $query->whereBetween('price', [150, 200]);
                } elseif ($priceRange === '200-above') {
                    $query->where('price', '>=', 200);
                }})
            ->when($sortBy, function ($query) use ($sortBy) {
                if ($sortBy === 'price_asc') {
                    $query->orderBy('price', 'asc');
                } elseif ($sortBy === 'price_desc') {
                    $query->orderBy('price', 'desc');
                }})
            ->paginate(12)->withQueryString();

        $data = [
            'categories' => CategoryResource::collection($categories),
            'products' => ProductResource::collection($products),
            'brands' => $brands,
            'colors' => $colors,
            'selectedColor' => $selectedColor,
        ];

        return $this->sendResponse($data, 'Products retrieved successfully.');
    }
}
