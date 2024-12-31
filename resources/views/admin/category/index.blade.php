@extends('admin.master')
@section('title', __('keywords.manage') . ' ' . __('keywords.categories'))
@section('subtitle', __('keywords.manage') . ' ' . __('keywords.categories'))
@section('category active', 'active')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">

        @if(auth('admin')->user()->can('add_category'))
            <div class="text-end">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#addNew">
                        {{ __('keywords.add_new_category') }}
                    </button>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            @include('admin.category.create')
       @endif

    <div class="card mb-4">
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center m-3">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-s font-weight-bolder">#</th>
                        <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.name') }}</th>
                        <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.number_of_products') }}</th>
                        <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.created_at') }}</th>
                        @if(auth('admin')->user()->can('delete_category'))
                            <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.status') }}</th>
                            <th class="text-uppercase text-s font-weight-bolder">{{ __('keywords.action') }}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $key => $category)
                        <tr>
                            <td class="align-middle">
                                <span class=" text-s">{{ $loop->iteration + $categories->firstItem() - 1 }}</span>
                            </td>
                            <td class="align-middle">
                                <span class=" text-s">{{ $category->name }}</span>
                            </td>
                            <td class="align-middle">
                                <span class=" text-s">{{ $category->products_count }}</span>
                            </td>
                            <td class="align-middle">
                                <span class=" text-s">{{ $category->created_at->format('Y-m-d h:i a') }}</span>
                            </td>
                            <td class="align-middle">
                                @if(auth('admin')->user()->can('delete_category'))
                                    <a href="{{ route('admin.categories.changeStatus', $category->id) }}">
                                    <span class="badge badge-sm bg-gradient-@if($category->status==1)success @else()danger @endif ">{{ $category->status==1?'Active':'Not Active' }}</span>
                                    </a>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if(auth('admin')->user()->can('edit_category'))
                                    <a href="javascript:void(0)" class="badge badge-sm bg-gradient-info" data-bs-toggle="modal"
                                       data-bs-target="#edit-category-{{ $category->id }}"><i class="fa fa-edit"></i></a>
                                @endif

                                    @if(auth('admin')->user()->can('delete_category'))
                                    <form method="POST" class="delete-form" style="display: inline"  data-route="{{route('admin.categories.destroy',$category)}}">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" style="border: 0" class="badge badge-sm bg-gradient-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @if(auth('admin')->user()->can('add_category'))
                            {{-- edit Category modal --}}
                            @include('admin.category.edit')
                            {{-- end edit category modal --}}
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="align-middle text-center"><span class="text-m font-weight-bold">No Categories</span></td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection

@push('js')
<script type="text/javascript">
$(document).ready(function() {

$('.delete-form').on('submit', function(e) {
    e.preventDefault();
    var button = $(this);

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: button.data('route'),
                data: {
                    '_method': 'delete'
                },
                success: function (response, textStatus, xhr) {
                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: "#ffba00",
                        title: response,
                    }).then((result) => {
                        window.location='/admin/categories'
                    });
                }
            });
        }
    });

})
});
</script>
@endpush
