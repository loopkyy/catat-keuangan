<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h4 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        td.right { text-align: right; }
        tr.total-row td { font-weight: bold; background: #f9f9a9; }
        .summary { margin-top: 20px; padding: 10px; border: 1px solid #333; background: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <h4>
        @if($type === 'all') Semua Transaksi
        @elseif($type === 'income') Pemasukan
        @else Pengeluaran
        @endif
    </h4>
    <p>
        Periode: 
        @if($range === 'today')
            Hari ini ({{ \Carbon\Carbon::today()->translatedFormat('d F Y') }})
        @elseif($range === 'weekly')
            Minggu ini ({{ $start->translatedFormat('d M Y') }} - {{ $end->translatedFormat('d M Y') }})
        @elseif($range === 'monthly')
            Bulan ini ({{ $start->translatedFormat('F Y') }})
        @else
            Semua Waktu
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Jenis</th>
                <th>Kategori / Sumber</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $i => $trx)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                    <td>{{ $trx->title }}</td>
                    <td>{{ $trx->description ?? '-' }}</td>
                    <td>{{ $trx->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                    <td>
                        @if($trx->category)
                            {{ $trx->category->name }}
                        @elseif($trx->source)
                            {{ $trx->source->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="right">Rp {{ number_format($trx->amount,0,',','.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@if($transactions->count() > 0)
    <div class="summary">
        <h4>Ringkasan</h4>
        <p>Saldo Awal: <b>Rp {{ number_format($saldoAwal,0,',','.') }}</b></p>

        @if($type === 'all')
            <p>Total Pemasukan: <b>Rp {{ number_format($totalIncome,0,',','.') }}</b></p>
            <p>Total Pengeluaran: <b>Rp {{ number_format($totalExpense,0,',','.') }}</b></p>
        @elseif($type === 'income')
            <p>Total Pemasukan: <b>Rp {{ number_format($totalIncome,0,',','.') }}</b></p>
        @elseif($type === 'expense')
            <p>Total Pengeluaran: <b>Rp {{ number_format($totalExpense,0,',','.') }}</b></p>
        @endif

        <p>Saldo Akhir: <b>Rp {{ number_format($saldoAkhir,0,',','.') }}</b></p>
    </div>
@endif


</body>
</html>
