<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">💰 Catat Keuangan</a>
            <div>
                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-light">Kategori</a>
                <a href="{{ route('sources.index') }}" class="btn btn-sm btn-light">Sumber</a>
                <a href="{{ route('goals.index') }}" class="btn btn-sm btn-light">Goals</a>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light">Transaksi</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
