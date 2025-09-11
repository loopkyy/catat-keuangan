@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
        <h2 class="mb-2 mb-md-0"><i class="bi bi-wallet2 me-2"></i> Sumber Pemasukan</h2>
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
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Nama Sumber</th>
                            <th class="text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sources as $index => $src)
                            <tr>
                                <td>{{ $sources->firstItem() + $index }}</td>
                                <td>{{ $src->name }}</td>
                                <td class="text-center">
                                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-2">
                                        <a href="{{ route('sources.edit', $src->id) }}"
                                           class="btn btn-warning text-dark btn-sm w-100 w-sm-auto">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('sources.destroy', $src->id) }}" method="POST" class="delete-form w-100 w-sm-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete w-100 w-sm-auto">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
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

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $sources->links('custom-pagination') }}
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                let form = this.closest('form');
                Swal.fire({
                    title: 'Yakin?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
