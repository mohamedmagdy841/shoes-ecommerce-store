<!-- Modal -->
<div class="modal fade" id="edit-category-{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModaledit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModaledit">View Details</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" name="brand" value="{{ $product->brand }}" class="form-control" id="brand">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" value="{{ $product->category->name }}" class="form-control" id="category">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" value="{{ $product->price }}" class="form-control" id="price">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" name="status" value="{{ $product->status==1?'Active':'Not Active' }}" class="form-control" id="status">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description">{{ $product->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="qty" value="{{ $product->qty }}" class="form-control" id="quantity">
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" name="color" value="{{ $product->color }}" class="form-control" id="color">
                        </div>
                        <div class="mb-3">
                            <label for="width" class="form-label">Width</label>
                            <input type="number" name="width" value="{{ $product->width }}" class="form-control" id="width">
                        </div>
                        <div class="mb-3">
                            <label for="height" class="form-label">Height</label>
                            <input type="number" name="height" value="{{ $product->height }}" class="form-control" id="height">
                        </div>
                        <div class="mb-3">
                            <label for="depth" class="form-label">Depth</label>
                            <input type="number" name="depth" value="{{ $product->depth }}" class="form-control" id="depth">
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" name="weight" value="{{ $product->weight }}" class="form-control" id="weight">
                        </div>
                    </div>
                        <div class="mb-3">
                            <img class="img-fluid" src="{{ asset('storage/'.$product->images->first()->path) }}" alt="{{$product->full_name}}">
                        </div>
                </div>

            </div>
        </div>
    </div>
</div>
