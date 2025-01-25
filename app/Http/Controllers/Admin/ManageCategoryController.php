<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ManageCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:add_category|edit_category|delete_category,admin', except: ['index']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::withCount('products')->paginate(5);
            return view('admin.category.index', compact('categories'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the categories.');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            Category::create($data);
            notyf()->success('Category created successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            notyf()->error('An error occurred while creating the category.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $data = $request->validated();
            $category->update($data);
            notyf()->success('Category updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            notyf()->error('An error occurred while updating the category.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response('Category deleted successfully.', 200);
        } catch (\Exception $e) {
            return response('An error occurred while deleting the category.', 500);
        }
    }

    public function changeStatus($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update([
                'status' => $category->status == 1 ? 0 : 1,
            ]);
            $message = $category->status == 1 ? 'Category Is Active Now!' : 'Category Deactivated Successfully!';
            notyf()->success($message);
            return redirect()->back();
        } catch (\Exception $e) {
            notyf()->error('An error occurred while changing the category status.');
            return redirect()->back();
        }
    }
}
