@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Kategori</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('categories.update', $category->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" 
                    name="name" 
                    id="name" 
                    class="form-control" 
                    value="{{ old('name', $category->name) }}" 
                    placeholder="Masukkan nama kategori" 
                    required
                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" 
                    onblur="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle"></i> Update
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection
