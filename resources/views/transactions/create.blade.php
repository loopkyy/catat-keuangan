@extends('layouts.app')

@section('content')
<h2>Tambah Transaksi</h2>
<form method="POST" action="{{ route('transactions.store') }}">
    @csrf
    <label>Judul:</label>
    <input type="text" name="title"><br>

    <label>Jenis:</label>
    <select name="type" id="type" onchange="toggleSelect()">
        <option value="income">Pemasukan</option>
        <option value="expense">Pengeluaran</option>
    </select><br>

    <div id="sourceSelect">
        <label>Sumber Pemasukan:</label>
        <select name="source_id">
            <option value="">-- pilih sumber --</option>
            @foreach($sources as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select><br>
    </div>

    <div id="categorySelect" style="display:none;">
        <label>Kategori Pengeluaran:</label>
        <select name="category_id">
            <option value="">-- pilih kategori --</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select><br>
    </div>

    <label>Jumlah:</label>
    <input type="number" name="amount"><br>

    <label>Tanggal:</label>
    <input type="date" name="date"><br>

    <label>Deskripsi:</label>
    <textarea name="description"></textarea><br>

    <button type="submit">Simpan</button>
</form>

<script>
function toggleSelect(){
    let type = document.getElementById('type').value;
    document.getElementById('sourceSelect').style.display = type === 'income' ? 'block' : 'none';
    document.getElementById('categorySelect').style.display = type === 'expense' ? 'block' : 'none';
}
</script>
@endsection
