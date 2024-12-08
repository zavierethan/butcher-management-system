@extends('layouts.main')

@section('main-content')
<div>
    <h1>Stocks Content Page</h1>

    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Create New Product</a>

    <div class="table-responsive">
        <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
            <thead>
                <tr class="fw-semibold fs-6 text-muted">
                    <th>Kode</th>
                    <th>Name</th>
                    <th>Harga</th>
                    <th>Actions</th> <!-- Add the Actions column -->
                    {{-- <th>Stok</th> --}}
                    {{-- <th>Cabang</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>${{ $product->price }}</td>
                    <td>
                        <!-- Edit Button with Link to Edit Page -->
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm" style="margin-right: 5px;">Edit</a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                    {{-- <td>{{ $product->quantity ?? 'No Stock' }}</td> --}}
                    {{-- <td>{{ $product->branch_name }}</td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Custom Pagination -->
    <ul class="pagination" style="float: right;">
        @if ($products->onFirstPage())
        <li class="page-item previous disabled">
            <span class="page-link page-text">Previous</span>
        </li>
        @else
        <li class="page-item previous">
            <a href="{{ $products->previousPageUrl() }}" class="page-link page-text">Previous</a>
        </li>
        @endif

        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
        <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
        </li>
        @endforeach

        @if ($products->hasMorePages())
        <li class="page-item next">
            <a href="{{ $products->nextPageUrl() }}" class="page-link page-text">Next</a>
        </li>
        @else
        <li class="page-item next disabled">
            <span class="page-link page-text">Next</span>
        </li>
        @endif
    </ul>



</div>
    @if (session('success'))
    <div class="alert alert-success" id="success-message">
        {{ session('success') }}
    </div>
    @endif

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#kt_datatable_zero_configuration").DataTable({
            responsive: true,
            searching: true,
            paging: true,
            info: true
        });
    });
</script>
@endsection

