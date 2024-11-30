<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'reviews' => function ($query) {
            $query->latest();
        },])->whereSlug($slug)->first();

        $relatedProducts = Product::with('images')->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(8)
            ->get();

        return view('frontend.product', compact('product', 'relatedProducts'));
    }

    public function addReview(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'rating' => 'required',
            'review' => 'nullable',
            'product_id' => 'required|exists:products,id',
        ]);

        $review = Review::create($data);
        if($review)
        {
            notyf()->success('Thank you for your feedback!');
        }
        return redirect()->back();
    }
}
