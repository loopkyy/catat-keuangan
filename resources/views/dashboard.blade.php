@extends('layouts.app')

@section('content')
<div class="text-center mb-5" data-aos="fade-down">
    <h2 class="fw-bold">Selamat Datang 👋</h2>
    <p class="text-muted">Ini adalah ringkasan transaksi kamu:</p>
</div>

<div class="row g-4">
    <!-- Pemasukan -->
    <div class="col-12 col-sm-6 col-lg-4" data-aos="zoom-in">
        <div class="card shadow-lg border-0 h-100 hover-card">
            <div class="card-body text-center">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                    <i class="bi bi-arrow-down-circle text-success fs-2"></i>
                </div>
                <h6 class="text-muted">Total Pemasukan</h6>
                <h3 class="fw-bold text-success">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Pengeluaran -->
    <div class="col-12 col-sm-6 col-lg-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="card shadow-lg border-0 h-100 hover-card">
            <div class="card-body text-center">
                <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                    <i class="bi bi-arrow-up-circle text-danger fs-2"></i>
                </div>
                <h6 class="text-muted">Total Pengeluaran</h6>
                <h3 class="fw-bold text-danger">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Saldo -->
    <div class="col-12 col-sm-6 col-lg-4" data-aos="zoom-in" data-aos-delay="400">
        <div class="card shadow-lg border-0 h-100 hover-card">
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px;">
                    <i class="bi bi-wallet2 text-primary fs-2"></i>
                </div>
                <h6 class="text-muted">Saldo</h6>
                <h3 class="fw-bold text-primary">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0,0,0,0.15);
    }
</style>
@endsection
