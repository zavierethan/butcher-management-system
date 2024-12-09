@extends('layouts.main')

@section('main-content')
<div>
    <h1>Master Data Cabang</h1>

    <a href="{{ route('branches.create') }}" class="btn btn-success mb-3">Tambah Cabang Baru</a>

    <div class="table-responsive">
        <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
            <thead>
                <tr class="fw-semibold fs-6 text-muted">
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($branches as $branch)
                <tr>
                    <td>{{ $branch->code }}</td>
                    <td>{{ $branch->name }}</td>
                    <td>${{ $branch->address }}</td>
                    <td>
                        <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-primary btn-sm" style="margin-right: 5px;">Edit</a>

                        <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this branch?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Custom Pagination -->
    <ul class="pagination" style="float: right;">
        @if ($branches->onFirstPage())
        <li class="page-item previous disabled">
            <span class="page-link page-text">Previous</span>
        </li>
        @else
        <li class="page-item previous">
            <a href="{{ $branches->previousPageUrl() }}" class="page-link page-text">Previous</a>
        </li>
        @endif

        @foreach ($branches->getUrlRange(1, $branches->lastPage()) as $page => $url)
        <li class="page-item {{ $page == $branches->currentPage() ? 'active' : '' }}">
            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
        </li>
        @endforeach

        @if ($branches->hasMorePages())
        <li class="page-item next">
            <a href="{{ $branches->nextPageUrl() }}" class="page-link page-text">Next</a>
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

