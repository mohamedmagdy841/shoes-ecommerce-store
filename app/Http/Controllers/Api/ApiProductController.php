<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    use HttpResponse;

    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'reviews' => function ($query) {
            $query->latest();
        },])->whereSlug($slug)->first();

        $relatedProducts = Product::with('images')->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(8)
            ->get()
            ->each(function ($related) {
                $related->is_related = true; // flag for related products
            });

        $data = [
            'product' => ProductResource::make($product),
            'relatedProducts' => ProductResource::collection($relatedProducts),
        ];

        return $this->sendResponse($data, 'Product retrieved successfully.');
    }

    public function addReview(Request $request)
    {
        $review = Review::create($request->validated());
        return $this->sendResponse(ReviewResource::make($review), 'Review submitted successfully', 201);
    }
}
