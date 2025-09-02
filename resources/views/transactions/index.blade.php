@extends('layouts.app')

@section('content')
<h2>Daftar Transaksi</h2>
<a href="{{ route('transactions.create') }}">Tambah Transaksi</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<h4>Ringkasan:</h4>
<ul>
    <li>Total Pemasukan: Rp {{ number_format($totalIncome,0,',','.') }}</li>
    <li>Total Pengeluaran: Rp {{ number_format($totalExpense,0,',','.') }}</li>
    <li>Saldo Akhir: Rp {{ number_format($balance,0,',','.') }}</li>
</ul>

<table border="1" cellpadding="5">
    <tr>
        <th>Tanggal</th>
        <th>Judul</th>
        <th>Jenis</th>
        <th>Kategori/Sumber</th>
        <th>Jumlah</th>
        <th>Aksi</th>
    </tr>
    @foreach($transactions as $t)
    <tr>
        <td>{{ $t->date }}</td>
        <td>{{ $t->title }}</td>
        <td>{{ $t->type }}</td>
        <td>
            @if($t->type == 'income')
                {{ $t->source?->name }}
            @else
                {{ $t->category?->name }}
            @endif
        </td>
        <td>Rp {{ number_format($t->amount,0,',','.') }}</td>
        <td>
            <a href="{{ route('transactions.edit', $t->id) }}">Edit</a> | 
            <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
