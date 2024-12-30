<div>
    <div class="row my-4">
        <div class="col-lg-7 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-body px-0 pt-0 pb-2">

                    <div class="table ">
                        <h4 class="p-4">Latest Products</h4>
                        <table class="table align-items-center m-3">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">#</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Name</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Category</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Price</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Qty</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($latest_products as $key => $product)
                                <tr>
                                    <td class="align-middle">
                                        <span class="text-sm">{{ $loop->iteration }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-sm">{{ $product->full_name }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-sm">{{ $product->category->name }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-sm">{{ Number::currency($product->price, 'EGP') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-sm">{{ $product->qty }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-sm bg-gradient-@if($product->status==1)success @else()danger @endif ">{{ $product->status==1?'Active':'Not Active' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="align-middle text-center"><span class="text-m font-weight-bold">No Products</span></td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-6">
            <div class="card">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table p-0">
                        <h4 class="p-4">Latest Orders</h4>
                        <table class="table align-items-center m-3">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Order ID</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Ordered By</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Total Price</th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($latest_orders as $key => $order)
                                <tr>
                                    <td class="align-middle">
                                        <span class="text-sm">{{ $order->id }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-sm">{{ $order->user->name }}</span>
                                    </td>
                                    <td class="align-middle">
                                            <span
                                                class="text-sm">{{ Number::currency($order->total_price, 'EGP') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-sm bg-gradient-@if($order->status=="cancelled")danger @else()success @endif ">{{ $order->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="align-middle text-center"><span
                                            class="text-m font-weight-bold">No orders</span></td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
