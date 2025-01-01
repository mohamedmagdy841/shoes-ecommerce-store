<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice</title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }
        .font{
            font-size: 15px;
        }
        .authority {
            /*text-align: center;*/
            float: right
        }
        .authority h5 {
            margin-top: -10px;
            color: #ffc107;
            /*text-align: center;*/
            margin-left: 35px;
        }
        .thanks p {
            color: #ffc107;
            font-size: 16px;
            font-weight: normal;
            font-family: serif;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
    <tr>
        <td valign="top">
            <!-- {{-- <img src="" alt="" width="150"/> --}} -->
            <h2 style="color: #ffc107; font-size: 26px;"><strong>{{$getSetting->site_name}}</strong></h2>
        </td>
        <td align="right">
            <pre class="font" >
               {{$getSetting->site_name}} Head Office <br>
               Email: {{$getSetting->email}} <br>
               Phone: {{$getSetting->phone}} <br>
               {{$getSetting->full_address}} <br>

            </pre>
        </td>
    </tr>
</table>
<table width="100%" style="background:white; padding:2px;"></table>
<table width="100%" style="background: #F7F7F7; padding:0 5px 0 5px;" class="font">
    <tr>
        <td>
            <p class="font" style="margin-left: 20px;">
                <strong>Name:</strong> {{ auth()->user()->name }} <br>
                <strong>Email:</strong> {{ auth()->user()->email }} <br>
                <strong>Phone:</strong> {{ auth()->user()->phone }} <br>
                <strong>Address:</strong> {{ auth()->user()->full_address }}
            </p>
        </td>
        <td>
            <p class="font">
                <strong>Invoice:</strong> #{{ $order->id }}<br>
                <strong>Order Date:</strong> {{ $order->created_at->format("M d, Y h:i A") }} <br>
                <strong>Payment Method:</strong> {{ $order->payment_method }}
            </p>

        </td>
    </tr>
</table>
<br/>
<h3>Products</h3>
<table width="100%">
    <thead style="background-color: #ffc107; color:#FFFFFF;">
    <tr class="font">
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($order->items as $item)
        <tr class="font">
            <td align="center">{{ $item->product->full_name }}</td>
            <td align="center">{{ $item->quantity }}</td>
            <td align="center">{{ Number::currency($item->price, 'EGP')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>
<table width="100%" style=" padding:0 10px 0 10px;">
    <tr>
        <td align="right" >
            @if ($order->discount_amount)
                <h3><span style="color: #ffc107;">Discount:</span> - {{ Number::currency($order->discount_amount, 'EGP') }}</h3>
            @endif
            <h2><span style="color: #ffc107;">Total:</span> {{ Number::currency($order->total_price, 'EGP') }}</h2>
        </td>
    </tr>
</table>
<div class="thanks mt-3">
    <p>Thanks For Buying Products..!!</p>
</div>
<div class="authority float-right mt-5">
    <p>-----------------------------------</p>
    <h5>Authority Signature:</h5>
</div>
</body>
</html>
