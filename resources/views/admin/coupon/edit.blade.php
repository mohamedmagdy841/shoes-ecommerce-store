@extends('admin.master')
@section('title', 'Edit Coupon')
@section('subtitle', 'Edit Coupon')
@section('coupon active', 'active')
@section('content')
    <div class="container py-5">
        <form method="post" action="{{ route('admin.coupons.update', ['coupon' => $coupon]) }}">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" name="code" value="{{ $coupon->code }}" class="form-control" id="code">
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" name="type" id="type" aria-label="Default select example">
                            <option selected disabled>Type</option>
                            <option value="fixed" @selected($coupon->type == 'fixed')>Fixed</option>
                            <option value="percentage" @selected($coupon->type == 'percentage')>Percentage</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $coupon->start_date) }}" id="start_date" class="form-control"/>
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="limit" class="form-label">Limit</label>
                        <input type="number" name="limit" value="{{ $coupon->limit }}" class="form-control" id="limit">
                        <x-input-error :messages="$errors->get('limit')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="value" class="form-label">Value</label>
                        <input type="number" name="value" value="{{ $coupon->value }}" class="form-control" id="value">
                        <x-input-error :messages="$errors->get('value')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $coupon->end_date) }}" id="end_date" class="form-control" />
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const today = new Date().toISOString().split('T')[0];
            startDateInput.min = today;

            startDateInput.addEventListener('change', function () {
                const selectedStartDate = startDateInput.value;
                endDateInput.min = selectedStartDate;

                if (endDateInput.value && endDateInput.value < selectedStartDate) {
                    endDateInput.value = selectedStartDate;
                }
            });
        });
    </script>
@endpush
