@extends('layouts.app')

@section('content')
<h2>Sumber Pemasukan</h2>
<a href="{{ route('sources.create') }}">Tambah Sumber</a>
@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
<ul>
@foreach($sources as $src)
    <li>
        {{ $src->name }}
        <a href="{{ route('sources.edit', $src->id) }}">Edit</a>
        <form action="{{ route('sources.destroy', $src->id) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </li>
@endforeach
</ul>
@endsection
