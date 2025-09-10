@extends('layouts.app')

@section('content')
<div class="text-center mb-4">
    <h2>Selamat Datang 👋</h2>
    <p>Ini adalah ringkasan transaksi kamu:</p>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">Total Pemasukan</div>
            <div class="card-body text-center text-success">
                <h4>Rp {{ number_format($pemasukan, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">Total Pengeluaran</div>
            <div class="card-body text-center text-danger">
                <h4>Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">Saldo</div>
            <div class="card-body text-center text-primary">
                <h4>Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
</div>
@endsection
