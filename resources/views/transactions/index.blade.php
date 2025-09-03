@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0"><i class="bi bi-cash-stack me-2"></i> Daftar Transaksi</h2>
        <a href="{{ route('transactions.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Transaksi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Ringkasan Saldo --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Total Pemasukan</h6>
                    <h4 class="text-success">Rp {{ number_format($totalIncome,0,',','.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Total Pengeluaran</h6>
                    <h4 class="text-danger">Rp {{ number_format($totalExpense,0,',','.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Saldo Akhir</h6>
                    <h4 class="text-primary">Rp {{ number_format($balance,0,',','.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Kategori / Sumber</th>
                        <th>Jumlah</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                        <tr>
                            <td>{{ $t->date }}</td>
                            <td>{{ $t->title }}</td>
                            <td>
                                @if($t->type == 'income')
                                    <span class="badge bg-success">Pemasukan</span>
                                @else
                                    <span class="badge bg-danger">Pengeluaran</span>
                                @endif
                            </td>
                            <td>
                                @if($t->type == 'income')
                                    {{ $t->source?->name }}
                                @else
                                    {{ $t->category?->name }}
                                @endif
                            </td>
                            <td>Rp {{ number_format($t->amount,0,',','.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('transactions.edit', $t->id) }}" class="btn btn-sm btn-warning text-dark">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus transaksi ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
