@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
    <h2 class="mb-2 mb-sm-0">Kategori Pengeluaran</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-success">
         <i class="bi bi-plus-circle"></i> Tambah Kategori
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Kategori Pengeluaran</th>
                        <th style="width: 220px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $cat)
                        <tr>
                            <td>{{ $categories->firstItem() + $index }}</td>
                            <td>{{ $cat->name }}</td>
                            <td class="text-center">
                                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                    <a href="{{ route('categories.edit', $cat->id) }}" 
                                       class="btn btn-warning btn-sm w-100 w-sm-auto">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="delete-form w-100 w-sm-auto">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm w-100 w-sm-auto btn-delete">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-3 d-flex justify-content-center">
    {{ $categories->links('custom-pagination') }}
</div>

{{-- Script SweetAlert2 --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".btn-delete");

    deleteButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            let form = this.closest("form");

            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data kategori tidak bisa dikembalikan setelah dihapus!",
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
@endsection
