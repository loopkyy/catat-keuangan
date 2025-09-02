@extends('layouts.app')

@section('content')
<h2>Edit Tujuan Tabungan</h2>
<form method="POST" action="{{ route('goals.update', $goal->id) }}">
    @csrf @method('PUT')
    <label>Nama Tujuan:</label>
    <input type="text" name="name" value="{{ $goal->name }}"><br>

    <label>Target Nominal:</label>
    <input type="number" name="target_amount" value="{{ $goal->target_amount }}"><br>

    <label>Sudah Terkumpul:</label>
    <input type="number" name="saved_amount" value="{{ $goal->saved_amount }}"><br>

    <label>Tanggal Mulai:</label>
    <input type="date" name="start_date" value="{{ $goal->start_date }}"><br>

    <button type="submit">Update</button>
</form>
@endsection
