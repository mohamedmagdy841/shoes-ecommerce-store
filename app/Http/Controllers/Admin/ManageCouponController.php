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
        $coupons = Coupon::latest()->paginate(5);
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(StoreCouponRequest $request)
    {
        Coupon::create($request->validated());
        notyf()->success('Coupon created successfully!');
        return redirect()->back();
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());
        notyf()->success('Coupon updated successfully');
        return redirect()->route('admin.coupons.index');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return response('Coupon deleted successfully.', 200);
    }

}
