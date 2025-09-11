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
    <!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        main {
            flex: 1;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .nav-btn {
            margin: 0.2rem 0.2rem;
        }
        footer {
            margin-top: auto;
            padding: 1rem 0;
            text-align: center;
            background-color: #343a40;
            color: white;
            font-size: 0.9rem;
        }
        footer a {
            color: #0d6efd;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
       <a class="navbar-brand" href="{{ url('/') }}" title="Kembali ke Dashboard">
    <i class="bi bi-wallet2"></i> Catat Keuangan
</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

<div class="collapse navbar-collapse" id="navbarNav">
    <div class="ms-auto">
        <div class="d-flex flex-column flex-lg-row gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-list-ul"></i> Kategori
            </a>
            <a href="{{ route('sources.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-cash-stack"></i> Sumber
            </a>
            <a href="{{ route('goals.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-flag"></i> Goals
            </a>
            <a href="{{ route('transactions.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-journal-text"></i> Transaksi
            </a>
        </div>
    </div>
</div>


</nav>

<!-- CONTENT -->
<main class="container my-4">
    @yield('content')
</main>

<!-- FOOTER -->
<footer>
    &copy; {{ date('Y') }} Catat Keuangan. Made with  
    <a href="https://github.com/loopkyy" target="_blank">loopkyy</a>
</footer>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800, // durasi animasi
        once: true     // animasi hanya jalan sekali
    });
</script>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts') 
</body>
</html>
