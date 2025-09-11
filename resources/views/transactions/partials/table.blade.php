<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Jenis</th>
                    <th>Kategori / Sumber</th>
                    <th>Jumlah</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        {{-- Tanggal: kapital bulan --}}
                        <td>{{ \Carbon\Carbon::parse($t->date)->translatedFormat('d F Y') }}</td>

                        {{-- Judul & Deskripsi: huruf pertama kapital --}}
                        <td>{{ ucfirst($t->title) }}</td>
                        <td>{{ ucfirst($t->description) }}</td>

                        <td>
                            @if($t->type == 'income')
                                <span class="badge bg-success">Pemasukan</span>
                            @else
                                <span class="badge bg-danger">Pengeluaran</span>
                            @endif
                        </td>

                        {{-- Kategori / Sumber: huruf pertama kapital --}}
                        <td>
                            @if($t->type == 'income')
                                {{ ucfirst($t->source?->name) }}
                            @else
                                {{ ucfirst($t->category?->name) }}
                            @endif
                        </td>

                        {{-- Jumlah pakai format rupiah --}}
                        <td>Rp {{ number_format($t->amount,0,',','.') }}</td>

                        <td class="text-end">
                            <a href="{{ route('transactions.edit', $t->id) }}" class="btn btn-sm btn-warning text-dark">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $t->id }}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                            <form id="delete-form-{{ $t->id }}" action="{{ route('transactions.destroy', $t->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-center">
    {{ $transactions->links('custom-pagination') }}
</div>
