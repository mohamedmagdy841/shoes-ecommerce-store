<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function get()
    {
        $userID = auth()->user()->id;
        $items = Cart::session($userID)->getContent();
        $subtotal = Cart::session($userID)->getSubtotal();
        if (request()->ajax()) {
            return response()->json(['cartCount' => $items->count()]);
        }
        return view('frontend.cart', compact('items', 'subtotal'));
    }

    public function add($productId)
    {
        $product = Product::findOrFail($productId);
        $userID = auth()->user()->id;
        Cart::session($userID)->add(array(
            'id' => $productId,
            'name' => $product->full_name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(
                'image' => $product->images->first()->path,
            ),
            'associatedModel' => $product
        ));

        return response()->json(['message' => 'Item added to cart successfully!']);
    }

    public function remove($productId)
    {
        $userID = auth()->user()->id;
        Cart::session($userID)->remove($productId);
        return response()->json(['message' => 'Item removed successfully!']);
    }

    public function updateQuantity($productId, $action)
    {
        $userID = auth()->user()->id;

        $quantityChange = $action === 'increase' ? +1 : -1;

        \Cart::session($userID)->update($productId, [
            'quantity' => $quantityChange,
        ]);

        $message = $action === 'increase'
            ? 'Quantity increased successfully!'
            : 'Quantity decreased successfully!';

        return response()->json(['message' => $message]);
    }

    public function clearCart()
    {
        $userID = auth()->user()->id;
        \Cart::session($userID)->clear();
        notyf()->success('Cart cleared successfully!');
        return redirect()->back();
    }
}
