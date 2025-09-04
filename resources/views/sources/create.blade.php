@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i> Tambah Sumber Pemasukan</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('sources.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Sumber</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="name" 
                                name="name" 
                                placeholder="Contoh: Gaji, Orang Tua" 
                                required
                                oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                onblur="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sources.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
