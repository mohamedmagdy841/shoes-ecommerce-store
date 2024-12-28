<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ManageOrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:manage_orders,admin', except: ['index']),
        ];
    }

    public function index()
    {
        $orders = Order::withCount('items')->paginate(5);
        return view('admin.order.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        notyf()->success('Order status has been updated.');
        return redirect()->back();
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json('Order has been deleted.');
    }
}
