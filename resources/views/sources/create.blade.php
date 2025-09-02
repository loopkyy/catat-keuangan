@extends('layouts.app')

@section('content')
<h2>Tambah Sumber Pemasukan</h2>
<form method="POST" action="{{ route('sources.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Nama sumber">
    <button type="submit">Simpan</button>
</form>
@endsection
