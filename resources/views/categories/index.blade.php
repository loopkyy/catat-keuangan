@extends('layouts.app')

@section('content')
<h2>Kategori</h2>
<a href="{{ route('categories.create') }}">Tambah Kategori</a>
@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
<ul>
@foreach($categories as $cat)
    <li>
        {{ $cat->name }}
        <a href="{{ route('categories.edit', $cat->id) }}">Edit</a>
        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </li>
@endforeach
</ul>
@endsection
