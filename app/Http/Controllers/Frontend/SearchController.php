<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string',
            ]);

            $keyword = strip_tags($request->search);
            $products = Product::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%')
                ->paginate(8);

            return view('frontend.search', compact('products'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

}
