<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Stripe\Charge;
use Stripe\Stripe;

class OrderController extends Controller
{

    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(8);
        return view('frontend.order', compact('orders'));
    }

    public function orderInvoiceDownload($id)
    {
        $order = auth()->user()->orders()->with('items.product')->where('status', 'completed')->findOrFail($id);
        $pdf = Pdf::loadView('frontend.invoice_download',compact('order'))
            ->setPaper('a4')->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
        return $pdf->download('invoice.pdf');
    }

}
