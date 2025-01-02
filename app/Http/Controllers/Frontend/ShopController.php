<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
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

        return view('frontend.shop', compact('categories', 'products', 'brands', 'colors', 'selectedColor'));
    }
}
