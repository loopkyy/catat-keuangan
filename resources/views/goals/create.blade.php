@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="mb-0"><i class="bi bi-plus-lg"></i> Tambah Tujuan Tabungan</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('goals.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Tujuan</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama tujuan" required>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="target_amount" class="form-label">Target Nominal</label>
                <input type="number" name="target_amount" id="target_amount" class="form-control" placeholder="Rp" required>
                @error('target_amount')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
                @error('start_date')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check2-circle"></i> Simpan
            </button>
            <a href="{{ route('goals.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection
