<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(string $id)
    {
        try {
            $user = auth()->user();
            $product = Product::findOrFail($id);
            if (!$user->wishlist->contains($product)) {
                $user->wishlist()->attach($product->id);
                return response()->json(['message' => 'Product added to wishlist']);
            }
            return response()->json(['message' => 'Product already in your wishlist']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function get()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $wishlist = $user->wishlist;

            if (request()->ajax()) {
                return response()->json(['wishlistCount' => $wishlist->count()], 200);
            }

            return view('frontend.wishlist', compact('wishlist'));

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function remove(string $id)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $user->wishlist()->detach($product->id);
            notyf()->success('Product removed from wishlist');

            return redirect()->back();

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

}
