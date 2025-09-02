@extends('layouts.app')

@section('content')
<h2>Edit Kategori</h2>
<form method="POST" action="{{ route('categories.update', $category->id) }}">
    @csrf @method('PUT')
    <input type="text" name="name" value="{{ $category->name }}">
    <button type="submit">Update</button>
</form>
@endsection
