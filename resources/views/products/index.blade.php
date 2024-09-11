<x-layout>
    <h1 class="text-center" >Products</h1><hr>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#productModal">
        Add Product
    </button>
    <table class="table table-bordered" id="products-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-product-form />
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="notificationMessage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.data') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'price', name: 'price'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']]
            });

            function showNotification(message) {
                $('#notificationMessage').text(message);
                var notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
                notificationModal.show();
            }

            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.find('input[name="_method"]').val() || 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: form.serialize(),
                    success: function(response) {
                        $('#productModal').modal('hide');
                        table.ajax.reload();
                        showNotification(response.success);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        showNotification('An error occurred. Please try again.');
                    }
                });
            });

            $(document).on('click', '.edit-product', function() {
                var productId = $(this).data('id');
                $.get("{{ route('products.get', ':id') }}".replace(':id', productId), function(data) {
                    $('#productForm').attr('action', "{{ route('products.update', ':id') }}".replace(':id', productId));
                    $('#productForm').append('<input type="hidden" name="_method" value="PUT">');
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#price').val(data.price);
                    $('#quantity').val(data.quantity);
                    $('#productModalLabel').text('Edit Product');
                    $('#productModal').modal('show');
                });
            });

            var deleteProductId;

            $(document).on('click', '.delete-product', function() {
                deleteProductId = $(this).data('id');
                var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('products.destroy', ':id') }}".replace(':id', deleteProductId),
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#confirmModal').modal('hide');
                        table.ajax.reload();
                        showNotification(response.success);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#confirmModal').modal('hide');
                        showNotification('An error occurred. Please try again.');
                    }
                });
            });

            $('#productModal').on('hidden.bs.modal', function() {
                $('#productForm').attr('action', "{{ route('products.store') }}");
                $('#productForm').find('input[name="_method"]').remove();
                $('#productForm')[0].reset();
                $('#productModalLabel').text('Add Product');
            });
        });
    </script>
    @endpush
</x-layout>