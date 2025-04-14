<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class ApiOrderController extends Controller
{
    use HttpResponse;

    public function index()
    {
        $orders = auth('sanctum')->user()->orders()->with('items.product')->latest()->paginate(8);
        if($orders->isEmpty()){
            return $this->sendResponse([], 'No orders found');
        }
        return $this->sendResponse($orders, 'Orders retrieved successfully.');
    }

    public function orderInvoiceDownload($id)
    {
        try {
            $order = auth('sanctum')->user()
                ->orders()
                ->with('items.product')
                ->where('status', 'completed')
                ->findOrFail($id);

            // Generate the PDF
            $pdf = Pdf::loadView('frontend.invoice_download', compact('order'))
                ->setPaper('a4')
                ->setOption([
                    'tempDir' => public_path(),
                    'chroot' => public_path(),
                ]);

            // Return the PDF as a response
            return response($pdf->download(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice.pdf"',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Order not found or not completed',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
