@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">✏️ Edit Transaksi</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" 
                           value="{{ old('title', $transaction->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis</label>
                    <select name="type" id="type" class="form-select" onchange="toggleSelect()">
                        <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>

                <div id="sourceSelect" class="mb-3" style="{{ $transaction->type == 'income' ? '' : 'display:none;' }}">
                    <label class="form-label">Sumber Pemasukan</label>
                    <select name="source_id" class="form-select">
                        <option value="">-- pilih sumber --</option>
                        @foreach($sources as $s)
                            <option value="{{ $s->id }}" {{ $transaction->source_id == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="categorySelect" class="mb-3" style="{{ $transaction->type == 'expense' ? '' : 'display:none;' }}">
                    <label class="form-label">Kategori Pengeluaran</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- pilih kategori --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ $transaction->category_id == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="amount" class="form-control" 
                           value="{{ old('amount', $transaction->amount) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="date" class="form-control" 
                           value="{{ old('date', $transaction->date) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $transaction->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
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
