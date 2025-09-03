@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i> Tambah Transaksi</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Jenis</label>
                            <select name="type" id="type" class="form-select" onchange="toggleSelect()" required>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                        </div>

                        <div id="sourceSelect" class="mb-3">
                            <label class="form-label">Sumber Pemasukan</label>
                            <select name="source_id" class="form-select">
                                <option value="">-- pilih sumber --</option>
                                @foreach($sources as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="categorySelect" class="mb-3" style="display:none;">
                            <label class="form-label">Kategori Pengeluaran</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- pilih kategori --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
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

<script>
function toggleSelect(){
    let type = document.getElementById('type').value;
    document.getElementById('sourceSelect').style.display = type === 'income' ? 'block' : 'none';
    document.getElementById('categorySelect').style.display = type === 'expense' ? 'block' : 'none';
}
</script>
@endsection
