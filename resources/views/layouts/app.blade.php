<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Keuangan</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .nav-btn {
            margin-left: 0.3rem;
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
        }
        footer {
            margin-top: 3rem;
            padding: 1rem 0;
            text-align: center;
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="bi bi-wallet2"></i> Catat Keuangan
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="ms-auto">
                <a href="{{ route('categories.index') }}" class="btn btn-outline-light btn-sm nav-btn">
                    <i class="bi bi-list-ul"></i> Kategori
                </a>
                <a href="{{ route('sources.index') }}" class="btn btn-outline-light btn-sm nav-btn">
                    <i class="bi bi-cash-stack"></i> Sumber
                </a>
                <a href="{{ route('goals.index') }}" class="btn btn-outline-light btn-sm nav-btn">
                    <i class="bi bi-flag"></i> Goals
                </a>
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-light btn-sm nav-btn">
                    <i class="bi bi-journal-text"></i> Transaksi
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="container my-4">
    @yield('content')
</div>

<footer>
    &copy; {{ date('Y') }} Catat Keuangan. Made with <i class="bi bi-heart-fill text-danger"></i>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
