<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderDataExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImportRequest;
use App\Imports\OrderDataImport;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;

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
        try {
            $orders = Order::withCount('items')->latest()->paginate(5);
            return view('admin.order.index', compact('orders'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the orders.');
            return redirect()->back();
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,processing,completed,cancelled',
            ]);

            $order->status = $request->status;
            $order->save();

            notyf()->success('Order status has been updated.');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            notyf()->error('An error occurred while updating the order status.');
            return redirect()->back();
        }
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return response()->json('Order has been deleted.', 200);
        } catch (\Exception $e) {
            return response()->json('An error occurred while deleting the order.', 500);
        }
    }

    public function export()
    {
        try {
            return Excel::download(new OrderDataExport(), 'orders.xlsx');
        } catch (\Exception $e) {
            notyf()->error('An error occurred while exporting the orders.');
            return redirect()->back();
        }
    }

}
