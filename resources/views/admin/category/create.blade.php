<!-- Modal -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModaladd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModaladd">Add New Category</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <label>Name</label>
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                    </div>
                    <label>Status</label>
                    <div class="input-group mb-3">
                        <select class="form-select" name="status" aria-label="Default select example">
                            <option selected>Select Category Status</option>
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                        </select></div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn bg-gradient-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
