@extends('layouts.app')

@section('content')
<h2>Edit Transaksi</h2>
<form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
    @csrf
    @method('PUT')

    <label>Judul:</label>
    <input type="text" name="title" value="{{ old('title', $transaction->title) }}"><br>

    <label>Jenis:</label>
    <select name="type" id="type" onchange="toggleSelect()">
        <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Pemasukan</option>
        <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
    </select><br>

    <div id="sourceSelect" style="{{ $transaction->type == 'income' ? '' : 'display:none;' }}">
        <label>Sumber Pemasukan:</label>
        <select name="source_id">
            <option value="">-- pilih sumber --</option>
            @foreach($sources as $s)
                <option value="{{ $s->id }}" {{ $transaction->source_id == $s->id ? 'selected' : '' }}>
                    {{ $s->name }}
                </option>
            @endforeach
        </select><br>
    </div>

    <div id="categorySelect" style="{{ $transaction->type == 'expense' ? '' : 'display:none;' }}">
        <label>Kategori Pengeluaran:</label>
        <select name="category_id">
            <option value="">-- pilih kategori --</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ $transaction->category_id == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select><br>
    </div>

    <label>Jumlah:</label>
    <input type="number" name="amount" value="{{ old('amount', $transaction->amount) }}"><br>

    <label>Tanggal:</label>
    <input type="date" name="date" value="{{ old('date', $transaction->date) }}"><br>

    <label>Deskripsi:</label>
    <textarea name="description">{{ old('description', $transaction->description) }}</textarea><br>

    <button type="submit">Update</button>
</form>

<script>
function toggleSelect(){
    let type = document.getElementById('type').value;
    document.getElementById('sourceSelect').style.display = type === 'income' ? 'block' : 'none';
    document.getElementById('categorySelect').style.display = type === 'expense' ? 'block' : 'none';
}
</script>
@endsection
