@extends('layouts.main')

@section('main-content')
<div>
    <h1>Edit Cabang</h1>
    
    <form action="{{ route('branches.update', $branch->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="code">Kode Cabang</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $branch->code }}" required>
        </div>
        
        <div class="form-group">
            <label for="name">Nama Cabang</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $branch->name }}" required>
        </div>
        
        <div class="form-group">
            <label for="address">Alamat</label>
            <input type="text" class="form-control" name="address" value="{{ old('address', $branch->address) }}" required>
        </div>
        
        <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
