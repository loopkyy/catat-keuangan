@extends('layouts.app')

@section('content')
<h2>Tambah Kategori</h2>
<form method="POST" action="{{ route('categories.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Nama kategori">
    <button type="submit">Simpan</button>
</form>
@endsection
