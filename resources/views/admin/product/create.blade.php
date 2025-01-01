@extends('admin.master')
@section('title', 'Add New Product')
@section('product active', 'active')
@section('content')
    <div class="container py-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                There were some errors with your request.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <select class="form-select" name="brand" id="brand" aria-label="Default select example">
                            <option selected>Brand</option>
                            <option value="Adidas">Adidas</option>
                            <option value="Nike">Nike</option>
                            <option value="Puma">Puma</option>
                        </select>
                        <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category_id">
                            <option >Select Category</option>
                            @if(count($categories) > 0)
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="price">
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" aria-label="Default select example">
                            <option selected>Select Product Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="qty" value="{{ old('qty') }}" class="form-control" id="quantity">
                        <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" name="color" value="{{ old('color') }}" class="form-control" id="color">
                        <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="width" class="form-label">Width</label>
                        <input type="number" name="width" value="{{ old('width') }}" class="form-control" id="width">
                        <x-input-error :messages="$errors->get('width')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="height" class="form-label">Height</label>
                        <input type="number" name="height" value="{{ old('height') }}" class="form-control" id="height">
                        <x-input-error :messages="$errors->get('height')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="depth" class="form-label">Depth</label>
                        <input type="number" name="depth" value="{{ old('depth') }}" class="form-control" id="depth">
                        <x-input-error :messages="$errors->get('depth')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="weight" class="form-label">Weight</label>
                        <input type="number" name="weight" value="{{ old('weight') }}" class="form-control" id="weight">
                        <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Upload Images</label>
                        <input class="form-control" name="images[]" type="file" id="images" multiple>
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
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
    <script type="text/javascript">
    </script>
@endpush
