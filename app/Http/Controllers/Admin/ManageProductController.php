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
        try {
            $products = Product::with('images')->latest()->paginate(5);
            return view('admin.product.index', compact('products'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the products.');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = Category::active()->select('id', 'name')->get();
            return view('admin.product.create', compact('categories'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the categories.');
            return redirect()->back();
        }
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
        try {
            $categories = Category::active()->select('id', 'name')->get();
            return view('admin.product.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the product details.');
            return redirect()->back();
        }
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
        try {
            ImageManager::deleteImages($product);
            $product->delete();
            return response('Product deleted successfully.', 200);
        } catch (\Exception $e) {
            return response('An error occurred while deleting the product.', 500);
        }
    }

    public function changeStatus($id)
    {
        try {
            $product = Product::findOrFail($id);

            $product->update([
                'status' => $product->status == 1 ? 0 : 1,
            ]);

            $message = $product->status == 1
                ? 'Product Is Active Now!'
                : 'Product Deactivated Successfully!';
            notyf()->success($message);

            return redirect()->back();
        } catch (\Exception $e) {
            notyf()->error('An error occurred while changing the product status.');
            return redirect()->back();
        }
    }

}
