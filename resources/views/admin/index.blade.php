@extends('admin.master')
@section('title', __('keywords.home'))
@section('subtitle', __('keywords.home'))
@section('home active', 'active')
@section('content')
    <div class="container-fluid py-4">
        @livewire('admin.admin-dashboard-statistics')

        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card z-index-2">
                    <div class="card-body p-4">
                        <h4>{{ $orders_chart->options['chart_title'] }}</h4>
                        {!! $orders_chart->renderHtml() !!}
                    </div>
                </div>
            </div>
            <div class="col-4 mb-lg-0 mb-4">
                <div class="card z-index-2">
                    <div class="card-body p-4">
                        <h4>{{ $products_chart->options['chart_title'] }}</h4>
                        {!! $products_chart->renderHtml() !!}
                    </div>
                </div>
            </div>
        </div>

        @livewire('admin.product-order-statistics')
        <footer class="footer pt-3  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                            for a better web.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
@push('js')
    {!! $orders_chart->renderChartJsLibrary() !!}
    {!! $products_chart->renderChartJsLibrary() !!}

    {!! $orders_chart->renderJs() !!}
    {!! $products_chart->renderJs() !!}
@endpush
