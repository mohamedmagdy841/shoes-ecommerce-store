<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class ApiWishlistController extends Controller
{
    use HttpResponse;

    public function add(string $id)
    {
        $user = auth('sanctum')->user();
        $product = Product::find($id);

        if(!$product)
        {
            return $this->sendResponse([], 'Product not found', 404);
        }

        if(!$user->wishlist->contains($product)){
            $user->wishlist()->attach($product->id);
            return $this->sendResponse(new ProductResource($product), 'Product added to wishlist');
        }

        return $this->sendResponse([], 'Product already in your wishlist');
    }

    public function get()
    {
        $products = auth('sanctum')->user()->wishlist;
        if($products->isEmpty()){
            return $this->sendResponse([], 'Wishlist is empty');
        }
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved');
    }

    public function remove(string $id)
    {
        $product = Product::find($id);

        if(!$product)
        {
            return $this->sendResponse([], 'Product not found', 404);
        }

        $user = auth('sanctum')->user();

        if(!$user->wishlist->contains($product)){
            return $this->sendResponse([], 'You don\'t have a wishlist for this product');
        }

        auth('sanctum')->user()->wishlist()->detach($product->id);
        return $this->sendResponse([], 'Product removed from wishlist');
    }
}
