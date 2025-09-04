@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kategori</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Tambah Kategori
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <ul class="list-group list-group-flush">
            @forelse($categories as $cat)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $cat->name }}</span>
                    <div>
                        <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm btn-delete">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="list-group-item text-center text-muted">Belum ada kategori.</li>
            @endforelse
        </ul>
    </div>
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
