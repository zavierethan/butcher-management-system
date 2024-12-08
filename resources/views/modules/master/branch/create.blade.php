@extends('layouts.main')

@section('main-content')
<div>
    <h1>Tambah Cabang Baru</h1>

    <form action="{{ route('branches.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="code">Kode</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="price">Alamat</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
