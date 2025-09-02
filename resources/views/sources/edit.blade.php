@extends('layouts.app')

@section('content')
<h2>Edit Sumber Pemasukan</h2>
<form method="POST" action="{{ route('sources.update', $source->id) }}">
    @csrf @method('PUT')
    <input type="text" name="name" value="{{ $source->name }}">
    <button type="submit">Update</button>
</form>
@endsection
