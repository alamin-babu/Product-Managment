<form id="productForm" action="{{ $product ? route('products.update', $product->id) : route('products.store') }}" method="POST">
    @csrf
    @if($product)
        @method('PUT')
    @endif
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" required>{{ $product->description ?? '' }}</textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $product->price ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity ?? '' }}" required>
    </div>
    <button type="submit" class="btn btn-primary">{{ $product ? 'Update' : 'Add' }} Product</button>
</form>