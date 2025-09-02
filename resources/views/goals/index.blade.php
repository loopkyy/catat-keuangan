@extends('layouts.app')

@section('content')
<h2>Tujuan Tabungan</h2>
<a href="{{ route('goals.create') }}">Tambah Tujuan</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5">
    <tr>
        <th>Nama</th>
        <th>Target</th>
        <th>Terkumpul</th>
        <th>Progress</th>
        <th>Aksi</th>
    </tr>
    @foreach($goals as $g)
    <tr>
        <td>{{ $g->name }}</td>
        <td>Rp {{ number_format($g->target_amount,0,',','.') }}</td>
        <td>Rp {{ number_format($g->saved_amount,0,',','.') }}</td>
        <td>
            {{ round(($g->saved_amount / $g->target_amount) * 100, 2) }}%
        </td>
        <td>
            <a href="{{ route('goals.edit', $g->id) }}">Edit</a> |
            <form action="{{ route('goals.destroy', $g->id) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
