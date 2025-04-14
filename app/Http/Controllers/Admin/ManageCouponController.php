<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ManageCouponController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:add_coupon|edit_coupon|delete_coupon,admin', except: ['index']),
        ];
    }
    public function index()
    {
        try {
            $coupons = Coupon::latest()->paginate(5);
            return view('admin.coupon.index', compact('coupons'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the coupons. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            return view('admin.coupon.create');
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the create coupon page. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(StoreCouponRequest $request)
    {
        try {
            Coupon::create($request->validated());
            notyf()->success('Coupon created successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            notyf()->error('An error occurred while creating the coupon. ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit(Coupon $coupon)
    {
        try {
            return view('admin.coupon.edit', compact('coupon'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the edit coupon page. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        try {
            $coupon->update($request->validated());
            notyf()->success('Coupon updated successfully');
            return redirect()->route('admin.coupons.index');
        } catch (\Exception $e) {
            notyf()->error('An error occurred while updating the coupon. ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Coupon $coupon)
    {
        try {
            $coupon->delete();
            return response('Coupon deleted successfully.', 200);
        } catch (\Exception $e) {
            return response('An error occurred while deleting the coupon. ' . $e->getMessage(), 500);
        }
    }

}
