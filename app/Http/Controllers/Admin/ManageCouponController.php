<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Models\Coupon;

class ManageCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::paginate(5);
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
        return view('admin.coupon.edit', compact('coupon', 'coupon'));
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
