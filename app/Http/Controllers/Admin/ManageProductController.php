<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Http\Requests\ProductImportRequest;
use App\Imports\ProductDataImport;
use App\Models\Category;
use App\Models\Product;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ManageProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:add_product|edit_product|delete_product|show_product,admin', except: ['index']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('images')->latest()->paginate(5);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->select('id' , 'name')->get();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $request->validated();
        try {
            DB::beginTransaction();
            $product = Product::create($request->except(['_token', 'images']));

            ImageManager::uploadImages($request, $product);

            DB::commit();
            Cache::forget('home_products');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors', $e->getMessage()]);
        }

        notyf()->success('Product created successfully');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->select('id' , 'name')->get();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $request->validated();

        try{
            DB::beginTransaction();
            $product->update($request->except(['images', '_token']));

            if ($request->hasFile('images')) {
                ImageManager::deleteImages($product);
                ImageManager::uploadImages($request, $product);
            }
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['errors'=>$e->getMessage()]);
        }

        notyf()->success('Product updated successfully');
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        ImageManager::deleteImages($product);
        $product->delete();
        return response('Product deleted successfully.', 200);
    }

    public function changeStatus($id)
    {
        $product = Product::findOrFail($id);

        if ($product->status == 1) {
            $product->update([
                'status' => 0,
            ]);
            notyf()->success('Product Deactivated Successfully!');
        } else {
            $product->update([
                'status' => 1,
            ]);
            notyf()->success('Product Is Active Now!');
        }
        return redirect()->back();
    }

}
