<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(string $id)
    {
        $user = auth()->user();
        $product = Product::findOrFail($id);
        if (!$user->wishlist->contains($product)) {
            $user->wishlist()->attach($product->id);
            return response()->json(['message' => 'Product added to wishlist']);
        }
        return response()->json(['message' => 'Product already in your wishlist']);
    }

    public function get()
    {
        $wishlist = auth()->user()->wishlist;
        if (request()->ajax()) {
            return response()->json(['wishlistCount' => $wishlist->count()]);
        }
        return view('frontend.wishlist', compact('wishlist'));
    }

    public function remove(string $id)
    {
        $product = Product::findOrFail($id);
        auth()->user()->wishlist()->detach($product->id);
        notyf()->success('Product removed from wishlist');
        return redirect()->back();}

}
