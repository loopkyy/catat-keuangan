@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tujuan Tabungan</h2>
    <a href="{{ route('goals.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Tambah Tujuan
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
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Target</th>
                        <th>Terkumpul</th>
                        <th>Progress</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($goals as $g)
                    <tr>
                        <td>{{ $g->name }}</td>
                        <td>Rp {{ number_format($g->target_amount,0,',','.') }}</td>
                        <td>Rp {{ number_format($g->saved_amount,0,',','.') }}</td>
                        <td style="min-width: 150px;">
                            @php
                                $progress = ($g->target_amount > 0) ? round(($g->saved_amount / $g->target_amount) * 100, 2) : 0;
                            @endphp
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $progress }}%;" 
                                     aria-valuenow="{{ $progress }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ $progress }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('goals.edit', $g->id) }}" class="btn btn-warning btn-sm me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('goals.destroy', $g->id) }}" method="POST" class="d-inline delete-form">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada tujuan tabungan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
                text: "Tujuan ini akan dihapus permanen!",
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
