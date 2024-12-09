@extends('layouts.main')

@section('main-content')
<div>
    <h1>Edit Product</h1>
    
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="code">Product Code</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $product->code }}" required>
        </div>
        
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}" required>
            @if ($errors->has('price'))
                <div class="alert alert-danger">
                    {{ $errors->first('price') }}
                </div>
            @endif
        </div>
        
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        var priceInput = document.querySelector('input[name="price"]');
        var priceValue = priceInput.value.trim();

        // Regex for valid positive decimal numbers with up to two decimal places
        var priceRegex = /^\d+(\.\d{1,2})?$/;

        // Check if the price is invalid
        if (!priceRegex.test(priceValue)) {
            e.preventDefault();  // Prevent form submission
            alert('Please enter a valid price (positive number with up to two decimal places).');
            priceInput.focus();  // Focus on the price input
        }
    });
</script>
@endsection
