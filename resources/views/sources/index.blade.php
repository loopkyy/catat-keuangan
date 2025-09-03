@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0"><i class="bi bi-wallet2 me-2"></i> Sumber Pemasukan</h2>
        <a href="{{ route('sources.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Sumber
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Sumber</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sources as $index => $src)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $src->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('sources.edit', $src->id) }}" class="btn btn-sm btn-warning text-dark">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('sources.destroy', $src->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus sumber ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada sumber pemasukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
