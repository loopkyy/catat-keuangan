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

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" id="transactionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                type="button" role="tab">Semua</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="income-tab" data-bs-toggle="tab" data-bs-target="#income"
                type="button" role="tab">Pemasukan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="expense-tab" data-bs-toggle="tab" data-bs-target="#expense"
                type="button" role="tab">Pengeluaran</button>
        </li>
    </ul>

    <div class="tab-content" id="transactionTabsContent">
        {{-- Semua --}}
        <div class="tab-pane fade show active" id="all" role="tabpanel">
            @include('transactions.partials.table', ['transactions' => $transactions])
        </div>
        {{-- Pemasukan --}}
        <div class="tab-pane fade" id="income" role="tabpanel">
            @include('transactions.partials.table', ['transactions' => $transactionsIncome])
        </div>
        {{-- Pengeluaran --}}
        <div class="tab-pane fade" id="expense" role="tabpanel">
            @include('transactions.partials.table', ['transactions' => $transactionsExpense])
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Yakin?',
                text: "Transaksi ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
});
</script>
@endpush
