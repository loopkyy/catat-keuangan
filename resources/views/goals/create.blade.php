@extends('layouts.app')

@section('content')
<h2>Tambah Tujuan Tabungan</h2>
<form method="POST" action="{{ route('goals.store') }}">
    @csrf
    <label>Nama Tujuan:</label>
    <input type="text" name="name"><br>

    <label>Target Nominal:</label>
    <input type="number" name="target_amount"><br>

    <label>Tanggal Mulai:</label>
    <input type="date" name="start_date"><br>

    <button type="submit">Simpan</button>
</form>
@endsection
