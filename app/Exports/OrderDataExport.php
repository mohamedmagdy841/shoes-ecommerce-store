<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromArray;

class OrderDataExport implements FromArray
{

    public function array(): array
    {
        $list=[];
        $orders=Order::all();
        foreach ($orders as $order) {
            $list[]=[$order->id, $order->user_id,$order->total_price,$order->payment_method,$order->created_at];
        }
        return $list;
    }
}
